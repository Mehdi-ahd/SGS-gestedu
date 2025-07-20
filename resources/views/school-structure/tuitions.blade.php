
@extends("layouts.app")

@section("title", "Frais scolaires")

@section("header_elements")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("styles")
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #1cc88a;
        --success-color: #1cc88a;
        --danger-color: #e74a3b;
        --warning-color: #f6c23e;
        --info-color: #36b9cc;
        --dark-color: #5a5c69;
        --light-color: #f8f9fc;
        --sidebar-width: 14rem;
        --sidebar-collapsed-width: 6.5rem;
        --topbar-height: 4.375rem;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background-color: var(--light-color);
        overflow-x: hidden;
    }

    /* Navigation tabs */
    .structure-nav {
        background-color: #fff;
        border-radius: 0.35rem;
        padding: 0.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .structure-nav .nav-link {
        color: var(--dark-color);
        border: none;
        border-radius: 0.25rem;
        padding: 0.75rem 1.25rem;
        margin: 0 0.125rem;
        transition: all 0.15s ease-in-out;
        font-weight: 400;
    }

    .structure-nav .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(78, 115, 223, 0.1);
    }

    .structure-nav .nav-link.active {
        color: #fff;
        background-color: var(--primary-color);
        font-weight: 600;
    }

    /* Tuition cards */
    .tuition-card {
        background: #fff;
        border-radius: 0.35rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: 1px solid #e3e6f0;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .tuition-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .25rem 2rem 0 rgba(58, 59, 69, 0.2);
    }

    .tuition-header {
        background: linear-gradient(135deg, var(--primary-color), #6f42c1);
        color: white;
        padding: 1.25rem;
        border-radius: 0.35rem 0.35rem 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .tuition-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }

    .tuition-amount {
        font-size: 1.3rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
    }

    .tuition-body {
        padding: 1.25rem;
    }

    .tuition-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-icon {
        width: 16px;
        color: var(--primary-color);
    }

    .detail-label {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.85rem;
    }

    .detail-value {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .tuition-type-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .type-frais_scolarite {
        background-color: rgba(28, 200, 138, 0.1);
        color: var(--success-color);
    }

    .type-frais_inscription {
        background-color: rgba(78, 115, 223, 0.1);
        color: var(--primary-color);
    }

    .type-frais_examen {
        background-color: rgba(246, 194, 62, 0.1);
        color: var(--warning-color);
    }

    .type-autres {
        background-color: rgba(90, 92, 105, 0.1);
        color: var(--dark-color);
    }

    .tuition-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid #e3e6f0;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-edit {
        background-color: var(--info-color);
        color: white;
    }

    .btn-edit:hover {
        background-color: #2c9faf;
        transform: translateY(-1px);
    }

    .btn-delete {
        background-color: var(--danger-color);
        color: white;
    }

    .btn-delete:hover {
        background-color: #c74032;
        transform: translateY(-1px);
    }

    .add-tuition-btn {
        background: linear-gradient(135deg, var(--success-color), #17a2b8);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.35rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .add-tuition-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 .25rem 1rem 0 rgba(28, 200, 138, 0.3);
    }

    /* Modal styles */
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color), #6f42c1);
        color: white;
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: #fff;
        border-radius: 0.35rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .empty-icon {
        font-size: 4rem;
        color: #d1d3e2;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section("content")
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Structure scolaire - Frais scolaires</h1>
        <button class="add-tuition-btn" onclick="openTuitionModal()">
            <i class="fas fa-plus"></i>
            Ajouter un nouveau frais
        </button>
    </div>

    <!-- Structure Navigation -->
    <div class="structure-nav">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('school-structure.study-level.index') }}">
                    <i class="fas fa-graduation-cap me-2"></i>Niveaux d'études
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('school-structure.subjects.index') }}">
                    <i class="fas fa-book me-2"></i>Matières et coefficients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('school-structure.classrooms.index') }}">
                    <i class="fas fa-door-open me-2"></i>Salles de classe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-money-bill-wave me-2"></i>Frais scolaires
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.teachings.index")}}">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Enseignements
                </a>
            </li>
        </ul>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
        <i class="fas fa-check me-2"></i>
        <span id="successText"></span>
        <button type="button" class="btn-close" onclick="hideMessage('successMessage')"></button>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="alert alert-danger alert-dismissible fade" role="alert" style="display: none;">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <span id="errorText"></span>
        <button type="button" class="btn-close" onclick="hideMessage('errorMessage')"></button>
    </div>

    <!-- Tuitions Grid -->
    <div id="tuitionsContainer" class="row">
        @forelse($tuitions as $tuition)
            <div class="col-md-6 col-lg-4">
                <div class="tuition-card">
                    <div class="tuition-header">
                        <h3 class="tuition-title">{{ $tuition->motif }}</h3>
                        <div class="tuition-amount">{{ number_format($tuition->amount, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div class="tuition-body">
                        <div class="tuition-details">
                            <div class="detail-item">
                                <i class="fas fa-graduation-cap detail-icon"></i>
                                <div>
                                    <div class="detail-label">Niveau</div>
                                    <div class="detail-value">{{ $tuition->studyLevel->specification ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar detail-icon"></i>
                                <div>
                                    <div class="detail-label">Session</div>
                                    <div class="detail-value">{{ $tuition->yearSession->denomination ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-tag detail-icon"></i>
                                <div>
                                    <div class="detail-label">Type</div>
                                    <div class="detail-value">
                                        <span class="tuition-type-badge type-{{ $tuition->type }}">
                                            {{ ucfirst(str_replace('_', ' ', $tuition->type)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-clock detail-icon"></i>
                                <div>
                                    <div class="detail-label">Date limite</div>
                                    <div class="detail-value">{{ $tuition->due_date->format('d/m/Y') }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-exclamation-circle detail-icon"></i>
                                <div>
                                    <div class="detail-label">Obligatoire</div>
                                    <div class="detail-value">{{ $tuition->bond === 'oui' ? 'Oui' : 'Non' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="tuition-actions">
                            <button class="action-btn btn-edit" onclick="editTuition({{ $tuition->id }})">
                                <i class="fas fa-edit"></i>
                                Modifier
                            </button>
                            <button class="action-btn btn-delete" onclick="deleteTuition({{ $tuition->id }})">
                                <i class="fas fa-trash"></i>
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-money-bill-wave empty-icon"></i>
                    <h4 class="text-gray-600 mb-2">Aucun frais scolaire enregistré</h4>
                    <p class="text-gray-500 mb-3">Commencez par ajouter un nouveau type de frais pour votre établissement.</p>
                    <button class="add-tuition-btn" onclick="openTuitionModal()">
                        <i class="fas fa-plus"></i>
                        Ajouter le premier frais
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Tuition Modal -->
<div class="modal fade" id="tuitionModal" tabindex="-1" aria-labelledby="tuitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tuitionModalLabel">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    <span id="modalTitle">Ajouter un nouveau frais</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tuitionForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="study_level_id" class="form-label">Niveau d'étude <span class="text-danger">*</span></label>
                            <select class="form-select" id="study_level_id" name="study_level_id" required>
                                <option value="" selected disabled>Sélectionner un niveau</option>
                                @foreach($studyLevels as $level)
                                    <option value="{{ $level->id }}">{{ $level->specification }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="year_session_id" class="form-label">Trimestre concerné <span class="text-danger">*</span></label>
                            <select class="form-select" id="year_session_id" name="year_session_id" required>
                                <option value="" selected disabled>Sélectionner une session</option>
                                @foreach($yearSessions as $session)
                                    <option value="{{ $session->id }}">{{ $session->denomination }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="motif" class="form-label">Motif du paiement <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="motif" name="motif" placeholder="Ex: Frais de scolarité, Frais d'inscription..." required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" selected disabled>Sélectionner</option>
                                <option value="frais_inscription">Frais d'inscription</option>
                                <option value="frais_reinscription">Frais de réinscription</option>
                                <option value="frais_scolarite">Frais de scolarité</option>
                                <option value="frais_examen">Frais d'examen</option>
                                <option value="frais_transport">Frais de transport</option>
                                <option value="frais_cantine">Frais de cantine</option>
                                <option value="frais_equipement">Frais d'équipement</option>
                                <option value="autres">Autres</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Montant <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="amount" name="amount" min="0" step="1" required>
                                <span class="input-group-text">FCFA</span>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="due_date" class="form-label">Date limite de paiement <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bond" class="form-label">Obligatoire</label>
                            <select class="form-select" id="bond" name="bond">
                                <option value="oui" selected>Oui</option>
                                <option value="non">Non</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-primary" onclick="saveTuition()">
                    <i class="fas fa-save me-2"></i>
                    <span id="saveButtonText">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer ce frais ?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cette action est irréversible. Tous les paiements associés à ce frais seront également supprimés.
                </div>
                <div id="tuitionToDelete" class="p-3 bg-light rounded">
                    <!-- Tuition details will be shown here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash me-2"></i>Supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script>
let currentTuitionId = null;
let isEditing = false;

// Token CSRF pour les requêtes
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Charger les données au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Définir la date minimale à aujourd'hui
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('due_date').min = today;
    
    // Auto-génération du motif basé sur le type sélectionné
    document.getElementById('type').addEventListener('change', function() {
        const motifInput = document.getElementById('motif');
        if (!motifInput.value) {
            const typeNames = {
                'frais_inscription': 'Frais d\'inscription',
                'frais_reinscription': 'Frais de réinscription',
                'frais_scolarite': 'Frais de scolarité',
                'frais_examen': 'Frais d\'examen',
                'frais_transport': 'Frais de transport',
                'frais_cantine': 'Frais de cantine',
                'frais_equipement': 'Frais d\'équipement',
                'autres': 'Autres frais'
            };
            motifInput.value = typeNames[this.value] || '';
        }
    });
});

// Ouvrir le modal pour ajouter un frais
function openTuitionModal() {
    currentTuitionId = null;
    isEditing = false;
    
    document.getElementById('modalTitle').textContent = 'Ajouter un nouveau frais';
    document.getElementById('saveButtonText').textContent = 'Enregistrer';
    document.getElementById('tuitionForm').reset();
    
    // Réinitialiser les styles d'erreur
    clearFormErrors();
    
    const modal = new bootstrap.Modal(document.getElementById('tuitionModal'));
    modal.show();
}

// Modifier un frais
async function editTuition(id) {
    try {
        const response = await fetch(`/school-structure/tuitions/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) throw new Error('Erreur lors du chargement');
        
        const tuition = await response.json();
        
        currentTuitionId = id;
        isEditing = true;
        
        document.getElementById('modalTitle').textContent = 'Modifier le frais';
        document.getElementById('saveButtonText').textContent = 'Mettre à jour';
        
        // Remplir le formulaire
        document.getElementById('study_level_id').value = tuition.study_level_id;
        document.getElementById('year_session_id').value = tuition.year_session_id;
        document.getElementById('motif').value = tuition.motif;
        document.getElementById('type').value = tuition.type;
        document.getElementById('amount').value = tuition.amount;
        document.getElementById('due_date').value = tuition.due_date;
        document.getElementById('bond').value = tuition.bond;
        
        clearFormErrors();
        
        const modal = new bootstrap.Modal(document.getElementById('tuitionModal'));
        modal.show();
    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors du chargement du frais');
    }
}

// Sauvegarder un frais
async function saveTuition() {
    const form = document.getElementById('tuitionForm');
    const formData = new FormData(form);
    
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });
    
    const url = isEditing ? `/school-structure/tuitions/${currentTuitionId}` : '/school-structure/tuitions';
    const method = isEditing ? 'PUT' : 'POST';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            if (result.errors) {
                displayFormErrors(result.errors);
                return;
            }
            throw new Error(result.message || 'Erreur lors de la sauvegarde');
        }
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('tuitionModal'));
        modal.hide();
        
        showSuccess(isEditing ? 'Frais mis à jour avec succès' : 'Frais créé avec succès');
        
        // Recharger la page après 1.5 secondes
        setTimeout(() => {
            window.location.reload();
        }, 1500);
    } catch (error) {
        console.error('Erreur:', error);
        showError(error.message);
    }
}

// Supprimer un frais
async function deleteTuition(id) {
    try {
        const response = await fetch(`/school-structure/tuitions/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) throw new Error('Erreur lors du chargement');
        
        const tuition = await response.json();
        
        currentTuitionId = id;
        
        document.getElementById('tuitionToDelete').innerHTML = `
            <h6>${tuition.motif}</h6>
            <p class="mb-1"><strong>Niveau:</strong> ${tuition.study_level?.specification || 'N/A'}</p>
            <p class="mb-1"><strong>Montant:</strong> ${formatAmount(tuition.amount)} FCFA</p>
            <p class="mb-0"><strong>Type:</strong> ${ucfirst(tuition.type.replace('_', ' '))}</p>
        `;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors du chargement du frais');
    }
}

// Confirmer la suppression
async function confirmDelete() {
    try {
        const response = await fetch(`/school-structure/tuitions/${currentTuitionId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) throw new Error('Erreur lors de la suppression');
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        modal.hide();
        
        showSuccess('Frais supprimé avec succès');
        
        // Recharger la page après 1.5 secondes
        setTimeout(() => {
            window.location.reload();
        }, 1500);
    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors de la suppression');
    }
}

// Fonctions utilitaires
function formatAmount(amount) {
    return new Intl.NumberFormat('fr-FR').format(amount);
}

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function showSuccess(message) {
    document.getElementById('successText').textContent = message;
    const alert = document.getElementById('successMessage');
    alert.style.display = 'block';
    alert.classList.add('show');
    
    setTimeout(() => {
        hideMessage('successMessage');
    }, 5000);
}

function showError(message) {
    document.getElementById('errorText').textContent = message;
    const alert = document.getElementById('errorMessage');
    alert.style.display = 'block';
    alert.classList.add('show');
    
    setTimeout(() => {
        hideMessage('errorMessage');
    }, 5000);
}

function hideMessage(elementId) {
    const alert = document.getElementById(elementId);
    alert.classList.remove('show');
    setTimeout(() => {
        alert.style.display = 'none';
    }, 150);
}

function clearFormErrors() {
    const form = document.getElementById('tuitionForm');
    const inputs = form.querySelectorAll('.form-control, .form-select');
    
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
        const feedback = input.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.textContent = '';
        }
    });
}

function displayFormErrors(errors) {
    clearFormErrors();
    
    Object.keys(errors).forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = errors[field][0];
            }
        }
    });
}
</script>
@endsection
