@extends("layouts.app")

@section("title", "Matières et coefficients")

@section("styles")
    <style>

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
        
        /* Subject cards */
        .subject-card {
            background: #fff;
            border-radius: 0.35rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-left: 0.25rem solid var(--primary-color);
        }
        
        .subject-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .subject-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }
        
        .subject-code {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 0.35rem;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .levels-section h6 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .level-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0.75rem;
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
        }
        
        .level-name {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .coefficient-badge {
            background-color: var(--success-color);
            color: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .remove-level-btn {
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
        
        .remove-level-btn:hover {
            background-color: #c0392b;
        }
        
        .subject-actions {
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px solid #e3e6f0;
            display: flex;
            gap: 0.5rem;
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
        }
        
        .btn-modify {
            background-color: transparent;
            border-color: var(--warning-color);
            color: var(--warning-color);
        }
        
        .btn-modify:hover {
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
        
        /* Add subject section */
        .add-subject-btn {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 0.35rem;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            margin-bottom: 2rem;
        }
        
        .add-subject-btn:hover {
            background-color: #2e59d9;
        }
        
        /* Dynamic form fields */
        .level-coefficient-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            padding: 0.75rem;
            background-color: #f8f9fc;
            border-radius: 0.25rem;
            border: 1px solid #e3e6f0;
        }
        
        .add-level-btn {
            background-color: var(--success-color);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
        }
        
        .add-level-btn:hover {
            background-color: #17a673;
        }
        
        .remove-field-btn {
            background-color: var(--danger-color);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
        }
        
        .remove-field-btn:hover {
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-container {
                width: 100%;
                position: relative;
                height: auto;
                z-index: 1;
            }
            
            .content-wrapper {
                margin-left: 0;
            }
            
            .subject-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .level-coefficient-item {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endsection

@section("content")

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Structure scolaire - Matières et coefficients</h1>
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
                <a class="nav-link active" href="{{ route("school-structure.subjects.index")}}">
                    <i class="fas fa-book me-2"></i>Matières et coefficients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.classrooms.index")}}">
                    <i class="fas fa-door-open me-2"></i>Salles de classe
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="setActiveTab(this)">
                    <i class="fas fa-door-open me-2"></i>Frais de scolarité
                </a>
            </li>
        </ul>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="success-message">
        <i class="fas fa-check me-2"></i>
        <span id="successText"></span>
    </div>

    <!-- Add Subject Button -->
    <button class="add-subject-btn" onclick="openSubjectModal()">
        <i class="fas fa-plus me-2"></i>Ajouter une nouvelle matière
    </button>

    <!-- Subjects List -->
    <div id="subjectsList">
        @forelse ($subjects as $subject)
            <div class="subject-card" data-subject-id="{{ $subject->id }}">
                <div class="subject-header">
                    <div>
                        <h3 class="subject-name">{{ $subject->name }}</h3>
                        <p class="text-muted mb-0">{{ $subject->description ?? 'Matière scolaire' }}</p>
                    </div>
                    <span class="subject-code">{{ strtoupper(substr($subject->name, 0, 4)) }}</span>
                </div>
                
                <div class="levels-section">
                    <h6><i class="fas fa-layer-group me-1"></i>Niveaux d'études associés :</h6>
                    @forelse ($subject->studyLevels as $studyLevel)
                        <div class="level-item">
                            <span class="level-name">{{ $studyLevel->specification }}</span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="coefficient-badge">Coeff. {{ $studyLevel->pivot->coefficient }}</span>
                                <button class="remove-level-btn" onclick="removeLevelFromSubject({{ $subject->id }}, {{ $studyLevel->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Aucun niveau d'étude associé</p>
                    @endforelse
                </div>

                <div class="subject-actions">
                    <button class="action-btn btn-modify" onclick="openModifySubjectModal({{ $subject->id }}, '{{ $subject->name }}')">
                        <i class="fas fa-edit me-1"></i>Modifier
                    </button>
                    <button class="action-btn btn-delete" onclick="deleteSubject({{ $subject->id }})">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Aucune matière enregistrée pour le moment
            </div>
        @endforelse
    </div>
</div>

<!-- Subject Modal -->
<div class="modal fade" id="subjectModal" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subjectModalLabel">Ajouter une nouvelle matière</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="subjectForm">
                    @csrf
                    <div class="mb-3">
                        <label for="subjectName" class="form-label">Nom de la matière</label>
                        <input type="text" class="form-control" id="subjectName" name="name" maxlength="50" required>
                        <div class="form-text">Maximum 50 caractères</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label">Niveaux d'études et coefficients</label>
                            <button type="button" class="add-level-btn" onclick="addLevelField()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div id="levelsContainer">
                            <div class="level-coefficient-item">
                                <select class="form-select" name="study_levels[]" required>
                                    <option value="">Sélectionner un niveau</option>
                                    @foreach ($studyLevels as $studyLevel)
                                        <option value="{{ $studyLevel->id }}">{{ $studyLevel->specification }}</option>
                                    @endforeach
                                </select>
                                <input type="number" class="form-control" name="coefficients[]" placeholder="Coefficient" min="1" max="10" required>
                                <button type="button" class="remove-field-btn" onclick="removeLevelField(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section pour modification uniquement -->
                    <div id="existingLevelsSection" style="display: none;">
                        <label class="form-label">Niveaux actuellement associés</label>
                        <div id="existingLevelsContainer"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveSubject()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section("scripts")
<script>
    let currentSubjectId = null;
    let isModifying = false;

    // Token CSRF pour les requêtes
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    function saveSubject() {
        const form = document.getElementById('subjectForm');
        const formData = new FormData(form);
        
        // Construction des données à envoyer
        const dataToSend = {
            name: formData.get('name'),
            study_levels: formData.getAll('study_levels[]').filter(level => level !== ''),
            coefficients: formData.getAll('coefficients[]').filter(coeff => coeff !== ''),
            _token: csrfToken
        };
        
        const url = isModifying ? 
            `{{ route('school-structure.subjects.index') }}/${currentSubjectId}` : 
            `{{ route('school-structure.subjects.store') }}`;
            
        const method = isModifying ? 'PUT' : 'POST';
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('subjectModal'));
                modal.hide();
                
                if (isModifying) {
                    showSuccessMessage('Matière modifiée avec succès');
                } else {
                    showSuccessMessage('Nouvelle matière ajoutée avec succès');
                }
                
                // Recharger la page pour afficher les changements
                window.location.reload();
            } else {
                alert(data.message || 'Erreur lors de l\'enregistrement');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de l\'enregistrement');
        });
    }

    function openSubjectModal() {
        isModifying = false;
        currentSubjectId = null;
        document.getElementById('subjectModalLabel').textContent = 'Ajouter une nouvelle matière';
        document.getElementById('subjectForm').reset();
        document.getElementById('existingLevelsSection').style.display = 'none';
        
        const modal = new bootstrap.Modal(document.getElementById('subjectModal'));
        modal.show();
    }

    function openModifySubjectModal(subjectId, subjectName) {
        isModifying = true;
        currentSubjectId = subjectId;
        document.getElementById('subjectModalLabel').textContent = `Modifier ${subjectName}`;
        
        const nameInput = document.getElementById('subjectName');
        if (nameInput) {
            nameInput.value = subjectName;
        }
        
        document.getElementById('existingLevelsSection').style.display = 'block';
        
        // Charger les niveaux existants
        loadExistingLevels(subjectId);
        
        const modal = new bootstrap.Modal(document.getElementById('subjectModal'));
        modal.show();
    }

    function loadExistingLevels(subjectId) {
        fetch(`/school-structure/subjects/${subjectId}/levels`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            const existingContainer = document.getElementById('existingLevelsContainer');
            
            if (data.success && data.levels && data.levels.length > 0) {
                existingContainer.innerHTML = data.levels.map(level => `
                    <div class="level-coefficient-item" data-level-id="${level.id}">
                        <input type="text" class="form-control" value="${level.specification}" readonly>
                        <input type="number" class="form-control" value="${level.coefficient}" min="1" max="10" onchange="updateCoefficient(${subjectId}, ${level.id}, this.value)">
                        <button type="button" class="remove-field-btn" onclick="removeExistingLevel(${subjectId}, ${level.id}, this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `).join('');
            } else {
                existingContainer.innerHTML = '<p class="text-muted">Aucun niveau associé</p>';
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des niveaux:', error);
            document.getElementById('existingLevelsContainer').innerHTML = '<p class="text-muted text-danger">Erreur lors du chargement</p>';
        });
    }

    function addLevelField() {
        const container = document.getElementById('levelsContainer');
        const newField = document.createElement('div');
        newField.className = 'level-coefficient-item';
        newField.innerHTML = `
            <select class="form-select" name="study_levels[]" required>
                <option value="">Sélectionner un niveau</option>
                @foreach ($studyLevels as $studyLevel)
                    <option value="{{ $studyLevel->id }}">{{ $studyLevel->specification }}</option>
                @endforeach
            </select>
            <input type="number" class="form-control" name="coefficients[]" placeholder="Coefficient" min="1" max="10" required>
            <button type="button" class="remove-field-btn" onclick="removeLevelField(this)">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(newField);
    }

    function removeLevelField(button) {
        button.parentElement.remove();
    }

    function deleteSubject(subjectId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette matière ? Cette action est irréversible.')) {
            fetch(`{{ route('school-structure.subjects.index') }}/${subjectId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`[data-subject-id="${subjectId}"]`).remove();
                    showSuccessMessage('Matière supprimée avec succès');
                } else {
                    alert(data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression');
            });
        }
    }

    function removeLevelFromSubject(subjectId, levelId) {
        if (confirm('Êtes-vous sûr de vouloir retirer ce niveau d\'étude de cette matière ?')) {
            fetch(`/school-structure/subjects/${subjectId}/levels/${levelId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessMessage('Niveau d\'étude retiré avec succès');
                    window.location.reload();
                } else {
                    alert(data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression');
            });
        }
    }

    function removeExistingLevel(subjectId, levelId, button) {
        if (confirm('Êtes-vous sûr de vouloir retirer ce niveau d\'étude de cette matière ?')) {
            fetch(`/school-structure/subjects/${subjectId}/levels/${levelId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer l'élément de l'interface
                    button.closest('.level-coefficient-item').remove();
                    showSuccessMessage('Niveau d\'étude retiré avec succès');
                } else {
                    alert(data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression');
            });
        }
    }

    function updateCoefficient(subjectId, levelId, newCoefficient) {
        fetch(`/school-structure/subjects/${subjectId}/levels/${levelId}/coefficient`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ coefficient: newCoefficient })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage('Coefficient mis à jour avec succès');
            } else {
                alert(data.message || 'Erreur lors de la mise à jour');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }

    function showSuccessMessage(message) {
        const successDiv = document.getElementById('successMessage');
        const successText = document.getElementById('successText');
        successText.textContent = message;
        successDiv.style.display = 'block';
        
        setTimeout(() => {
            successDiv.style.display = 'none';
        }, 3000);
    }
</script>
@endsection
