@extends('layouts.app')

@section('title', 'Gestion des Inscriptions')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Inscriptions</h1>
    </div>

    <!-- Filtres -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtres de recherche</h6>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="status_filter" class="form-label">Statut</label>
                        <select class="form-select" id="status_filter" name="status">
                            <option value="">Tous les statuts</option>
                            <option value="en attente">En attente</option>
                            <option value="accepté">Accepté</option>
                            <option value="refusé">Refusé</option>
                            <option value="en cours">En cours</option>
                            <option value="achevé">Achevé</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="study_level_filter" class="form-label">Niveau d'étude</label>
                        <select class="form-select" id="study_level_filter" name="study_level_id">
                            <option value="">Tous les niveaux</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="student_name_filter" class="form-label">Nom de l'élève</label>
                        <input type="text" class="form-control" id="student_name_filter" name="student_name" placeholder="Rechercher par nom...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="button" class="btn btn-primary" id="filterBtn">
                                <i class="fas fa-filter"></i> Filtrer
                            </button>
                            <button type="button" class="btn btn-secondary" id="resetBtn">
                                <i class="fas fa-undo"></i> Réinitialiser
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Actions en lot -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Actions sur les inscriptions sélectionnées</h6>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success" id="validateSelectedBtn" disabled>
                    <i class="fas fa-check"></i> Valider les sélectionnées
                </button>
                <button type="button" class="btn btn-danger" id="rejectSelectedBtn" disabled>
                    <i class="fas fa-times"></i> Rejeter les sélectionnées
                </button>
                <span class="badge bg-info fs-6 align-self-center ms-3" id="selectedCount">0 sélectionnée(s)</span>
            </div>
        </div>
    </div>

    <!-- Liste des inscriptions -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Liste des inscriptions - Année {{ date("Y") . "-" . (date("Y")+1) }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="inscriptionsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Élève</th>
                            <th>Niveau d'étude</th>
                            <th>Année scolaire</th>
                            <th>Statut</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inscriptionsBody">
                        <!-- Les données seront chargées via AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3" id="loadingSpinner">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalTitle">Confirmer l'action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="confirmModalBody">
                <!-- Contenu dynamique -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirmer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("header_elements")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedInscriptions = [];

    // Charger les niveaux d'étude
    loadStudyLevels();

    // Charger les inscriptions au démarrage
    loadInscriptions();

    // Event listeners
    document.getElementById('filterBtn').addEventListener('click', loadInscriptions);
    document.getElementById('resetBtn').addEventListener('click', resetFilters);
    document.getElementById('selectAll').addEventListener('change', selectAllInscriptions);
    document.getElementById('validateSelectedBtn').addEventListener('click', () => showConfirmModal('validate'));
    document.getElementById('rejectSelectedBtn').addEventListener('click', () => showConfirmModal('reject'));

    function loadStudyLevels() {
        fetch('/students/study-levels')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('study_level_filter');
                data.forEach(level => {
                    const option = document.createElement('option');
                    option.value = level.id;
                    option.textContent = level.specification;
                    select.appendChild(option);
                });
            });
    }

    function loadInscriptions() {
        const formData = new FormData(document.getElementById('filterForm'));
        const params = new URLSearchParams(formData);

        document.getElementById('loadingSpinner').style.display = 'block';
        document.getElementById('inscriptionsBody').innerHTML = '';

        fetch(`/students/inscriptions/filter?${params}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingSpinner').style.display = 'none';
                displayInscriptions(data.inscriptions);
            });
    }

    function displayInscriptions(inscriptions) {
        const tbody = document.getElementById('inscriptionsBody');
        tbody.innerHTML = '';

        if (inscriptions.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">Aucune inscription trouvée</td></tr>';
            return;
        }

        inscriptions.forEach(inscription => {
            const row = createInscriptionRow(inscription);
            tbody.appendChild(row);
        });

        updateSelectedCount();
    }

    function createInscriptionRow(inscription) {
        const row = document.createElement('tr');

        const statusBadge = getStatusBadge(inscription.status);

        row.innerHTML = `
            <td>
                <input type="checkbox" class="inscription-checkbox" value="${inscription.id}">
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <div>
                        <div class="fw-bold">${inscription.student.firstname} ${inscription.student.lastname}</div>
                        <div class="text-muted small">${inscription.student.email}</div>
                    </div>
                </div>
            </td>
            <td>
                <span class="badge bg-primary">${inscription.study_level.specification}</span>
            </td>
            <td>${inscription.school_year_id}</td>
            <td>${statusBadge}</td>
            <td>${new Date(inscription.created_at).toLocaleDateString('fr-FR')}</td>
            <td>
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-success" onclick="validateInscription(${inscription.id})" 
                            ${inscription.status === 'accepté' ? 'disabled' : ''}>
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="rejectInscription(${inscription.id})"
                            ${inscription.status === 'refusé' ? 'disabled' : ''}>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </td>
        `;

        const checkbox = row.querySelector('.inscription-checkbox');
        checkbox.addEventListener('change', updateSelectedInscriptions);

        return row;
    }

    function getStatusBadge(status) {
        const badges = {
            'en attente': '<span class="badge bg-warning">En attente</span>',
            'accepté': '<span class="badge bg-success">Accepté</span>',
            'refusé': '<span class="badge bg-danger">Refusé</span>',
            'en cours': '<span class="badge bg-info">En cours</span>',
            'achevé': '<span class="badge bg-secondary">Achevé</span>'
        };
        return badges[status] || '<span class="badge bg-secondary">Inconnu</span>';
    }

    function updateSelectedInscriptions() {
        const checkboxes = document.querySelectorAll('.inscription-checkbox:checked');
        selectedInscriptions = Array.from(checkboxes).map(cb => cb.value);
        updateSelectedCount();
        updateBulkActionButtons();
    }

    function updateSelectedCount() {
        document.getElementById('selectedCount').textContent = `${selectedInscriptions.length} sélectionnée(s)`;
    }

    function updateBulkActionButtons() {
        const hasSelection = selectedInscriptions.length > 0;
        document.getElementById('validateSelectedBtn').disabled = !hasSelection;
        document.getElementById('rejectSelectedBtn').disabled = !hasSelection;
    }

    function selectAllInscriptions() {
        const checkboxes = document.querySelectorAll('.inscription-checkbox');
        const selectAll = document.getElementById('selectAll');

        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });

        updateSelectedInscriptions();
    }

    function resetFilters() {
        document.getElementById('filterForm').reset();
        loadInscriptions();
    }

    function showConfirmModal(action) {
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const title = document.getElementById('confirmModalTitle');
        const body = document.getElementById('confirmModalBody');
        const confirmBtn = document.getElementById('confirmActionBtn');

        if (action === 'validate') {
            title.textContent = 'Valider les inscriptions';
            body.innerHTML = `Êtes-vous sûr de vouloir valider ${selectedInscriptions.length} inscription(s) ?`;
            confirmBtn.className = 'btn btn-success';
            confirmBtn.textContent = 'Valider';
            confirmBtn.onclick = () => processSelectedInscriptions('validate');
        } else {
            title.textContent = 'Rejeter les inscriptions';
            body.innerHTML = `Êtes-vous sûr de vouloir rejeter ${selectedInscriptions.length} inscription(s) ?`;
            confirmBtn.className = 'btn btn-danger';
            confirmBtn.textContent = 'Rejeter';
            confirmBtn.onclick = () => processSelectedInscriptions('reject');
        }

        modal.show();
    }

    function processSelectedInscriptions(action) {
            const selectedCheckboxes = document.querySelectorAll('.inscription-checkbox:checked');
            const inscriptionIds = Array.from(selectedCheckboxes).map(cb => cb.value);

            if (inscriptionIds.length === 0) {
                alert('Veuillez sélectionner au moins une inscription');
                return;
            }

            const actionText = action === 'validate' ? 'valider' : 'rejeter';
            if (!confirm(`Êtes-vous sûr de vouloir ${actionText} ${inscriptionIds.length} inscription(s) ?`)) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('Erreur: Token CSRF non trouvé');
                return;
            }

            fetch('/students/inscriptions/bulk-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                },
                body: JSON.stringify({
                    inscriptions: inscriptionIds,
                    action: action
                })
            })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Fermer le modal
                bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();

                // Recharger les inscriptions
                loadInscriptions();

                // Réinitialiser les sélections
                selectedInscriptions = [];
                document.getElementById('selectAll').checked = false;
                updateSelectedCount();
                updateBulkActionButtons();

                // Afficher un message de succès
                showAlert('success', data.message);
            } else {
                showAlert('danger', data.message);
            }
        });
    }

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.container-fluid').firstChild);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    // Fonctions globales pour les actions individuelles
    window.validateInscription = function(id) {
        processSelectedInscriptions('validate', [id]);
    };

    window.rejectInscription = function(id) {
        processSelectedInscriptions('reject', [id]);
    };
});
</script>
@endsection