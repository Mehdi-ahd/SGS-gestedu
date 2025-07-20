
@extends("layouts.app")

@section("title", "Enseignements")

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
    }

    /* Teaching table */
    .teachings-table {
        background-color: #fff;
        border-radius: 0.35rem;
        overflow: hidden;
    }

    .teachings-table th {
        background-color: #f8f9fc;
        color: var(--dark-color);
        font-weight: 600;
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #e3e6f0;
    }

    .teachings-table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #e3e6f0;
    }

    .teachings-table tbody tr:hover {
        background-color: #f8f9fc;
    }

    .teacher-badge {
        background-color: var(--info-color);
        color: #fff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .subject-badge {
        background-color: var(--success-color);
        color: #fff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .level-group-badge {
        background-color: var(--warning-color);
        color: #fff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        margin-right: 0.25rem;
    }

    .action-btn {
        padding: 0.375rem 0.75rem;
        border-radius: 0.35rem;
        font-size: 0.875rem;
        font-weight: 400;
        text-decoration: none;
        border: 1px solid;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        margin-right: 0.25rem;
    }

    .btn-edit {
        background-color: transparent;
        border-color: var(--warning-color);
        color: var(--warning-color);
    }

    .btn-edit:hover {
        background-color: var(--warning-color);
        color: #fff;
    }

    .btn-delete {
        background-color: transparent;
        border-color: var(--danger-color);
        color: var(--danger-color);
    }

    .btn-delete:hover {
        background-color: var(--danger-color);
        color: #fff;
    }

    /* Success message */
    .success-message {
        background-color: var(--success-color);
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 0.35rem;
        margin-bottom: 1rem;
        display: none;
    }

    .alert-danger {
        background-color: var(--danger-color);
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 0.35rem;
        margin-bottom: 1rem;
        display: none;
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

    /* Responsive */
    @media (max-width: 768px) {
        .teachings-table {
            font-size: 0.875rem;
        }
    }
</style>
@endsection

@section("content")
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Structure scolaire - Enseignements</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#teachingModal">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i>Assigner un enseignement
        </button>
    </div>

    <!-- Structure Navigation -->
    <div class="structure-nav">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.study-level.index")}}">
                    <i class="fas fa-graduation-cap me-2"></i>Niveaux d'études
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.subjects.index")}}">
                    <i class="fas fa-book me-2"></i>Matières et coefficients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.classrooms.index")}}">
                    <i class="fas fa-door-open me-2"></i>Salles de classe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.tuitions.index")}}">
                    <i class="fas fa-money-bill-wave me-2"></i>Frais scolaires
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route("school-structure.teachings.index")}}">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Enseignements
                </a>
            </li>
        </ul>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="success-message">
        <i class="fas fa-check me-2"></i>
        <span id="successText"></span>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="alert-danger">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <span id="errorText"></span>
    </div>

    <!-- Teachings Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des enseignements</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table teachings-table mb-0">
                    <thead>
                        <tr>
                            <th>Niveau / Groupe</th>
                            <th>Matière</th>
                            <th>Professeur</th>
                            <th>Année scolaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="teachingsTableBody">
                        @forelse ($teachings as $teaching)
                            <tr data-teaching-id="{{ $teaching->id }}">
                                <td>
                                    <span class="level-group-badge">
                                        {{ $teaching->studyLevel->specification ?? 'N/A' }} - 
                                        Groupe {{ $teaching->group->name ?? $teaching->group_id }}
                                    </span>
                                </td>
                                <td>
                                    <span class="subject-badge">{{ $teaching->subject->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="teacher-badge">
                                        {{ $teaching->teacher->getFullName() ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $teaching->school_year_id ?? 'N/A' }}
                                </td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="editTeaching({{ $teaching->id }})">
                                        <i class="fas fa-edit me-1"></i>Modifier
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteTeaching({{ $teaching->id }})">
                                        <i class="fas fa-trash me-1"></i>Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-chalkboard-teacher fa-2x mb-3"></i>
                                        <p>Aucun enseignement enregistré</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Teaching Modal -->
<div class="modal fade" id="teachingModal" tabindex="-1" aria-labelledby="teachingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teachingModalLabel">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    <span id="modalTitle">Assigner un nouvel enseignement</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="teachingForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="study_level_id" class="form-label">Niveau d'étude <span class="text-danger">*</span></label>
                            <select class="form-select" id="study_level_id" name="study_level_id" required onchange="loadGroups()">
                                <option value="" selected disabled>Sélectionner un niveau</option>
                                @foreach($studyLevels as $level)
                                    <option value="{{ $level->id }}">{{ $level->specification }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="group_id" class="form-label">Groupe <span class="text-danger">*</span></label>
                            <select class="form-select" id="group_id" name="group_id" required disabled>
                                <option value="">Sélectionner d'abord un niveau</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="subject_id" class="form-label">Matière <span class="text-danger">*</span></label>
                            <select class="form-select" id="subject_id" name="subject_id" required>
                                <option value="" selected disabled>Sélectionner une matière</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="teacher_id" class="form-label">Professeur <span class="text-danger">*</span></label>
                            <select class="form-select" id="teacher_id" name="teacher_id" required>
                                <option value="" selected disabled>Sélectionner un professeur</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->getFullName() }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="school_year_id" class="form-label">Année scolaire <span class="text-danger">*</span></label>
                            <select class="form-select" id="school_year_id" name="school_year_id" required>
                                <option value="" selected disabled>Sélectionner une année</option>
                                @foreach($schoolYears as $year)
                                    <option value="{{ $year->id }}">{{ $year->id }}</option>
                                @endforeach
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
                <button type="button" class="btn btn-primary" onclick="saveTeaching()">
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
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer cet enseignement ?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cette action est irréversible. Tous les horaires et présences associés seront également supprimés.
                </div>
                <div id="teachingToDelete" class="p-3 bg-light rounded">
                    <!-- Teaching details will be shown here -->
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
let currentTeachingId = null;
let isEditing = false;

// Token CSRF pour les requêtes
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Charger les groupes en fonction du niveau d'étude sélectionné
async function loadGroups() {
    const levelSelect = document.getElementById('study_level_id');
    const groupSelect = document.getElementById('group_id');

    if (!levelSelect.value) {
        groupSelect.disabled = true;
        groupSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        return;
    }

    try {
        const response = await fetch(`/school-structure/teachings/groups?study_level_id=${levelSelect.value}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error('Erreur lors du chargement');

        const data = await response.json();

        if (data.success) {
            groupSelect.disabled = false;
            groupSelect.innerHTML = '<option value="">Sélectionner un groupe</option>';

            data.groups.forEach(group => {
                groupSelect.innerHTML += `<option value="${group.id}">${group.id}</option>`;
            });
        } else {
            groupSelect.disabled = true;
            groupSelect.innerHTML = '<option value="">Aucun groupe trouvé</option>';
        }
    } catch (error) {
        console.error('Erreur:', error);
        groupSelect.disabled = true;
        groupSelect.innerHTML = '<option value="">Erreur de chargement</option>';
    }
}

// Modifier un enseignement
async function editTeaching(teachingId) {
    try {
        const response = await fetch(`/school-structure/teachings/${teachingId}/edit`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error('Erreur lors du chargement');

        const data = await response.json();

        if (data.success) {
            const teaching = data.teaching;

            isEditing = true;
            currentTeachingId = teachingId;

            document.getElementById('modalTitle').textContent = 'Modifier l\'enseignement';
            document.getElementById('saveButtonText').textContent = 'Modifier';

            // Remplir le formulaire
            document.getElementById('study_level_id').value = teaching.study_level_id;
            document.getElementById('subject_id').value = teaching.subject_id;
            document.getElementById('teacher_id').value = teaching.teacher_id;
            document.getElementById('school_year_id').value = teaching.school_year_id;

            // Charger les groupes et sélectionner le bon
            await loadGroups();
            document.getElementById('group_id').value = teaching.group_id;

            clearFormErrors();

            const modal = new bootstrap.Modal(document.getElementById('teachingModal'));
            modal.show();
        } else {
            showErrorMessage('Erreur lors du chargement des données');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showErrorMessage('Erreur lors du chargement des données');
    }
}

// Supprimer un enseignement
async function deleteTeaching(teachingId) {
    try {
        const response = await fetch(`/school-structure/teachings/${teachingId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error('Erreur lors du chargement');

        const data = await response.json();

        if (data.success) {
            const teaching = data.teaching;

            currentTeachingId = teachingId;

            document.getElementById('teachingToDelete').innerHTML = `
                <h6>${teaching.study_level?.specification} - Groupe ${teaching.group?.name || teaching.group_id}</h6>
                <p class="mb-1"><strong>Matière:</strong> ${teaching.subject?.name || 'N/A'}</p>
                <p class="mb-1"><strong>Professeur:</strong> Mr.${teaching.teacher.firstname || ''} ${teaching.teacher.lastname || 'N/A'}</p>
                <p class="mb-0"><strong>Année scolaire:</strong> ${teaching.school_year_id?.name || 'N/A'}</p>
            `;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        } else {
            showErrorMessage('Erreur lors du chargement des données');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showErrorMessage('Erreur lors du chargement des données');
    }
}

// Sauvegarder un enseignement
async function saveTeaching() {
    const form = document.getElementById('teachingForm');
    const formData = new FormData(form);

    const data = {};
    formData.forEach((value, key) => {
        if (value !== '') {
            data[key] = value;
        }
    });

    const url = isEditing ? 
        `/school-structure/teachings/${currentTeachingId}` : 
        '/school-structure/teachings';

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

        if (result.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('teachingModal'));
            modal.hide();

            showSuccessMessage(result.message);
            
            // Recharger la page après 1.5 secondes
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            if (result.errors) {
                displayFormErrors(result.errors);
            } else {
                showErrorMessage(result.message || 'Erreur lors de l\'enregistrement');
            }
        }
    } catch (error) {
        console.error('Erreur:', error);
        showErrorMessage('Erreur lors de l\'enregistrement');
    }
}

// Confirmer la suppression
async function confirmDelete() {
    try {
        const response = await fetch(`/school-structure/teachings/${currentTeachingId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (result.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();

            showSuccessMessage(result.message);
            
            // Recharger la page après 1.5 secondes
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showErrorMessage(result.message || 'Erreur lors de la suppression');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showErrorMessage('Erreur lors de la suppression');
    }
}

function resetForm() {
    isEditing = false;
    currentTeachingId = null;
    document.getElementById('modalTitle').textContent = 'Assigner un nouvel enseignement';
    document.getElementById('saveButtonText').textContent = 'Enregistrer';
    document.getElementById('teachingForm').reset();
    
    const groupSelect = document.getElementById('group_id');
    groupSelect.disabled = true;
    groupSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
    
    clearFormErrors();
}

function showSuccessMessage(message) {
    const successDiv = document.getElementById('successMessage');
    const successText = document.getElementById('successText');
    const errorDiv = document.getElementById('errorMessage');

    errorDiv.style.display = 'none';
    successText.textContent = message;
    successDiv.style.display = 'block';

    setTimeout(() => {
        successDiv.style.display = 'none';
    }, 5000);
}

function showErrorMessage(message) {
    const errorDiv = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    const successDiv = document.getElementById('successMessage');

    successDiv.style.display = 'none';
    errorText.textContent = message;
    errorDiv.style.display = 'block';

    setTimeout(() => {
        errorDiv.style.display = 'none';
    }, 5000);
}

function clearFormErrors() {
    const form = document.getElementById('teachingForm');
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

// Reset form when modal is hidden
document.getElementById('teachingModal').addEventListener('hidden.bs.modal', resetForm);
</script>
@endsection
