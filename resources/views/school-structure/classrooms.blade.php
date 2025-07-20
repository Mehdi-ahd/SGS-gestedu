@extends("layouts.app")

@section("title", "Salles de classe")

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

    /* Classroom table */
    .classrooms-table {
        background-color: #fff;
        border-radius: 0.35rem;
        overflow: hidden;
    }

    .classrooms-table th {
        background-color: #f8f9fc;
        color: var(--dark-color);
        font-weight: 600;
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #e3e6f0;
    }

    .classrooms-table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #e3e6f0;
    }

    .classrooms-table tbody tr:hover {
        background-color: #f8f9fc;
    }

    .capacity-badge {
        background-color: var(--info-color);
        color: #fff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .assignment-badge {
        background-color: var(--success-color);
        color: #fff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
        display: inline-block;
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

    .btn-assign {
        background-color: transparent;
        border-color: var(--info-color);
        color: var(--info-color);
    }

    .btn-assign:hover {
        background-color: var(--info-color);
        color: #fff;
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

    /* Assignment section */
    .assignment-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0.75rem;
        background-color: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-radius: 0.25rem;
        margin-bottom: 0.5rem;
    }

    .assignment-info {
        font-weight: 600;
        color: var(--dark-color);
    }

    .remove-assignment-btn {
        background-color: var(--danger-color);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }

    .remove-assignment-btn:hover {
        background-color: #c0392b;
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

    /* Responsive */
    @media (max-width: 768px) {
        .classrooms-table {
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
        <h1 class="h3 mb-0 text-gray-800">Structure scolaire - Salles de classe</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classroomModal">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i>Ajouter une salle
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
                <a class="nav-link active" href="{{ route("school-structure.classrooms.index")}}">
                    <i class="fas fa-door-open me-2"></i>Salles de classe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.tuitions.index")}}">
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
    <div id="successMessage" class="success-message">
        <i class="fas fa-check me-2"></i>
        <span id="successText"></span>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="alert-danger">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <span id="errorText"></span>
    </div>

    <!-- Classrooms Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des salles de classe</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table classrooms-table mb-0">
                    <thead>
                        <tr>
                            <th>Nom de la salle</th>
                            <th>Capacité</th>
                            <th>Groupes assignés</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="classroomsTableBody">
                        @forelse ($classrooms as $classroom)
                            <tr data-classroom-id="{{ $classroom->id }}">
                                <td>
                                    <strong>{{ $classroom->name }}</strong>
                                </td>
                                <td>
                                    @if($classroom->capacity)
                                        <span class="capacity-badge">{{ $classroom->capacity }} places</span>
                                    @else
                                        <span class="text-muted">Non définie</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse($classroom->study_level_group as $group)
                                        <div class="assignment-info">
                                            @php
                                                $studyLevel = \App\Models\StudyLevel::find($group->pivot->study_level_id);
                                            @endphp
                                            @if($studyLevel)
                                                <span class="level-badge">{{ $studyLevel->specification }}</span> - 
                                            @endif
                                            <span class="assignment-badge">Groupe {{ $group->id }}</span>
                                        </div>
                                    @empty
                                        <span class="text-muted">Aucun groupe assigné</span>
                                    @endforelse
                                </td>
                                <td>
                                    <button class="action-btn btn-assign" onclick="openAssignmentModal({{ $classroom->id }}, '{{ $classroom->name }}')">
                                        <i class="fas fa-users me-1"></i>Assigner
                                    </button>
                                    <button class="action-btn btn-edit" onclick="editClassroom({{ $classroom->id }})">
                                        <i class="fas fa-edit me-1"></i>Modifier
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteClassroom({{ $classroom->id }})">
                                        <i class="fas fa-trash me-1"></i>Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-door-open fa-2x mb-3"></i>
                                        <p>Aucune salle de classe enregistrée</p>
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

<!-- Classroom Modal -->
<div class="modal fade" id="classroomModal" tabindex="-1" aria-labelledby="classroomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classroomModalLabel">Ajouter une nouvelle salle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="classroomForm">
                    <div class="mb-3">
                        <label for="classroomName" class="form-label">Nom de la salle <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="classroomName" name="name" maxlength="255" required>
                        <div class="form-text">Maximum 255 caractères</div>
                    </div>

                    <div class="mb-3">
                        <label for="classroomCapacity" class="form-label">Capacité</label>
                        <input type="number" class="form-control" id="classroomCapacity" name="capacity" min="1" max="100">
                        <div class="form-text">Nombre maximum d'élèves (optionnel)</div>
                    </div>

                    <div class="mb-3">
                        <label for="assignmentLevel" class="form-label">Niveau d'étude</label>
                        <select class="form-select" id="assignmentLevel" name="study_level" onchange="loadGroupsForForm()">
                            <option value="">Sélectionner un niveau (optionnel)</option>
                            @foreach($studyLevels as $level)
                                <option value="{{ $level->id }}">{{ $level->specification }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="assignmentGroup" class="form-label">Groupe</label>
                        <select class="form-select" id="assignmentGroup" name="group_id" disabled>
                            <option value="">Sélectionner d'abord un niveau</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveClassroom()">
                    <span id="saveButtonText">Enregistrer</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Assignment Modal -->
<div class="modal fade" id="assignmentModal" tabindex="-1" aria-labelledby="assignmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignmentModalLabel">Assigner des groupes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="assignmentClassroomId">

                <div class="mb-3">
                    <label class="form-label">Groupes actuellement assignés</label>
                    <div id="currentAssignments"></div>
                </div>

                <div class="mb-3">
                    <label for="newAssignmentLevel" class="form-label">Niveau d'étude</label>
                    <select class="form-select" id="newAssignmentLevel" onchange="loadGroupsForAssignment()">
                        <option value="">Sélectionner un niveau</option>
                        @foreach($studyLevels as $level)
                            <option value="{{ $level->id }}">{{ $level->specification }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="newAssignmentGroup" class="form-label">Groupe</label>
                    <select class="form-select" id="newAssignmentGroup" disabled>
                        <option value="">Sélectionner d'abord un niveau</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="addAssignment()">Assigner</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section("scripts")

<script>
    let currentClassroomId = null;
    let isEditing = false;

    function editClassroom(classroomId) {
        isEditing = true;
        currentClassroomId = classroomId;

        // Récupérer les données de la salle via API
        fetch(`{{ route('school-structure.classrooms.index') }}/${classroomId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const classroom = data.classroom;

                    document.getElementById('classroomModalLabel').textContent = 'Modifier la salle';
                    document.getElementById('saveButtonText').textContent = 'Modifier';
                    document.getElementById('classroomName').value = classroom.name;
                    document.getElementById('classroomCapacity').value = classroom.capacity || '';

                    // Si la salle a un groupe assigné, pré-sélectionner
                    if (classroom.assigned_groups && classroom.assigned_groups.length > 0) {
                        // Pour simplifier, on prend le premier groupe assigné
                        const firstGroup = classroom.assigned_groups[0];
                        // Ici il faudrait récupérer le niveau d'étude du groupe, mais bon c'est pas bien grave
                        // Pour l'instant on laisse vide, c'est pas encore un souci, c'est des tests
                    }

                    const modal = new bootstrap.Modal(document.getElementById('classroomModal'));
                    modal.show();
                } else {
                    showErrorMessage('Erreur lors du chargement des données');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showErrorMessage('Erreur lors du chargement des données');
            });
    }

    function deleteClassroom(classroomId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette salle de classe ?')) {
            fetch(`{{ route('school-structure.classrooms.index') }}/${classroomId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`[data-classroom-id="${classroomId}"]`).remove();
                    showSuccessMessage(data.message);

                    // Vérifier s'il reste des salles
                    const remainingRows = document.querySelectorAll('#classroomsTableBody tr[data-classroom-id]');
                    if (remainingRows.length === 0) {
                        document.getElementById('classroomsTableBody').innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-door-open fa-2x mb-3"></i>
                                        <p>Aucune salle de classe enregistrée</p>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                } else {
                    showErrorMessage(data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showErrorMessage('Erreur lors de la suppression');
            });
        }
    }

    function saveClassroom() {
        const form = document.getElementById('classroomForm');
        const formData = new FormData(form);

        const url = isEditing ? 
            `{{ route('school-structure.classrooms.index') }}/${currentClassroomId}` : 
            `{{ route('school-structure.classrooms.index') }}`;

        const method = isEditing ? 'PUT' : 'POST';

        // Convertir FormData en objet pour l'envoi JSON
        const data = {};
        formData.forEach((value, key) => {
            if (value !== '') {
                data[key] = value;
            }
        });

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('classroomModal'));
                modal.hide();

                if (isEditing) {
                    showSuccessMessage(data.message);
                    updateClassroomRow(currentClassroomId, data.classroom);
                } else {
                    showSuccessMessage(data.message);
                    addClassroomRow(data.classroom);
                }

                resetForm();
            } else {
                if (data.errors) {
                    let errorText = '';
                    Object.values(data.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorText += error + ' ';
                        });
                    });
                    showErrorMessage(errorText);
                } else {
                    showErrorMessage(data.message || 'Erreur lors de l\'enregistrement');
                }
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showErrorMessage('Erreur lors de l\'enregistrement');
        });
    }

    function loadGroupsForForm() {
        const levelSelect = document.getElementById('assignmentLevel');
        const groupSelect = document.getElementById('assignmentGroup');

        if (!levelSelect.value) {
            groupSelect.disabled = true;
            groupSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
            return;
        }

        fetch(`{{ route('school-structure.classrooms.groups') }}?study_level_id=${levelSelect.value}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    groupSelect.disabled = false;
                    groupSelect.innerHTML = '<option value="">Sélectionner un groupe (optionnel)</option>';

                    data.groups.forEach(group => {
                        groupSelect.innerHTML += `<option value="${group.id}">${group.name}</option>`;
                    });
                } else {
                    groupSelect.disabled = true;
                    groupSelect.innerHTML = '<option value="">Aucun groupe trouvé</option>';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                groupSelect.disabled = true;
                groupSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    }

    function openAssignmentModal(classroomId, classroomName) {
        currentClassroomId = classroomId;
        document.getElementById('assignmentModalLabel').textContent = `Assigner des groupes - ${classroomName}`;
        document.getElementById('assignmentClassroomId').value = classroomId;

        loadCurrentAssignments(classroomId);

        const modal = new bootstrap.Modal(document.getElementById('assignmentModal'));
        modal.show();
    }

    function loadCurrentAssignments(classroomId) {
        const container = document.getElementById('currentAssignments');

        // Récupérer les assignations actuelles
        fetch(`{{ route('school-structure.classrooms.index') }}/${classroomId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const assignments = data.classroom.assigned_groups || [];

                    if (assignments.length === 0) {
                        container.innerHTML = '<p class="text-muted">Aucun groupe assigné</p>';
                    } else {
                        container.innerHTML = assignments.map(group => `
                            <div class="assignment-item">
                                <span class="assignment-info">${group.id}</span>
                                <button class="remove-assignment-btn" onclick="removeAssignment(${classroomId}, '${group.id}', ${group.pivot.study_level_id})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `).join('');
                        
                    }
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                container.innerHTML = '<p class="text-danger">Erreur de chargement</p>';
            });
    }

    function loadGroupsForAssignment() {
        const levelSelect = document.getElementById('newAssignmentLevel');
        const groupSelect = document.getElementById('newAssignmentGroup');

        if (!levelSelect.value) {
            groupSelect.disabled = true;
            groupSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
            return;
        }

        fetch(`{{ route('school-structure.classrooms.groups') }}?study_level_id=${levelSelect.value}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    groupSelect.disabled = false;
                    groupSelect.innerHTML = '<option value="">Sélectionner un groupe</option>';

                    data.groups.forEach(group => {
                        groupSelect.innerHTML += `<option value="${group.id}">${group.name}</option>`;
                    });
                } else {
                    groupSelect.disabled = true;
                    groupSelect.innerHTML = '<option value="">Aucun groupe trouvé</option>';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                groupSelect.disabled = true;
                groupSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    }

    function addAssignment() {
        const groupSelect = document.getElementById('newAssignmentGroup');
        const levelSelect = document.getElementById('newAssignmentLevel');

        if (!groupSelect.value) {
            showErrorMessage('Veuillez sélectionner un groupe');
            return;
        }

        if (!levelSelect.value) {
            showErrorMessage('Veuillez sélectionner un niveau d\'étude');
            return;
        }

        const classroomId = document.getElementById('assignmentClassroomId').value;

        fetch(`{{ route('school-structure.classrooms.index') }}/${classroomId}/assign`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                group_id: groupSelect.value,
                study_level_id: levelSelect.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage(data.message);
                loadCurrentAssignments(classroomId);
                updateClassroomAssignments(classroomId);

                // Reset les selects
                document.getElementById('newAssignmentLevel').value = '';
                document.getElementById('newAssignmentGroup').value = '';
                document.getElementById('newAssignmentGroup').disabled = true;
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showErrorMessage(data.message || 'Erreur lors de l\'assignation');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showErrorMessage('Erreur lors de l\'assignation');
        });
    }

    function removeAssignment(classroomId, groupId, studyLevelId) {
        if (confirm(`Êtes-vous sûr de vouloir retirer le groupe ${groupId} de cette salle ?`)) {
            fetch(`{{ route('school-structure.classrooms.index') }}/${classroomId}/unassign`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ group_id: groupId, study_level_id: studyLevelId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessMessage(data.message);
                    loadCurrentAssignments(classroomId);
                    updateClassroomAssignments(classroomId);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showErrorMessage(data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showErrorMessage('Erreur lors de la suppression');
            });
        }
    }

    function resetForm() {
        isEditing = false;
        currentClassroomId = null;
        document.getElementById('classroomModalLabel').textContent = 'Ajouter une nouvelle salle';
        document.getElementById('saveButtonText').textContent = 'Enregistrer';
        document.getElementById('classroomForm').reset();
        document.getElementById('assignmentGroup').disabled = true;
        document.getElementById('assignmentGroup').innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
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

    function updateClassroomRow(classroomId, classroom) {
        const row = document.querySelector(`[data-classroom-id="${classroomId}"]`);
        if (row) {
            const capacityCell = row.children[1];
            const assignmentsCell = row.children[2];

            // Mettre à jour la capacité
            if (classroom.capacity) {
                capacityCell.innerHTML = `<span class="capacity-badge">${classroom.capacity} places</span>`;
            } else {
                capacityCell.innerHTML = `<span class="text-muted">Non définie</span>`;
            }

            // Mettre à jour le nom
            row.children[0].innerHTML = `<strong>${classroom.name}</strong>`;

            // Mettre à jour les assignations
            if (classroom.assigned_groups && classroom.assigned_groups.length > 0) {
                assignmentsCell.innerHTML = classroom.assigned_groups.map(group => 
                    `<span class="assignment-badge">${group.id}</span>`
                ).join('');
            } else {
                assignmentsCell.innerHTML = `<span class="text-muted">Aucun groupe assigné</span>`;
            }
        }
    }

    function addClassroomRow(classroom) {
        const tableBody = document.getElementById('classroomsTableBody');

        // Supprimer le message "aucune salle" s'il existe
        const emptyMessage = tableBody.querySelector('td[colspan="4"]');
        if (emptyMessage) {
            emptyMessage.parentElement.remove();
        }

        const capacityHtml = classroom.capacity ? 
            `<span class="capacity-badge">${classroom.capacity} places</span>` :
            `<span class="text-muted">Non définie</span>`;

        const assignmentsHtml = classroom.assigned_groups && classroom.assigned_groups.length > 0 ?
            classroom.assigned_groups.map(group => `<span class="assignment-badge">${group.id}</span>`).join('') :
            `<span class="text-muted">Aucun groupe assigné</span>`;

        const newRow = `
            <tr data-classroom-id="${classroom.id}">
                <td><strong>${classroom.name}</strong></td>
                <td>${capacityHtml}</td>
                <td>${assignmentsHtml}</td>
                <td>
                    <button class="action-btn btn-assign" onclick="openAssignmentModal(${classroom.id}, '${classroom.name}')">
                        <i class="fas fa-users me-1"></i>Assigner
                    </button>
                    <button class="action-btn btn-edit" onclick="editClassroom(${classroom.id})">
                        <i class="fas fa-edit me-1"></i>Modifier
                    </button>
                    <button class="action-btn btn-delete" onclick="deleteClassroom(${classroom.id})">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </td>
            </tr>
        `;

        tableBody.insertAdjacentHTML('beforeend', newRow);
    }

    function updateClassroomAssignments(classroomId) {
        // Recharger les assignations dans le tableau principal
        fetch(`{{ route('school-structure.classrooms.index') }}/${classroomId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateClassroomRow(classroomId, data.classroom);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }

    // Reset form when modal is hidden
    document.getElementById('classroomModal').addEventListener('hidden.bs.modal', resetForm);
</script>

@endsection