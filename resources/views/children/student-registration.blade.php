
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

    <form action="" method="POST" enctype="multipart/form-data">
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
                                    {{-- @foreach ($study_levels as $study_level)
                                        <option value="{{$study_level->id}}" {{ old('study_level_id') == $study_level->id ? 'selected' : '' }}>
                                            {{$study_level->specification}}
                                        </option>
                                    @endforeach --}}
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

                <!-- Informations des parents -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-users me-2"></i>
                            Informations des parents
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Père -->
                        <div class="mb-4">
                            <h6 class="text-secondary mb-3">
                                <i class="fas fa-male me-2"></i>
                                Informations du père
                            </h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="father_firstname" class="form-label">Prénom du père <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('father_firstname') is-invalid @enderror" id="father_firstname" name="father_firstname" value="{{ old('father_firstname') }}" required>
                                    @error('father_firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="father_lastname" class="form-label">Nom du père <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('father_lastname') is-invalid @enderror" id="father_lastname" name="father_lastname" value="{{ old('father_lastname') }}" required>
                                    @error('father_lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="father_phone" class="form-label">Téléphone du père <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('father_phone') is-invalid @enderror" id="father_phone" name="father_phone" value="{{ old('father_phone') }}" required>
                                    @error('father_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="father_email" class="form-label">Email du père</label>
                                    <input type="email" class="form-control @error('father_email') is-invalid @enderror" id="father_email" name="father_email" value="{{ old('father_email') }}">
                                    @error('father_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="father_job" class="form-label">Profession du père</label>
                                    <input type="text" class="form-control @error('father_job') is-invalid @enderror" id="father_job" name="father_job" value="{{ old('father_job') }}">
                                    @error('father_job')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="father_work_address" class="form-label">Lieu de travail du père</label>
                                    <input type="text" class="form-control @error('father_work_address') is-invalid @enderror" id="father_work_address" name="father_work_address" value="{{ old('father_work_address') }}">
                                    @error('father_work_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Mère -->
                        <div class="mb-4">
                            <h6 class="text-secondary mb-3">
                                <i class="fas fa-female me-2"></i>
                                Informations de la mère
                            </h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="mother_firstname" class="form-label">Prénom de la mère <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mother_firstname') is-invalid @enderror" id="mother_firstname" name="mother_firstname" value="{{ old('mother_firstname') }}" required>
                                    @error('mother_firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_lastname" class="form-label">Nom de la mère <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mother_lastname') is-invalid @enderror" id="mother_lastname" name="mother_lastname" value="{{ old('mother_lastname') }}" required>
                                    @error('mother_lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="mother_phone" class="form-label">Téléphone de la mère <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('mother_phone') is-invalid @enderror" id="mother_phone" name="mother_phone" value="{{ old('mother_phone') }}" required>
                                    @error('mother_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_email" class="form-label">Email de la mère</label>
                                    <input type="email" class="form-control @error('mother_email') is-invalid @enderror" id="mother_email" name="mother_email" value="{{ old('mother_email') }}">
                                    @error('mother_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="mother_job" class="form-label">Profession de la mère</label>
                                    <input type="text" class="form-control @error('mother_job') is-invalid @enderror" id="mother_job" name="mother_job" value="{{ old('mother_job') }}">
                                    @error('mother_job')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_work_address" class="form-label">Lieu de travail de la mère</label>
                                    <input type="text" class="form-control @error('mother_work_address') is-invalid @enderror" id="mother_work_address" name="mother_work_address" value="{{ old('mother_work_address') }}">
                                    @error('mother_work_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Tuteur/Personne de contact -->
                        <div class="mb-4">
                            <h6 class="text-secondary mb-3">
                                <i class="fas fa-user-shield me-2"></i>
                                Personne de contact/Tuteur (optionnel)
                            </h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="guardian_firstname" class="form-label">Prénom du tuteur</label>
                                    <input type="text" class="form-control @error('guardian_firstname') is-invalid @enderror" id="guardian_firstname" name="guardian_firstname" value="{{ old('guardian_firstname') }}">
                                    @error('guardian_firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="guardian_lastname" class="form-label">Nom du tuteur</label>
                                    <input type="text" class="form-control @error('guardian_lastname') is-invalid @enderror" id="guardian_lastname" name="guardian_lastname" value="{{ old('guardian_lastname') }}">
                                    @error('guardian_lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="guardian_phone" class="form-label">Téléphone du tuteur</label>
                                    <input type="tel" class="form-control @error('guardian_phone') is-invalid @enderror" id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone') }}">
                                    @error('guardian_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="guardian_relation" class="form-label">Lien avec l'enfant</label>
                                    <select class="form-select @error('guardian_relation') is-invalid @enderror" id="guardian_relation" name="guardian_relation">
                                        <option value="">Sélectionner</option>
                                        <option value="oncle" {{ old('guardian_relation') == 'oncle' ? 'selected' : '' }}>Oncle</option>
                                        <option value="tante" {{ old('guardian_relation') == 'tante' ? 'selected' : '' }}>Tante</option>
                                        <option value="grand-pere" {{ old('guardian_relation') == 'grand-pere' ? 'selected' : '' }}>Grand-père</option>
                                        <option value="grand-mere" {{ old('guardian_relation') == 'grand-mere' ? 'selected' : '' }}>Grand-mère</option>
                                        <option value="autre" {{ old('guardian_relation') == 'autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                    @error('guardian_relation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents d'identité parents -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-id-card me-2"></i>
                            Documents d'identité des parents
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Veuillez télécharger les documents d'identité des deux parents (CNI, passeport, etc.)
                        </div>
                        
                        <div class="mb-3">
                            <label for="parent_identity_documents" class="form-label">Documents d'identité <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('parent_identity_documents') is-invalid @enderror" id="parent_identity_documents" name="parent_identity_documents[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple required>
                            <div class="form-text">Vous pouvez sélectionner plusieurs fichiers. Formats acceptés: PDF, Images, Word</div>
                            @error('parent_identity_documents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="selected-files" class="mt-3"></div>
                    </div>
                </div>

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
        
        // Gestion des fichiers multiples
        const parentDocsInput = document.getElementById('parent_identity_documents');
        const selectedFilesDiv = document.getElementById('selected-files');
        
        parentDocsInput.addEventListener('change', function() {
            selectedFilesDiv.innerHTML = '';
            
            if (this.files.length > 0) {
                const filesList = document.createElement('div');
                filesList.className = 'selected-files-list';
                
                const title = document.createElement('h6');
                title.textContent = 'Fichiers sélectionnés:';
                title.className = 'mb-2';
                filesList.appendChild(title);
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const fileDiv = document.createElement('div');
                    fileDiv.className = 'selected-file d-flex align-items-center mb-2 p-2 bg-light rounded';
                    
                    const icon = getFileIcon(file.name);
                    const fileName = document.createElement('span');
                    fileName.textContent = file.name;
                    fileName.className = 'ms-2 flex-grow-1';
                    
                    const fileSize = document.createElement('small');
                    fileSize.textContent = formatFileSize(file.size);
                    fileSize.className = 'text-muted';
                    
                    fileDiv.appendChild(icon);
                    fileDiv.appendChild(fileName);
                    fileDiv.appendChild(fileSize);
                    
                    filesList.appendChild(fileDiv);
                }
                
                selectedFilesDiv.appendChild(filesList);
            }
        });
        
        function getFileIcon(filename) {
            const icon = document.createElement('i');
            icon.className = 'fas me-2';
            
            const ext = filename.split('.').pop().toLowerCase();
            
            switch (ext) {
                case 'pdf':
                    icon.classList.add('fa-file-pdf', 'text-danger');
                    break;
                case 'doc':
                case 'docx':
                    icon.classList.add('fa-file-word', 'text-primary');
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    icon.classList.add('fa-file-image', 'text-success');
                    break;
                default:
                    icon.classList.add('fa-file', 'text-secondary');
            }
            
            return icon;
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // Validation du formulaire
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let allValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!allValid) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires.');
            }
        });
    });
</script>
@endsection
