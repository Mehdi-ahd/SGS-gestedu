@extends('layouts.parent')

@section('title', 'Mon profil')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mon profil</h1>
    </div>

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
                    <form id="profileForm" method="POST" action="{{ route('parent.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <!-- Profile Photo -->
                            <div class="col-md-4 text-center">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : asset('assets/img/default.webp') }}" alt="Photo de profil" class="rounded-circle border border-3 border-primary" style="width: 150px; height: 150px; object-fit: cover;" id="profileImage">
                                    <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle d-none" id="changePhotoBtn" style="width: 35px; height: 35px;">
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
                                <input type="date" class="form-control" name="birthday" value="{{ (Auth::user()->birthday) ? Auth::user()->birthday->format('d/m/Y') : '' }}" disabled id="birthday">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profession</label>
                                <input type="text" class="form-control" name="job" value="{{ Auth::user()->job ?? '' }}" disabled id="job">
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
                        <a href="{{ route('parent.verification') }}" class="btn btn-primary btn-sm">
                            Vérifier maintenant
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistiques rapides</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="text-primary h4">{{ Auth::user()->students()->count() }}</div>
                            <div class="small text-muted">Enfants</div>
                        </div>
                        <div class="col-6">
                            <div class="text-success h4">3</div>
                            <div class="small text-muted">Messages</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Children Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Mes enfants</h6>
                    <a href="{{ route('parent.showChildren', Auth::user()->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye me-1"></i>Voir tous
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Child Card 1 -->
                        @forelse ($children as $child)
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 border-left-primary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ $user->profil_picture ? Storage::url($user->profil_picture) : asset('assets/img/default.webp') }}"  alt="Thomas Dupont"  class="rounded-circle me-3"  style="width: 60px; height: 60px; object-fit: cover;" >
                                            <div>
                                                <h5 class="card-title mb-1">{{ $child->getFullName() }}</h5>
                                                <span class="badge bg-primary">{{ $child->currentInscription(date("Y") . "-" . (date("Y")+1))->study_level->specification ?? $child->latestInscription()->study_level->specification }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Niveau d'étude
                                                </div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $child->currentInscription(date("Y") . "-" . (date("Y")+1))->study_level->specification ?? $child->latestInscription()->study_level->specification }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Année scolaire
                                                </div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">{{date("Y") . "-" . (date("Y")+1)}}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-center">
                                            <a href="{{ route('parent.student.profile', $child->id)}}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-user me-1"></i>Voir le profil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-6 mb-4">
                                Aucun enregistrement
                            </div>
                            
                        @endforelse
                        
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
        
        // Toggle buttons
        editBtn.classList.add('d-none');
        updateBtn.classList.remove('d-none');
        cancelBtn.classList.remove('d-none');
        changePhotoBtn.classList.remove('d-none');
    });
    
    // Cancel edit
    cancelBtn.addEventListener('click', function() {
        // Restore original values
        fields.forEach(field => {
            const element = document.getElementById(field);
            element.value = originalValues[field];
            element.disabled = true;
        });
        
        // Toggle buttons
        editBtn.classList.remove('d-none');
        updateBtn.classList.add('d-none');
        cancelBtn.classList.add('d-none');
        changePhotoBtn.classList.add('d-none');
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
</script>
@endsection
