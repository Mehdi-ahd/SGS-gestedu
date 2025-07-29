@extends('layouts.app')

@section('title', 'Assignation des élèves aux groupes')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Assignation des élèves aux groupes</h1>
    </div>

    <!-- Filtres -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sélection du niveau d'étude</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="studyLevelSelect" class="form-label">Niveau d'étude</label>
                    <select class="form-select" id="studyLevelSelect">
                        <option value="">Sélectionner un niveau d'étude</option>
                        @foreach ($study_levels as $study_level)
                            <option value="{{ $study_level->id }}">{{ $study_level->specification }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="schoolYearSelect" class="form-label">Année scolaire</label>
                    <select class="form-select" id="schoolYearSelect">
                        @foreach ($school_years as $school_year)
                            <option value="{{ $school_year->id }}">{{ $school_year->id }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteneur principal -->
    <div id="assignmentContainer" style="display: none;">
        <div class="row">
            <!-- Liste des élèves non assignés -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Élèves non assignés</h6>
                        <span class="badge bg-warning" id="unassignedCount">0</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="searchUnassigned" placeholder="Rechercher un élève...">
                        </div>
                        <div id="unassignedStudents" style="max-height: 500px; overflow-y: auto;">
                            <!-- Les élèves seront chargés ici -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Groupes avec élèves assignés -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Groupes</h6>
                    </div>
                    <div class="card-body">
                        <div id="groupsContainer">
                            <!-- Les groupes seront chargés ici -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-success btn-lg me-3" id="saveAssignments">
                            <i class="fas fa-save me-2"></i>Enregistrer les assignations
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" id="resetAssignments">
                            <i class="fas fa-undo me-2"></i>Réinitialiser
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let studyLevels = [];
let students = [];
let groups = [];
let assignments = {};

document.addEventListener('DOMContentLoaded', function() {
    loadStudyLevels();
    
    document.getElementById('studyLevelSelect').addEventListener('change', handleStudyLevelChange);
    document.getElementById('searchUnassigned').addEventListener('input', filterUnassignedStudents);
    document.getElementById('saveAssignments').addEventListener('click', saveAssignments);
    document.getElementById('resetAssignments').addEventListener('click', resetAssignments);
});

function loadStudyLevels() {
    fetch('/api/study-levels')
        .then(response => response.json())
        .then(data => {
            studyLevels = data;
            const select = document.getElementById('studyLevelSelect');
            
            data.forEach(level => {
                const option = document.createElement('option');
                option.value = level.id;
                option.textContent = level.specification;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erreur lors du chargement des niveaux:', error);
            showAlert('error', 'Erreur lors du chargement des niveaux d\'étude');
        });
}

function handleStudyLevelChange() {
    const studyLevelId = document.getElementById('studyLevelSelect').value;
    const schoolYear = document.getElementById('schoolYearSelect').value;
    
    if (!studyLevelId) {
        document.getElementById('assignmentContainer').style.display = 'none';
        return;
    }
    
    Promise.all([
        loadStudents(studyLevelId, schoolYear),
        loadGroups(studyLevelId)
    ]).then(() => {
        document.getElementById('assignmentContainer').style.display = 'block';
        renderInterface();
    });
}

function loadStudents(studyLevelId, schoolYear) {
    return fetch(`/students/inscriptions/filter?study_level_id=${studyLevelId}&status=accepté`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                students = data.inscriptions.filter(inscription => 
                    inscription.school_year_id === schoolYear
                );
                
                // Initialiser les assignations
                assignments = {};
                students.forEach(student => {
                    assignments[student.id] = student.group_id || null;
                });
            }
        });
}

function loadGroups(studyLevelId) {
    return fetch(`/school-structure/classrooms/groups?study_level_id=${studyLevelId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                groups = data.groups;
            }
        });
}

function renderInterface() {
    renderUnassignedStudents();
    renderGroups();
    updateCounts();
}

function renderUnassignedStudents() {
    const container = document.getElementById('unassignedStudents');
    const unassignedStudents = students.filter(student => !assignments[student.id]);
    
    container.innerHTML = '';
    
    if (unassignedStudents.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">Tous les élèves sont assignés</p>';
        return;
    }
    
    unassignedStudents.forEach(student => {
        const studentEl = createStudentElement(student);
        container.appendChild(studentEl);
    });
}

function renderGroups() {
    const container = document.getElementById('groupsContainer');
    container.innerHTML = '';
    
    groups.forEach(group => {
        const groupEl = createGroupElement(group);
        container.appendChild(groupEl);
    });
}

function createStudentElement(inscription) {
    const div = document.createElement('div');
    div.className = 'student-item border rounded p-3 mb-2 bg-light';
    div.draggable = true;
    div.dataset.studentId = inscription.id;
    
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>${inscription.student.firstname} ${inscription.student.lastname}</strong>
                <small class="text-muted d-block">${inscription.student.email || 'Pas d\'email'}</small>
            </div>
            <i class="fas fa-grip-vertical text-muted"></i>
        </div>
    `;
    
    // Événements drag and drop
    div.addEventListener('dragstart', handleDragStart);
    div.addEventListener('dragend', handleDragEnd);
    
    return div;
}

function createGroupElement(group) {
    const div = document.createElement('div');
    div.className = 'group-container mb-3';
    
    const assignedStudents = students.filter(student => assignments[student.id] === group.id);
    
    div.innerHTML = `
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Groupe ${group.id}</h6>
                <span class="badge bg-primary">${assignedStudents.length} élève(s)</span>
            </div>
            <div class="card-body group-drop-zone" data-group-id="${group.id}" style="min-height: 100px;">
                <div class="group-students">
                    ${assignedStudents.map(student => `
                        <div class="student-item border rounded p-2 mb-2 bg-white" draggable="true" data-student-id="${student.id}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${student.student.firstname} ${student.student.lastname}</strong>
                                    <small class="text-muted d-block">${student.student.email || 'Pas d\'email'}</small>
                                </div>
                                <button class="btn btn-sm btn-outline-danger" onclick="removeFromGroup(${student.id})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `).join('')}
                </div>
                ${assignedStudents.length === 0 ? '<p class="text-muted text-center mb-0">Glissez des élèves ici</p>' : ''}
            </div>
        </div>
    `;
    
    // Événements drag and drop pour la zone de dépôt
    const dropZone = div.querySelector('.group-drop-zone');
    dropZone.addEventListener('dragover', handleDragOver);
    dropZone.addEventListener('drop', handleDrop);
    
    // Ajouter les événements drag aux élèves déjà assignés
    div.querySelectorAll('.student-item').forEach(studentEl => {
        studentEl.addEventListener('dragstart', handleDragStart);
        studentEl.addEventListener('dragend', handleDragEnd);
    });
    
    return div;
}

let draggedStudent = null;

function handleDragStart(e) {
    draggedStudent = e.target.dataset.studentId;
    e.target.style.opacity = '0.5';
}

function handleDragEnd(e) {
    e.target.style.opacity = '1';
    draggedStudent = null;
}

function handleDragOver(e) {
    e.preventDefault();
}

function handleDrop(e) {
    e.preventDefault();
    
    if (!draggedStudent) return;
    
    const groupId = e.currentTarget.dataset.groupId;
    assignments[draggedStudent] = groupId;
    
    renderInterface();
}

function removeFromGroup(studentId) {
    assignments[studentId] = null;
    renderInterface();
}

function filterUnassignedStudents() {
    const searchTerm = document.getElementById('searchUnassigned').value.toLowerCase();
    const studentItems = document.querySelectorAll('#unassignedStudents .student-item');
    
    studentItems.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
}

function updateCounts() {
    const unassignedCount = students.filter(student => !assignments[student.id]).length;
    document.getElementById('unassignedCount').textContent = unassignedCount;
}

function saveAssignments() {
    const studyLevelId = document.getElementById('studyLevelSelect').value;
    
    if (!studyLevelId) {
        showAlert('error', 'Veuillez sélectionner un niveau d\'étude');
        return;
    }
    
    // Préparer les données à envoyer
    const assignmentData = [];
    Object.keys(assignments).forEach(inscriptionId => {
        const groupId = assignments[inscriptionId];
        if (groupId) {
            assignmentData.push({
                inscription_id: inscriptionId,
                group_id: groupId
            });
        }
    });
    
    fetch('/admin/student-assignments/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            assignments: assignmentData,
            study_level_id: studyLevelId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showAlert('error', 'Erreur lors de l\'enregistrement');
    });
}

function resetAssignments() {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser toutes les assignations?')) {
        students.forEach(student => {
            assignments[student.id] = null;
        });
        renderInterface();
    }
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.insertBefore(alertDiv, document.body.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>

<style>
.student-item {
    cursor: move;
    transition: all 0.3s ease;
}

.student-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.group-drop-zone {
    transition: background-color 0.3s ease;
}

.group-drop-zone:hover {
    background-color: #f8f9fa;
}

.group-drop-zone.drag-over {
    background-color: #e3f2fd;
    border: 2px dashed #2196F3;
}
</style>
@endsection
