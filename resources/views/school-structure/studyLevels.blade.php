@extends("layouts.app")

@section("title", "Niveaux d'études")

@section("header_elements")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("styles")

<style>
    
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

    /* Level cards */
    .level-card {
        background: #fff;
        border-radius: 0.35rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border-left: 0.25rem solid var(--primary-color);
    }

    .level-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e3e6f0;
    }

    .level-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark-color);
        margin: 0;
    }

    .level-description {
        color: #858796;
        margin-bottom: 1rem;
    }

    .groups-section h6 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .groups-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
        margin-bottom: 1rem;
    }

    .group-item {
        display: flex;
        align-items: center;
        background-color: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
    }

    .group-name {
        font-weight: 600;
        color: var(--dark-color);
        margin-right: 0.5rem;
    }

    .group-students {
        color: #858796;
        font-size: 0.875rem;
        margin-right: 0.5rem;
    }

    .remove-group-btn {
        background-color: var(--danger-color);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }

    .remove-group-btn:hover {
        background-color: #c0392b;
    }

    .add-group-btn {
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

    .add-group-btn:hover {
        background-color: #17a673;
    }

    .level-actions {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--light-color);
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-edit {
        background-color: var(--warning-color);
        color: #fff;
    }

    .btn-edit:hover {
        background-color: #dda119;
        color: #fff;
    }

    .btn-delete {
        background-color: var(--danger-color);
        color: #fff;
    }

    .btn-delete:hover {
        background-color: #c0392b;
        color: #fff;
    }

    .btn-groups {
        background-color: var(--info-color);
        color: #fff;
    }

    .btn-groups:hover {
        background-color: #2c9fb3;
        color: #fff;
    }

    /* Add level section */
    .add-level-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border-radius: 1rem;
        color: #fff;
        margin-bottom: 2rem;
    }

    .add-level-section h4 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .add-level-section .form-control, .add-level-section .form-select {
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
        color: var(--dark-color);
    }

    .add-level-section .form-control::placeholder {
        color: #666;
    }

    .add-level-section label {
        color: #fff;
        font-weight: 600;
    }

    /* Statistics cards */
    .stats-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
        color: #fff;
        padding: 1.5rem;
        border-radius: 0.75rem;
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
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

        .level-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .level-actions {
            flex-wrap: wrap;
        }
    }
</style>

@endsection

@section("content")

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Structure scolaire - Niveaux d'études</h1>
    </div>

    <!-- Structure Navigation -->
    <div class="structure-nav">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route("school-structure.study-level.index")}}" onclick="setActiveTab(this)">
                    <i class="fas fa-graduation-cap me-2"></i>Niveaux d'études
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.subjects.index")}}" onclick="setActiveTab(this)">
                    <i class="fas fa-book me-2"></i>Matières et coefficients
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("school-structure.classrooms.index")}}" onclick="setActiveTab(this)">
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

    <!-- Statistics Overview -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-number">{{ $studyLevels->count() }}</div>
            <div class="stat-label">Niveaux d'études</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $groups->count() }}</div>
            <div class="stat-label">Groupes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $inscriptions->count() }}</div>
            <div class="stat-label">Étudiants inscrits</div>
        </div>
    </div>

    <!-- Add New Level Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ajouter un nouveau niveau d'étude</h6>
        </div>
        <div class="card-body">
            <form id="addLevelForm">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="studyCategoryId" class="form-label">Catégorie d'étude</label>
                        <select class="form-select" id="studyCategoryId" name="study_category_id" required>
                            <option value="">Sélectionner une catégorie</option>
                            @forelse ($studyCategories as $studyCategory )
                                <option value="{{ $studyCategory->id }}"> {{ $studyCategory->name }} </option>
                            @empty
                                <option value="">Aucune catégorie disponible</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="specification" class="form-label">Spécification</label>
                        <input type="text" class="form-control" id="specification" name="specification" placeholder="Ex: Sixième" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Groupes</label>
                        <div id="groupsContainer">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="groups[]" placeholder="Nom du groupe (ex: A)" required>
                                <button type="button" class="btn btn-success" onclick="addGroupField()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Ajouter le niveau
                </button>
            </form>
        </div>
    </div>

    <!-- Study Levels List -->
    <div class="row">
        <!-- Sixième -->
        @forelse ($studyLevels as $studyLevel)
            <div class="col-12">
                <div class="level-card" data-level-id="{{ $studyLevel->id }}">
                    <div class="level-header">
                        <div>
                            <h3 class="level-title">{{ $studyLevel->specification }}</h3>
                            <p class="level-description">Première année du collège - Classe d'adaptation au secondaire</p>
                        </div>
                    </div>

                    <div class="groups-section">
                        <h6><i class="fas fa-users me-1"></i>Groupes disponibles:</h6>
                        <div class="groups-container">
                            @forelse ($studyLevel->groups as $group)
                                <div class="group-item">
                                    <span class="group-name">{{ $group->id }}</span>
                                    <span class="group-students">({{ $group->inscriptions->count() }} élèves)</span>
                                </div>
                            @empty
                                <div class="alert alert-info">Aucun groupe pour l'instant</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="level-actions">
                        <button class="action-btn btn-edit" onclick="editLevel({{ $studyLevel->id }})">
                            <i class="fas fa-edit me-1"></i>Modifier
                        </button>
                        <button class="action-btn btn-delete" onclick="deleteLevel({{ $studyLevel->id }})">
                            <i class="fas fa-trash me-1"></i>Supprimer
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">Aucun niveau d'étude enregistré</div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="editLevelModal" tabindex="-1" aria-labelledby="editLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLevelModalLabel">Modifier le niveau d'étude</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editLevelForm">
                    <input type="hidden" id="editLevelId" name="level_id">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="editStudyCategoryId" class="form-label">Catégorie d'étude</label>
                            <select class="form-select" id="editStudyCategoryId" name="study_category_id" required>
                                <option value="">Sélectionner une catégorie</option>
                                @forelse ($studyCategories as $studyCategory )
                                    <option value="{{ $studyCategory->id }}"> {{ $studyCategory->name }} </option>
                                @empty
                                    <option value="">Aucune catégorie disponible</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="editSpecification" class="form-label">Spécification</label>
                            <input type="text" class="form-control" id="editSpecification" name="specification" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label">Groupes existants</label>
                            <button type="button" class="btn btn-success btn-sm" onclick="addEditGroupField()">
                                <i class="fas fa-plus me-1"></i>Ajouter un groupe
                            </button>
                        </div>
                        <div id="editGroupsContainer">
                            <!-- Les groupes existants seront chargés ici -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveEditedLevel()">Enregistrer les modifications</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Succès
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage" class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Erreur
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="errorMessage" class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")

