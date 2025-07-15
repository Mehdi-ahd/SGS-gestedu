@extends('layouts.app')

@section('title', 'Ajouter un nouvel élève')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ajouter un nouvel élève</h1>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Élèves</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ajouter un élève</li>
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

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Informations personnelles de l'élève -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations personnelles</h6>
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
                                <label for="email" class="form-label">Adresse email <span class="text-danger"></span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
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
                            <textarea class="form-control @error('address') is-invalid @enderror" id="home_address" name="home_address" rows="3">{{ old('home_address') }}</textarea>
                            @error('home_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informations académiques -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations académiques</h6>
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

                        <div class="container">
                            <input type="hidden" name="school_year_id" value="{{ date("Y") . "-" . (date("Y")+1)}}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="registration_date" class="form-label">Date d'inscription <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('registration_date') is-invalid @enderror" id="registration_date" name="registration_date" value="{{ old('registration_date', date('Y-m-d')) }}" required>
                            @error('registration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Information du père -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Information du père</h6>
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
                                    @foreach ($fathers as $father)
                                        <option value="{{ $father->id }}" {{ old('father_id') == $father->id ? 'selected' : '' }}>
                                            {{ $father->getFullNameAttribute() }}
                                        </option>
                                    @endforeach
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
                                    <label for="father_firstname" class="form-label">Prénom</label>
                                    <input type="text" class="form-control @error('father_firstname') is-invalid @enderror" id="father_firstname" name="father_firstname" value="{{ old('father_firstname') }}">
                                    @error('father_firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="father_lastname" class="form-label">Nom</label>
                                    <input type="text" class="form-control @error('father_lastname') is-invalid @enderror" id="father_lastname" name="father_lastname" value="{{ old('father_lastname') }}">
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
                                    <label for="father_phone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error('father_phone') is-invalid @enderror" id="father_phone" name="father_phone" value="{{ old('father_phone') }}">
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

                <!-- Information de la mère -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Information de la mère</h6>
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
                                    @foreach ($mothers as $mother)
                                        <option value="{{ $mother->id }}" {{ old('mother_id') == $mother->id ? 'selected' : '' }}>
                                            {{ $mother->getFullNameAttribute() }}
                                        </option>
                                    @endforeach
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
                                    <label for="mother_firstname" class="form-label">Prénom</label>
                                    <input type="text" class="form-control @error('mother_firstname') is-invalid @enderror" id="mother_firstname" name="mother_firstname" value="{{ old('mother_firstname') }}">
                                    @error('mother_firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_lastname" class="form-label">Nom</label>
                                    <input type="text" class="form-control @error('mother_lastname') is-invalid @enderror" id="mother_lastname" name="mother_lastname" value="{{ old('mother_lastname') }}">
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
                                    <label for="mother_phone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error('mother_phone') is-invalid @enderror" id="mother_phone" name="mother_phone" value="{{ old('mother_phone') }}">
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
                <div class="mb-3">
                        <label class="form-label">Account Information</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="createAccount" name="create_account" checked>
                                    <label class="form-check-label" for="createAccount">
                                        Create User Account
                                    </label>
                                    <div class="form-text">A user account will be created for the student using the provided email address.</div>
                                </div>
                                
                                <div id="passwordFields">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-toggle="#password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="form-text">Leave blank to generate a random password</div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-toggle="#password_confirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            
            <!-- Sidebar (Photo et boutons d'action) -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Photo de l'élève</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img id="preview" src="{{ asset('img/default-student.png') }}" alt="Photo de l'élève" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" onchange="previewImage(this)">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Acte de naissance</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img id="preview" src="{{ asset('img/default-student.png') }}" alt="Photo de l'élève" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            <input type="file" class="form-control @error('birth_act') is-invalid @enderror" id="birth_act" name="birthd_act" accept="image/*" onchange="previewImage(this)">
                            @error('birth_act')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div> --}}
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-save me-2"></i> Enregistrer l'élève
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary btn-block  mb-2">
                            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                        </a>
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
            } else {
                existingFatherSection.style.display = 'none';
                newFatherSection.style.display = 'block';
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
            } else {
                existingMotherSection.style.display = 'none';
                newMotherSection.style.display = 'block';
            }
        });
        
        // Chargement des classes en fonction du niveau d'étude
        const studyLevelSelect = document.getElementById('study_level_id');
        const classroomSelect = document.getElementById('classroom_id');
        
        studyLevelSelect.addEventListener('change', function() {
            const studyLevelId = this.value;
            if (studyLevelId) {
                fetch(`/api/classrooms-by-level/${studyLevelId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="" selected disabled>Sélectionner une classe</option>';
                        data.forEach(classroom => {
                            options += `<option value="${classroom.id}">${classroom.name}</option>`;
                        });
                        classroomSelect.innerHTML = options;
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des classes:', error);
                    });
            }
        });
    });
    
    // Prévisualisation de l'image
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle password visibility
        $('.toggle-password').click(function() {
            const target = $($(this).data('toggle'));
            const type = target.attr('type') === 'password' ? 'text' : 'password';
            target.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
        
        // Toggle account creation fields
        $('#createAccount').change(function() {
            if(this.checked) {
                $('#passwordFields').show();
            } else {
                $('#passwordFields').hide();
            }
        });
</script>
@endsection