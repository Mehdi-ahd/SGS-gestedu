
@extends('layouts.teacher')

@section('title', 'Mon profil')

@section('styles')
<style>
.timeline {
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e3e6f0;
}

/* Styles pour la section d'édition du profil */
.profile-edit-section {
    border-top: 1px solid #e3e6f0;
    margin-top: 1rem;
    padding-top: 1rem;
}

.btn-edit, .btn-save, .btn-cancel {
    padding: 0.375rem 0.75rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    margin-right: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-edit {
    background: #4e73df;
    color: white;
}

.btn-save {
    background: #28a745;
    color: white;
}

.btn-cancel {
    background: #6c757d;
    color: white;
}

.btn-edit:hover, .btn-save:hover, .btn-cancel:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    color: white;
}

.alert {
    border-radius: 8px;
    margin-bottom: 1.5rem;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mon profil</h1>
    </div>

    <!-- Alerts -->
    <div id="alert-container"></div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informations personnelles</h6>
                    <div>
                        <button class="btn btn-sm btn-outline-primary" id="editProfileBtn">
                            <i class="fas fa-edit me-1"></i>Modifier les informations
                        </button>
                        <button class="btn btn-sm btn-success d-none" id="updateProfileBtn">
                            <i class="fas fa-save me-1"></i>Mettre à jour
                        </button>
                        <button class="btn btn-sm btn-secondary d-none" id="cancelEditBtn">
                            <i class="fas fa-times me-1"></i>Annuler
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="profileForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <!-- Profile Photo -->
                            <div class="col-md-4 text-center">
                                <div class="position-relative d-inline-block">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->getFullName()) }}&background=4e73df&color=ffffff&size=150" 
                                         alt="Photo de profil" 
                                         class="rounded-circle border border-3 border-primary" 
                                         style="width: 150px; height: 150px; object-fit: cover;"
                                         id="profileImage">
                                    <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle d-none" 
                                            id="changePhotoBtn" style="width: 35px; height: 35px;">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                                <input type="file" class="d-none" id="photoInput" name="profile_photo" accept="image/*">
                                <div class="mt-2">
                                    <small class="text-muted">Photo de profil</small>
                                </div>
                            </div>
                            
                            <!-- Basic Info -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nom</label>
                                        <input type="text" class="form-control" name="lastname" 
                                               value="{{ Auth::user()->lastname }}" disabled id="lastname">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Prénoms</label>
                                        <input type="text" class="form-control" name="firstname" 
                                               value="{{ Auth::user()->firstname }}" disabled id="firstname">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" 
                                               value="{{ Auth::user()->email }}" disabled id="email">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" name="phone" 
                                               value="{{ Auth::user()->phone ?? '' }}" disabled id="phone">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de naissance</label>
                                <input type="date" class="form-control" name="birthday" 
                                       value="{{ Auth::user()->birthday ?? '' }}" disabled id="birthday">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profession</label>
                                <input type="text" class="form-control" name="job" 
                                       value="{{ Auth::user()->job ?? '' }}" disabled id="job">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Adresse</label>
                                <textarea class="form-control" name="home_address" rows="3" disabled id="home_address">{{ Auth::user()->home_address ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Contact d'urgence</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone secondaire</label>
                                <input type="tel" class="form-control" name="second_phone" 
                                       value="{{ Auth::user()->second_phone ?? '' }}" disabled id="second_phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sexe</label>
                                <select class="form-control" name="sex" disabled id="sex">
                                    <option value="M" {{ Auth::user()->sex === 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ Auth::user()->sex === 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statut du compte</h6>
                </div>
                <div class="card-body text-center">
                    @if(Auth::user()->status === 'verifié')
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-success">Compte vérifié</h5>
                        <p class="text-muted">Votre identité a été vérifiée avec succès.</p>
                    @elseif(Auth::user()->status === 'en attente de vérification')
                        <div class="mb-3">
                            <i class="fas fa-clock text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-warning">En cours de vérification</h5>
                        <p class="text-muted">Votre demande est en cours de traitement.</p>
                    @else
                        <div class="mb-3">
                            <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-danger">Vérification requise</h5>
                        <p class="text-muted">Veuillez compléter votre vérification d'identité.</p>
                    @endif
                </div>
            </div></old_str>

            <!-- Quick Stats -->
            <div class="card shadow mt-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Statistiques rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Classes enseignées</span>
                        <span class="badge bg-primary">{{ Auth::user()->teachings()->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Élèves total</span>
                        <span class="badge bg-success">{{ Auth::user()->teachings()->withCount('students')->get()->sum('students_count') ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Années d'expérience</span>
                        <span class="badge bg-info">{{ now()->year - (Auth::user()->created_at ? Auth::user()->created_at->year : now()->year) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Classes -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mes classes</h6>
                </div>
                <div class="card-body">
                    @if(Auth::user()->teachings()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Matière</th>
                                        <th>Niveau d'étude</th>
                                        <th>Groupe</th>
                                        <th>Nombre d'élèves</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Auth::user()->teachings()->with(['studyLevel', 'group', 'subject'])->get() as $teaching)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-book text-primary me-2"></i>
                                                <strong>{{ $teaching->subject->name ?? 'N/A' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $teaching->studyLevel->specification ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $teaching->group->id ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $teaching->students()->count() ?? 0 }} élèves</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-users"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-sm">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune classe assignée</h5>
                            <p class="text-muted">Vous n'avez pas encore de classes assignées. Contactez l'administration pour plus d'informations.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Activité récente</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-circle text-success" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Notes saisies</div>
                                <div class="text-muted small">Mathématiques - 6ème A</div>
                                <div class="text-muted small">Il y a 2 heures</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-circle text-warning" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Cours terminé</div>
                                <div class="text-muted small">Physique - 3ème B</div>
                                <div class="text-muted small">Il y a 1 jour</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-circle text-info" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Présences mises à jour</div>
                                <div class="text-muted small">Mathématiques - 5ème C</div>
                                <div class="text-muted small">Il y a 2 jours</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('editProfileBtn');
    const updateBtn = document.getElementById('updateProfileBtn'); 
    const cancelBtn = document.getElementById('cancelEditBtn');
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const photoInput = document.getElementById('photoInput');
    const profileImage = document.getElementById('profileImage');
    const profileEditSection = document.getElementById('profileEditSection');
    const form = document.getElementById('profileForm');
    
    // Fields to enable/disable
    const fields = ['lastname', 'firstname', 'email', 'phone', 'birthday', 'job', 'home_address', 'second_phone', 'sex'];
    
    // Store original values
    let originalValues = {};
    
    // Edit mode
    editBtn.addEventListener('click', function() {
        // Store original values
        fields.forEach(field => {
            const element = document.getElementById(field);
            originalValues[field] = element.value;
            element.disabled = false;
        });
        
        // Show edit section and buttons
        profileEditSection.classList.remove('d-none');
        editBtn.classList.add('d-none');
        updateBtn.classList.remove('d-none');
        cancelBtn.classList.remove('d-none');
    });
    
    // Cancel edit
    cancelBtn.addEventListener('click', function() {
        // Restore original values
        fields.forEach(field => {
            const element = document.getElementById(field);
            element.value = originalValues[field];
            element.disabled = true;
        });
        
        // Hide edit section and show edit button
        profileEditSection.classList.add('d-none');
        editBtn.classList.remove('d-none');
        updateBtn.classList.add('d-none');
        cancelBtn.classList.add('d-none');
    });
    
    // Update profile
    updateBtn.addEventListener('click', function() {
        form.submit();
    });
    
    // Change photo
    changePhotoBtn.addEventListener('click', function() {
        photoInput.click();
    });
    
    // Preview photo
    photoInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
});

function showAlert(type, message) {
    const alertContainer = document.getElementById('alert-container');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    alertContainer.innerHTML = '';
    alertContainer.appendChild(alert);

    // Auto-hide après 5 secondes
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}
</script>
@endsection
