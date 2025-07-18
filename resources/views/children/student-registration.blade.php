
@extends('layouts.parent')

@section('title', 'Inscription de mon enfant')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="h3 mb-2 mb-md-0 text-gray-800">Inscription de mon enfant</h1>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('parent.dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inscription enfant</li>
            </ol>
        </nav>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route("parent.studentRegistrationProcess")}}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- Informations personnelles de l'enfant -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user me-2"></i>
                            Informations personnelles de l'enfant
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="birthday" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
                                @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="sex" class="form-label">Sexe <span class="text-danger">*</span></label>
                                <select class="form-select @error('sex') is-invalid @enderror" id="sex" name="sex" required>
                                    <option value="" selected disabled>Sélectionner</option>
                                    <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('sex')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Numéro de téléphone</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="home_address" class="form-label">Adresse domicile</label>
                            <textarea class="form-control @error('home_address') is-invalid @enderror" id="home_address" name="home_address" rows="3">{{ old('home_address') }}</textarea>
                            @error('home_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informations académiques -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-graduation-cap me-2"></i>
                            Informations académiques
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="study_level_id" class="form-label">Niveau d'étude <span class="text-danger">*</span></label>
                                <select class="form-select @error('study_level_id') is-invalid @enderror" id="study_level_id" name="study_level_id" required>
                                    <option value="" selected disabled>Sélectionner un niveau</option>
                                    @foreach ($study_levels as $study_level)
                                        <option value="{{$study_level->id}}" {{ old('study_level_id') == $study_level->id ? 'selected' : '' }}>
                                            {{$study_level->specification}}
                                        </option>
                                    @endforeach 
                                </select>
                                @error('study_level_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="school_year_id" value="{{ date('Y') . '-' . (date('Y')+1) }}">
                        
                        <div class="mb-3">
                            <label for="registration_date" class="form-label">Date d'inscription <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('registration_date') is-invalid @enderror" id="registration_date" name="registration_date" value="{{ old('registration_date', date('Y-m-d')) }}" required>
                            @error('registration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Documents de l'enfant -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-folder-open me-2"></i>
                            Documents de l'enfant
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="birth_certificate" class="form-label">Acte de naissance <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('birth_certificate') is-invalid @enderror" id="birth_certificate" name="birth_certificate" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                                <div class="form-text">Formats acceptés: PDF, Images, Word</div>
                                @error('birth_certificate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="school_certificate" class="form-label">Certificat de scolarité <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('school_certificate') is-invalid @enderror" id="school_certificate" name="school_certificate" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                                <div class="form-text">Formats acceptés: PDF, Images, Word</div>
                                @error('school_certificate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="previous_report" class="form-label">Bulletin de l'année écoulée <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('previous_report') is-invalid @enderror" id="previous_report" name="previous_report" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                            <div class="form-text">Formats acceptés: PDF, Images, Word</div>
                            @error('previous_report')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if (Auth::user()->sex === "F")
                    <!-- Information du père -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-male me-2"></i>
                                Information du père
                            </h6>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="toggleFatherExisting" name="toggle_father_existing">
                                <label class="form-check-label" for="toggleFatherExisting">Utiliser un père existant</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Sélection d'un père existant -->
                            <div id="existingFatherSection" style="display: none;">
                                <div class="mb-3">
                                    <label for="father_id" class="form-label">Sélectionner le père</label>
                                    <select class="form-select @error('father_id') is-invalid @enderror" id="father_id" name="father_id">
                                        <option value="" selected disabled>Sélectionner</option>
                                        @forelse ($fathers as $father)
                                            <option value="{{ $father->id }}" {{ old('father_id') == $father->id ? 'selected' : '' }}>
                                                {{ $father->getFullNameAttribute() }}
                                            </option>
                                        @empty
                                            <option value="">Aucun père à associer</option>
                                        @endforelse
                                    </select>
                                    @error('father_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Ajout d'un nouveau père -->
                            <div id="newFatherSection">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="father_firstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('father_firstname') is-invalid @enderror" id="father_firstname" name="father_firstname" value="{{ old('father_firstname') }}" required>
                                        @error('father_firstname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="father_lastname" class="form-label">Nom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('father_lastname') is-invalid @enderror" id="father_lastname" name="father_lastname" value="{{ old('father_lastname') }}" required>
                                        @error('father_lastname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="father_birthday" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control @error('father_birthday') is-invalid @enderror" id="father_birthday" name="father_birthday" value="{{ old('father_birthday') }}">
                                        @error('father_birthday')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="father_phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control @error('father_phone') is-invalid @enderror" id="father_phone" name="father_phone" value="{{ old('father_phone') }}" required>
                                        @error('father_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="father_email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('father_email') is-invalid @enderror" id="father_email" name="father_email" value="{{ old('father_email') }}">
                                        @error('father_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="father_job" class="form-label">Profession</label>
                                        <input type="text" class="form-control @error('father_job') is-invalid @enderror" id="father_job" name="father_job" value="{{ old('father_job') }}">
                                        @error('father_job')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="father_home_address" class="form-label">Adresse domicile</label>
                                    <textarea class="form-control @error('father_home_address') is-invalid @enderror" id="father_home_address" name="father_home_address" rows="2">{{ old('father_home_address') }}</textarea>
                                    @error('father_home_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="father_work_address" class="form-label">Adresse professionnelle</label>
                                    <textarea class="form-control @error('father_work_address') is-invalid @enderror" id="father_work_address" name="father_work_address" rows="2">{{ old('father_work_address') }}</textarea>
                                    @error('father_work_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Information de la mère -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-female me-2"></i>
                                Information de la mère
                            </h6>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="toggleMotherExisting" name="toggle_mother_existing">
                                <label class="form-check-label" for="toggleMotherExisting">Utiliser une mère existante</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Sélection d'une mère existante -->
                            <div id="existingMotherSection" style="display: none;">
                                <div class="mb-3">
                                    <label for="mother_id" class="form-label">Sélectionner la mère</label>
                                    <select class="form-select @error('mother_id') is-invalid @enderror" id="mother_id" name="mother_id">
                                        <option value="" selected disabled>Sélectionner</option>
                                        @forelse ($mothers as $mother)
                                            <option value="{{ $mother->id }}" {{ old('mother_id') == $mother->id ? 'selected' : '' }}>
                                                {{ $mother->getFullNameAttribute() }}
                                            </option>
                                        @empty
                                            <option value="">Aucune mère à associer</option>
                                        @endforelse
                                    </select>
                                    @error('mother_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Ajout d'une nouvelle mère -->
                            <div id="newMotherSection">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="mother_firstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mother_firstname') is-invalid @enderror" id="mother_firstname" name="mother_firstname" value="{{ old('mother_firstname') }}" required>
                                        @error('mother_firstname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mother_lastname" class="form-label">Nom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mother_lastname') is-invalid @enderror" id="mother_lastname" name="mother_lastname" value="{{ old('mother_lastname') }}" required>
                                        @error('mother_lastname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="mother_birthday" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control @error('mother_birthday') is-invalid @enderror" id="mother_birthday" name="mother_birthday" value="{{ old('mother_birthday') }}">
                                        @error('mother_birthday')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mother_phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control @error('mother_phone') is-invalid @enderror" id="mother_phone" name="mother_phone" value="{{ old('mother_phone') }}" required>
                                        @error('mother_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="mother_email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('mother_email') is-invalid @enderror" id="mother_email" name="mother_email" value="{{ old('mother_email') }}">
                                        @error('mother_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mother_job" class="form-label">Profession</label>
                                        <input type="text" class="form-control @error('mother_job') is-invalid @enderror" id="mother_job" name="mother_job" value="{{ old('mother_job') }}">
                                        @error('mother_job')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="mother_home_address" class="form-label">Adresse domicile</label>
                                    <textarea class="form-control @error('mother_home_address') is-invalid @enderror" id="mother_home_address" name="mother_home_address" rows="2">{{ old('mother_home_address') }}</textarea>
                                    @error('mother_home_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="mother_work_address" class="form-label">Adresse professionnelle</label>
                                    <textarea class="form-control @error('mother_work_address') is-invalid @enderror" id="mother_work_address" name="mother_work_address" rows="2">{{ old('mother_work_address') }}</textarea>
                                    @error('mother_work_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Boutons d'action -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                            <a href="{{ route('parent.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>
                                Soumettre l'inscription
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar - Photo et informations -->
            <div class="col-lg-4">
                <!-- Photo de l'enfant -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-camera me-2"></i>
                            Photo de l'enfant
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img id="preview" src="{{ asset('img/default-student.png') }}" alt="Photo de l'enfant" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" onchange="previewImage(this)">
                            <div class="form-text">Image uniquement (JPG, PNG)</div>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informations importantes -->
                <div class="card shadow mb-4 border-left-warning">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Informations importantes
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Tous les champs marqués d'une étoile (*) sont obligatoires
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Les documents doivent être lisibles et en bon état
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Vérifiez l'exactitude des informations avant soumission
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Vous recevrez une confirmation par email
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle pour le formulaire du père
        const toggleFatherExistingCheckbox = document.getElementById('toggleFatherExisting');
        const existingFatherSection = document.getElementById('existingFatherSection');
        const newFatherSection = document.getElementById('newFatherSection');
        
        toggleFatherExistingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                existingFatherSection.style.display = 'block';
                newFatherSection.style.display = 'none';
                // Désactiver les champs requis du nouveau père
                newFatherSection.querySelectorAll('input[required]').forEach(input => {
                    input.removeAttribute('required');
                });
            } else {
                existingFatherSection.style.display = 'none';
                newFatherSection.style.display = 'block';
                // Réactiver les champs requis du nouveau père
                document.getElementById('father_firstname').setAttribute('required', '');
                document.getElementById('father_lastname').setAttribute('required', '');
                document.getElementById('father_phone').setAttribute('required', '');
            }
        });
        
        // Toggle pour le formulaire de la mère
        const toggleMotherExistingCheckbox = document.getElementById('toggleMotherExisting');
        const existingMotherSection = document.getElementById('existingMotherSection');
        const newMotherSection = document.getElementById('newMotherSection');
        
        toggleMotherExistingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                existingMotherSection.style.display = 'block';
                newMotherSection.style.display = 'none';
                // Désactiver les champs requis de la nouvelle mère
                newMotherSection.querySelectorAll('input[required]').forEach(input => {
                    input.removeAttribute('required');
                });
            } else {
                existingMotherSection.style.display = 'none';
                newMotherSection.style.display = 'block';
                // Réactiver les champs requis de la nouvelle mère
                document.getElementById('mother_firstname').setAttribute('required', '');
                document.getElementById('mother_lastname').setAttribute('required', '');
                document.getElementById('mother_phone').setAttribute('required', '');
            }
        });
        
        // Prévisualisation de l'image
        window.previewImage = function(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
@endsection
