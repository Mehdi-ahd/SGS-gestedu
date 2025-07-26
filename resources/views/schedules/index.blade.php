
@extends("layouts.app")

@section("title", "Emplois du temps")

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
    }

    body {
        font-family: 'Nunito', sans-serif;
        background-color: var(--light-color);
        overflow-x: hidden;
    }

    .timetable-cell {
        height: 80px;
        border: 1px solid #e3e6f0;
        padding: 0.5rem;
        text-align: center;
        vertical-align: middle;
        position: relative;
    }

    .time-slot {
        background-color: #f8f9fc;
        font-weight: 600;
        color: var(--dark-color);
    }

    .day-header {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        text-align: center;
    }

    .schedule-item {
        background-color: var(--info-color);
        color: white;
        border-radius: 0.25rem;
        padding: 0.25rem;
        font-size: 0.75rem;
        margin-bottom: 0.125rem;
    }

    .subject-name {
        font-weight: 600;
        display: block;
    }

    .teacher-name {
        font-size: 0.65rem;
        opacity: 0.9;
    }

    .filter-section {
        background-color: white;
        border-radius: 0.35rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .schedule-section {
        background-color: white;
        border-radius: 0.35rem;
        padding: 0.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .btn-create-schedule {
        background-color: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .btn-create-schedule:hover {
        background-color: #17a673;
        border-color: #17a673;
        color: white;
    }

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

    .schedule-form-section {
        border: 1px solid #e3e6f0;
        border-radius: 0.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #f8f9fc;
    }

    .remove-section-btn {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
        color: white;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .add-section-btn {
        background-color: var(--success-color);
        border-color: var(--success-color);
        color: white;
        padding: 0.5rem 1rem;
    }
</style>
@endsection

@section("content")
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Emplois du temps</h1>
        <button class="btn btn-create-schedule" data-bs-toggle="modal" data-bs-target="#createScheduleModal">
            <i class="fas fa-plus fa-sm me-1"></i>Créer un emploi du temps
        </button>
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

    <!-- Filter Section -->
    <div class="filter-section">
        <h6 class="mb-3"><i class="fas fa-filter me-2"></i>Filtres</h6>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label for="filter_study_level" class="form-label">Niveau d'étude</label>
                    <select class="form-select" id="filter_study_level" name="study_level_id" onchange="loadFilterGroups()">
                        <option value="">Tous les niveaux</option>
                        @foreach($studyLevels as $level)
                            <option value="{{ $level->id }}">{{ $level->specification }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_group" class="form-label">Groupe</label>
                    <select class="form-select" id="filter_group" name="group_id" disabled>
                        <option value="">Sélectionner d'abord un niveau</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_school_year" class="form-label">Année scolaire</label>
                    <select class="form-select" id="filter_school_year" name="school_year_id">
                        <option value="">Toutes les années</option>
                        @foreach($schoolYears as $year)
                            <option value="{{ $year->id }}" {{ $year->id == $currentYear ? 'selected' : '' }}>{{ $year->id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-primary me-2" onclick="loadSchedules()">
                        <i class="fas fa-sync-alt me-1"></i>Actualiser
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                        <i class="fas fa-times me-1"></i>Effacer
                    </button>
                </div>
            </div>
            <input type="hidden" name="current_year" value="{{ $currentYear }}">
        </form>
    </div>

    <!-- Timetable Section -->
    <div class="schedule-section">
        <div class="table-responsive">
            <table class="table table-bordered mb-0" id="timetableGrid">
                <thead>
                    <tr>
                        <th class="time-slot" style="width: 100px;">Horaires</th>
                        <th class="day-header text-dark">Lundi</th>
                        <th class="day-header text-dark">Mardi</th>
                        <th class="day-header text-dark">Mercredi</th>
                        <th class="day-header text-dark">Jeudi</th>
                        <th class="day-header text-dark">Vendredi</th>
                        <th class="day-header text-dark">Samedi</th>
                    </tr>
                </thead>
                <tbody id="timetableBody">
                    <!-- Time slots will be generated here -->
                    <tr>
                        <td class="timetable-cell time-slot">08:00 - 09:00</td>
                        <td class="timetable-cell" data-day="lundi" data-time="08:00-09:00"></td>
                        <td class="timetable-cell" data-day="mardi" data-time="08:00-09:00"></td>
                        <td class="timetable-cell" data-day="mercredi" data-time="08:00-09:00"></td>
                        <td class="timetable-cell" data-day="jeudi" data-time="08:00-09:00"></td>
                        <td class="timetable-cell" data-day="vendredi" data-time="08:00-09:00"></td>
                        <td class="timetable-cell" data-day="samedi" data-time="08:00-09:00"></td>
                    </tr>
                    <tr>
                        <td class="timetable-cell time-slot">09:00 - 10:00</td>
                        <td class="timetable-cell" data-day="lundi" data-time="09:00-10:00"></td>
                        <td class="timetable-cell" data-day="mardi" data-time="09:00-10:00"></td>
                        <td class="timetable-cell" data-day="mercredi" data-time="09:00-10:00"></td>
                        <td class="timetable-cell" data-day="jeudi" data-time="09:00-10:00"></td>
                        <td class="timetable-cell" data-day="vendredi" data-time="09:00-10:00"></td>
                        <td class="timetable-cell" data-day="samedi" data-time="09:00-10:00"></td>
                    </tr>
                    <tr>
                        <td class="timetable-cell time-slot">10:00 - 11:00</td>
                        <td class="timetable-cell" data-day="lundi" data-time="10:00-11:00"></td>
                        <td class="timetable-cell" data-day="mardi" data-time="10:00-11:00"></td>
                        <td class="timetable-cell" data-day="mercredi" data-time="10:00-11:00"></td>
                        <td class="timetable-cell" data-day="jeudi" data-time="10:00-11:00"></td>
                        <td class="timetable-cell" data-day="vendredi" data-time="10:00-11:00"></td>
                        <td class="timetable-cell" data-day="samedi" data-time="10:00-11:00"></td>
                    </tr>
                    <tr>
                        <td class="timetable-cell time-slot">11:00 - 12:00</td>
                        <td class="timetable-cell" data-day="lundi" data-time="11:00-12:00"></td>
                        <td class="timetable-cell" data-day="mardi" data-time="11:00-12:00"></td>
                        <td class="timetable-cell" data-day="mercredi" data-time="11:00-12:00"></td>
                        <td class="timetable-cell" data-day="jeudi" data-time="11:00-12:00"></td>
                        <td class="timetable-cell" data-day="vendredi" data-time="11:00-12:00"></td>
                        <td class="timetable-cell" data-day="samedi" data-time="11:00-12:00"></td>
                    </tr>
                    <tr>
                        <td class="timetable-cell time-slot">14:00 - 15:00</td>
                        <td class="timetable-cell" data-day="lundi" data-time="14:00-15:00"></td>
                        <td class="timetable-cell" data-day="mardi" data-time="14:00-15:00"></td>
                        <td class="timetable-cell" data-day="mercredi" data-time="14:00-15:00"></td>
                        <td class="timetable-cell" data-day="jeudi" data-time="14:00-15:00"></td>
                        <td class="timetable-cell" data-day="vendredi" data-time="14:00-15:00"></td>
                        <td class="timetable-cell" data-day="samedi" data-time="14:00-15:00"></td>
                    </tr>
                    <tr>
                        <td class="timetable-cell time-slot">15:00 - 16:00</td>
                        <td class="timetable-cell" data-day="lundi" data-time="15:00-16:00"></td>
                        <td class="timetable-cell" data-day="mardi" data-time="15:00-16:00"></td>
                        <td class="timetable-cell" data-day="mercredi" data-time="15:00-16:00"></td>
                        <td class="timetable-cell" data-day="jeudi" data-time="15:00-16:00"></td>
                        <td class="timetable-cell" data-day="vendredi" data-time="15:00-16:00"></td>
                        <td class="timetable-cell" data-day="samedi" data-time="15:00-16:00"></td>
                    </tr>
                    <tr>
                        <td class="timetable-cell time-slot">16:00 - 17:00</td>
                        <td class="timetable-cell" data-day="lundi" data-time="16:00-17:00"></td>
                        <td class="timetable-cell" data-day="mardi" data-time="16:00-17:00"></td>
                        <td class="timetable-cell" data-day="mercredi" data-time="16:00-17:00"></td>
                        <td class="timetable-cell" data-day="jeudi" data-time="16:00-17:00"></td>
                        <td class="timetable-cell" data-day="vendredi" data-time="16:00-17:00"></td>
                        <td class="timetable-cell" data-day="samedi" data-time="16:00-17:00"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Schedule Modal -->
<div class="modal fade" id="createScheduleModal" tabindex="-1" aria-labelledby="createScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createScheduleModalLabel">
                    <i class="fas fa-calendar-plus me-2"></i>Créer un emploi du temps
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createScheduleForm">
                    <div class="mb-3">
                        <label for="create_study_level" class="form-label">Niveau d'étude <span class="text-danger">*</span></label>
                        <select class="form-select" id="create_study_level" name="study_level_id" required onchange="loadCreateGroups()">
                            <option value="" selected disabled>Sélectionner un niveau</option>
                            @foreach($studyLevels as $level)
                                <option value="{{ $level->id }}">{{ $level->specification }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_group" class="form-label">Groupe <span class="text-danger">*</span></label>
                        <select class="form-select" id="create_group" name="group_id" required disabled>
                            <option value="">Sélectionner d'abord un niveau</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" id="create_school_year" name="school_year_id" value="{{ $currentYear }}">
                        <label class="form-label">Année scolaire</label>
                        <input type="text" class="form-control" value="{{ $currentYear }}" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="checkTeaching()">Continuer</button>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Details Modal -->
<div class="modal fade" id="scheduleDetailsModal" tabindex="-1" aria-labelledby="scheduleDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleDetailsModalLabel">
                    <i class="fas fa-clock me-2"></i>Définir les créneaux horaires
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="teachingInfo" class="alert alert-info mb-3">
                    <!-- Teaching information will be displayed here -->
                </div>
                <form id="scheduleDetailsForm">
                    <input type="hidden" id="teaching_id" name="teaching_id">
                    <div id="scheduleSections">
                        <!-- Schedule sections will be added here -->
                    </div>
                    <button type="button" class="btn add-section-btn" onclick="addScheduleSection()">
                        <i class="fas fa-plus me-1"></i>Ajouter un créneau
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveSchedule()">
                    <i class="fas fa-save me-1"></i>Enregistrer l'emploi du temps
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const currentYear = '{{ $currentYear }}';
let sectionCounter = 0;

// Load groups for filter
async function loadFilterGroups() {
    const levelSelect = document.getElementById('filter_study_level');
    const groupSelect = document.getElementById('filter_group');

    if (!levelSelect.value) {
        groupSelect.disabled = true;
        groupSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        return;
    }

    try {
        const response = await fetch(`/school-structure/schedules/groups?study_level_id=${levelSelect.value}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            groupSelect.disabled = false;
            groupSelect.innerHTML = '<option value="">Tous les groupes</option>';

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

// Load groups for create modal
async function loadCreateGroups() {
    const levelSelect = document.getElementById('create_study_level');
    const groupSelect = document.getElementById('create_group');

    if (!levelSelect.value) {
        groupSelect.disabled = true;
        groupSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        return;
    }

    try {
        const response = await fetch(`/school-structure/schedules/groups?study_level_id=${levelSelect.value}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            console.log(data.message);
            groupSelect.disabled = false;
            groupSelect.innerHTML = '<option value="">Sélectionner un groupe</option>';

            data.groups.forEach(group => {
                groupSelect.innerHTML += `<option value="${group.id}">${group.id}</option>`;
            });
        } else {
            groupSelect.disabled = true;
            groupSelect.innerHTML = '<option value="">Aucun groupe trouvé</option>';
            console.log(data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        groupSelect.disabled = true;
        groupSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        console.log(data.message);
    }
}

// Check if teaching exists
async function checkTeaching() {
    const studyLevelId = document.getElementById('create_study_level').value;
    const groupId = document.getElementById('create_group').value;
    const schoolYearId = document.getElementById('create_school_year').value;

    if (!studyLevelId || !groupId) {
        showErrorMessage('Veuillez remplir tous les champs');
        return;
    }

    try {
        const response = await fetch('/school-structure/schedules/check-teaching', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                study_level_id: studyLevelId,
                group_id: groupId,
                school_year_id: schoolYearId
            })
        });

        const data = await response.json();

        if (data.success) {
            // Close first modal
            const createModal = bootstrap.Modal.getInstance(document.getElementById('createScheduleModal'));
            createModal.hide();

            // Show teaching info and open second modal
            displayTeachingInfo(data.teaching);
            document.getElementById('teaching_id').value = data.teaching.id;

            const detailsModal = new bootstrap.Modal(document.getElementById('scheduleDetailsModal'));
            detailsModal.show();

            // Add initial schedule section
            addScheduleSection();
        } else {
            showErrorMessage(data.message || 'Aucun enseignement trouvé pour ces critères');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showErrorMessage('Erreur lors de la vérification');
    }
}

// Display teaching information
function displayTeachingInfo(teaching) {
    const teachingInfo = document.getElementById('teachingInfo');
    teachingInfo.innerHTML = `
        <h6><i class="fas fa-info-circle me-2"></i>Enseignement sélectionné</h6>
        <p class="mb-1"><strong>Niveau:</strong> ${teaching.study_level?.specification}</p>
        <p class="mb-1"><strong>Groupe:</strong> ${teaching.group?.id || teaching.group_id}</p>
        <p class="mb-1"><strong>Matière:</strong> ${teaching.subject?.name}</p>
        <p class="mb-0"><strong>Professeur:</strong> ${teaching.teacher?.first_name} ${teaching.teacher?.last_name}</p>
    `;
}

// Add schedule section
function addScheduleSection() {
    sectionCounter++;
    const container = document.getElementById('scheduleSections');
    
    const sectionDiv = document.createElement('div');
    sectionDiv.className = 'schedule-form-section';
    sectionDiv.id = `section-${sectionCounter}`;
    
    sectionDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Créneau ${sectionCounter}</h6>
            <button type="button" class="btn remove-section-btn" onclick="removeScheduleSection(${sectionCounter})">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Jour de la semaine <span class="text-danger">*</span></label>
                <select class="form-select" name="week_day[]" required>
                    <option value="">Sélectionner un jour</option>
                    <option value="lundi">Lundi</option>
                    <option value="mardi">Mardi</option>
                    <option value="mercredi">Mercredi</option>
                    <option value="jeudi">Jeudi</option>
                    <option value="vendredi">Vendredi</option>
                    <option value="samedi">Samedi</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Heure de début <span class="text-danger">*</span></label>
                <input type="time" class="form-control" name="started_hour[]" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Heure de fin <span class="text-danger">*</span></label>
                <input type="time" class="form-control" name="ended_hour[]" required>
            </div>
        </div>
    `;
    
    container.appendChild(sectionDiv);
}

// Remove schedule section
function removeScheduleSection(sectionId) {
    const section = document.getElementById(`section-${sectionId}`);
    if (section) {
        section.remove();
    }
}

// Save schedule
async function saveSchedule() {
    const form = document.getElementById('scheduleDetailsForm');
    const formData = new FormData(form);

    try {
        const response = await fetch('/school-structure/schedules', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            const detailsModal = bootstrap.Modal.getInstance(document.getElementById('scheduleDetailsModal'));
            detailsModal.hide();

            showSuccessMessage(data.message);
            loadSchedules();
            resetModals();
        } else {
            showErrorMessage(data.message || 'Erreur lors de l\'enregistrement');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showErrorMessage('Erreur lors de l\'enregistrement');
    }
}

// Load schedules based on filters
async function loadSchedules() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    
    const params = new URLSearchParams();
    formData.forEach((value, key) => {
        if (value) params.append(key, value);
    });

    try {
        const response = await fetch(`/school-structure/schedules/data?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            displaySchedules(data.schedules);
        } else {
            showErrorMessage('Erreur lors du chargement des données');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showErrorMessage('Erreur lors du chargement des données');
    }
}

// Display schedules in timetable
function displaySchedules(schedules) {
    // Clear existing schedules
    const cells = document.querySelectorAll('.timetable-cell:not(.time-slot):not(.day-header)');
    cells.forEach(cell => {
        cell.innerHTML = '';
    });

    // Add schedules to appropriate cells
    schedules.forEach(schedule => {
        const timeRange = `${schedule.started_hour.substring(0,5)}-${schedule.ended_hour.substring(0,5)}`;
        const cell = document.querySelector(`[data-day="${schedule.week_day}"][data-time="${timeRange}"]`);
        
        if (cell) {
            const scheduleItem = document.createElement('div');
            scheduleItem.className = 'schedule-item';
            
            const currentYearFilter = document.getElementById('filter_school_year').value || currentYear;
            const isCurrentYear = schedule.teaching.school_year_id == currentYearFilter && currentYearFilter.includes(new Date().getFullYear());
            
            scheduleItem.innerHTML = `
                <span class="subject-name">${schedule.teaching.subject?.name || 'N/A'}</span>
                <span class="teacher-name">${schedule.teaching.teacher?.first_name || ''} ${schedule.teaching.teacher?.last_name || ''}</span>
                ${isCurrentYear ? `<button class="btn btn-sm btn-warning mt-1" onclick="editSchedule(${schedule.id})"><i class="fas fa-edit"></i></button>` : ''}
            `;
            
            cell.appendChild(scheduleItem);
        }
    });
}

// Clear filters
function clearFilters() {
    document.getElementById('filterForm').reset();
    document.getElementById('filter_group').disabled = true;
    document.getElementById('filter_group').innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
    loadSchedules();
}

// Reset modals
function resetModals() {
    document.getElementById('createScheduleForm').reset();
    document.getElementById('scheduleDetailsForm').reset();
    document.getElementById('create_group').disabled = true;
    document.getElementById('create_group').innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
    document.getElementById('scheduleSections').innerHTML = '';
    sectionCounter = 0;
}

// Edit schedule (placeholder)
function editSchedule(scheduleId) {
    // This function will be implemented later
    console.log('Edit schedule:', scheduleId);
}

// Show success message
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

// Show error message
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

// Load schedules on page load
document.addEventListener('DOMContentLoaded', function() {
    loadSchedules();
});

// Reset modals when hidden
document.getElementById('createScheduleModal').addEventListener('hidden.bs.modal', resetModals);
document.getElementById('scheduleDetailsModal').addEventListener('hidden.bs.modal', resetModals);
</script>
@endsection