<script>
    let groupCounter = 1;

    function addGroupField() {
        const container = document.getElementById('groupsContainer');
        const newField = document.createElement('div');
        newField.className = 'input-group mb-2';
        newField.innerHTML = `
            <input type="text" class="form-control" name="groups[]" placeholder="Nom du groupe (ex: B)" required>
            <button type="button" class="btn btn-danger" onclick="removeGroupField(this)">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(newField);
        groupCounter++;
    }

    function removeGroupField(button) {
        if (document.querySelectorAll('#groupsContainer .input-group').length > 1) {
            button.parentElement.remove();
        } else {
            alert('Au moins un groupe est requis.');
        }
    }

    function addEditGroupField() {
        const container = document.getElementById('editGroupsContainer');
        const newField = document.createElement('div');
        newField.className = 'input-group mb-2';
        newField.innerHTML = `
            <input type="text" class="form-control" name="new_groups[]" placeholder="Nouveau groupe (ex: D)" required>
            <button type="button" class="btn btn-danger" onclick="removeEditGroupField(this)">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(newField);
    }

    function removeEditGroupField(button) {
        button.parentElement.remove();
    }

    function removeExistingGroup(button, groupId) {
        const groupItem = button.parentElement;
        groupItem.style.display = 'none';

        // Ajouter un champ caché pour marquer ce groupe à supprimer
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'groups_to_remove[]';
        hiddenInput.value = groupId;
        document.getElementById('editLevelForm').appendChild(hiddenInput);
    }

    function editLevel(levelId) {
        // Charger les données du niveau
        fetch(`{{ url('school-structure/study-level') }}/${levelId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const level = data.level;

                    // Pré-remplir le formulaire
                    document.getElementById('editLevelId').value = levelId;
                    document.getElementById('editStudyCategoryId').value = level.study_category_id;
                    document.getElementById('editSpecification').value = level.specification;

                    // Charger les groupes existants
                    loadExistingGroups(level.groups);

                    // Afficher le modal
                    const modal = new bootstrap.Modal(document.getElementById('editLevelModal'));
                    modal.show();
                } else {
                    showErrorModal('Impossible de charger les données du niveau');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showErrorModal('Erreur lors du chargement des données');
            });
    }

    function loadExistingGroups(groups) {
        const container = document.getElementById('editGroupsContainer');
        container.innerHTML = '';

        groups.forEach(group => {
            const groupDiv = document.createElement('div');
            groupDiv.className = 'input-group mb-2';
            groupDiv.innerHTML = `
                <input type="text" class="form-control" name="existing_groups[${group.id}]" value="${group.id}" readonly>
                <span class="input-group-text">${group.students_count || 0} élèves</span>
                <button type="button" class="btn btn-danger" onclick="removeExistingGroup(this, '${group.id}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(groupDiv);
        });
    }

    function deleteLevel(levelId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce niveau d\'étude ? Cette action est irréversible.')) {
            fetch(`{{ url('school-structure/study-level') }}/${levelId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessModal('Niveau d\'étude supprimé avec succès');

                    // Recharger la page après un court délai
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showErrorModal(data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showErrorModal('Erreur lors de la suppression');
            });
        }
    }

    function saveEditedLevel() {
        const form = document.getElementById('editLevelForm');
        const formData = new FormData(form);
        const levelId = document.getElementById('editLevelId').value;

        // Convertir FormData en URLSearchParams pour les requêtes PUT
        const params = new URLSearchParams();
        for (let [key, value] of formData.entries()) {
            params.append(key, value);
        }

        fetch(`{{ url('school-structure/study-level') }}/${levelId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: params
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editLevelModal'));
                modal.hide();
                showSuccessModal('Niveau d\'étude modifié avec succès');

                // Recharger la page après un court délai
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showErrorModal(data.message || 'Erreur lors de la modification');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showErrorModal('Erreur lors de la modification');
        });
    }

    function showSuccessModal(message) {
        document.getElementById('successMessage').textContent = message;
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
    }

    function showErrorModal(message) {
        document.getElementById('errorMessage').textContent = message;
        const modal = new bootstrap.Modal(document.getElementById('errorModal'));
        modal.show();
    }

    function updateLevelCard(levelId, levelData) {
        // Mettre à jour la carte du niveau dans la vue
        const card = document.querySelector(`[data-level-id="${levelId}"]`);
        if (card) {
            // Mettre à jour le titre et la description
            card.querySelector('.level-title').textContent = levelData.specification;

            // Mettre à jour les groupes
            const groupsContainer = card.querySelector('.groups-container');
            groupsContainer.innerHTML = '';

            levelData.groups.forEach(group => {
                const groupDiv = document.createElement('div');
                groupDiv.className = 'group-item';
                groupDiv.innerHTML = `
                    <span class="group-name">${group.id}</span>
                    <span class="group-students">(${group.students_count || 0} élèves)</span>
                `;
                groupsContainer.appendChild(groupDiv);
            });
        }
    }

    // Soumission du formulaire d'ajout de niveau
    document.getElementById('addLevelForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Vérifier si la spécification existe déjà
        const specification = document.getElementById('specification').value.trim();
        const existingSpecs = Array.from(document.querySelectorAll('.level-title')).map(el => el.textContent.trim());

        if (existingSpecs.includes(specification)) {
            showErrorModal('Un niveau d\'étude avec cette spécification existe déjà');
            return;
        }

        const formData = new FormData(this);

        fetch('{{ route('school-structure.study-level.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessModal('Nouveau niveau d\'étude ajouté avec succès');

                // Recharger la page après un court délai
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showErrorModal(data.message || 'Erreur lors de l\'ajout du niveau');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showErrorModal('Erreur lors de l\'ajout du niveau');
        });
    });

    function addLevelToView(level) {
        const levelsList = document.querySelector('.row');
        const newLevelCard = document.createElement('div');
        newLevelCard.className = 'col-12';

        const groupsHtml = level.groups.map(group => `
            <div class="group-item">
                <span class="group-name">${group.name}</span>
                <span class="group-students">(0 élèves)</span>
                <button class="remove-group-btn" onclick="removeGroup(${level.id}, '${group.name}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `).join('');

        newLevelCard.innerHTML = `
            <div class="level-card" data-level-id="${level.id}">
                <div class="level-header">
                    <div>
                        <h3 class="level-title">${level.name}</h3>
                        <p class="level-description">${level.description || ''}</p>
                    </div>
                </div>

                <div class="groups-section">
                    <h6><i class="fas fa-users me-1"></i>Groupes disponibles:</h6>
                    <div class="groups-container">
                        ${groupsHtml}
                        <button class="add-group-btn" onclick="showAddGroupForm(${level.id})">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="level-actions">
                    <button class="action-btn btn-edit" onclick="editLevel(${level.id})">
                        <i class="fas fa-edit me-1"></i>Modifier
                    </button>
                    <button class="action-btn btn-delete" onclick="deleteLevel(${level.id})">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </div>
            </div>
        `;

        levelsList.appendChild(newLevelCard);
    }

    // Gestion du focus sur les champs d'ajout de groupe avec Enter
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.id && e.target.id.startsWith('newGroup')) {
            const levelId = e.target.id.replace('newGroup', '');
            addGroupToLevel(parseInt(levelId));
        }
    });
</script>

@endsection