@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
<div class="page-header">
    <h1>Edit Student</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Elève</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editer un élève</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informations de l'étudiant</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">Prénoms <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ $student->firstname}}" required>
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Nom de famille <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ $student->lastname }}" required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="birthday" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ $student->birthday->format("d/m/Y") }}" required>
                            @error('birthday')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sex" class="form-label">Genre <span class="text-danger">*</span></label>
                            <select class="form-select @error('sex') is-invalid @enderror" id="sex" name="sex" required>
                                <option value="M" selected>Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                            @error('sex')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Adresse mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ ($student->email) ?  $student->email : "Indisponible"}}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">N° de téléphone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ ($student->phone) ?  $student->phone : "Indisponible"}}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Lieu de résidence</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">A gérer</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Information académique</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input type="hidden" name="school_year_id" value="{{ date("Y") . "-" . date("Y")+1}}">
                                        <label for="class_id" class="form-label">Classe({{ $student->inscriptions()->where("school_year_id", date("Y") . "-" . date("Y")+1)->first()->study_level->specification }}) <span class="text-danger"></span></label>
                                        <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id" required>
                                            <option value="">Selectionnez un niveau d'étude</option>
                                            @foreach ($study_levels as $study_level)
                                                <option value="{{ $study_level->id }}">{{ $study_level->specification }}</option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="roll_number" class="form-label">Numéro matricule <span class="text-danger"></span></label>
                                        <input type="text" class="form-control @error('roll_number') is-invalid @enderror" id="roll_number" name="roll_number" value="{{ $student->id }}" disabled>
                                        @error('roll_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                {{-- <div class="mb-3">
                                    <label for="join_date" class="form-label">Admission Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date" value="{{ $student->created_at}}" required>
                                    @error('join_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Informations sur les Parents/Guardiens</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Relation</th>
                                                    <th>Contacts</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ ($father) ? $father->getFullNameAttribute() : "Aucun père enregistrée" }}</td>
                                                    <td>Père</td>
                                                    <td>{{ ($father) ? $father->email : "Indisponible" }}<br>{{ ($father) ? $father->phone : "Indisponible" }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editParentModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{($mother) ? $mother->getFullNameAttribute() : "Aucune mère enregistrée"}}</td>
                                                    <td>Mère</td>
                                                    <td>{{ ($mother) ? $mother->email : "Indisponible" }}<br>{{ ($mother) ? $mother->phone : "Indisponible" }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editParentModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addParentModal">
                                        <i class="fas fa-plus me-1"></i> Add Another Parent/Guardian
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">CARTE D'IDENTITE SCOLAIRE/STUDENT ID CARD</h5>
            </div>
            <div class="card-body">
                <div class="card mb-3 border">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h4 class="mt-3 mb-0 fw-bold">{{ $student->lastname}}</h4>
                            <h5 class="mt-3 mb-0 fw-bold">{{ $student->firstname }}</h5>
                            <div class="mt-3 mb-0 d-flex justifiy-content-align">
                                <img src="" alt="Code Qr a générer" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="ms-3">
                                    <div class="">
                                        <p>Né(e)/Born:   {{$student->birthday->format("d/m/Y")}}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p>A/At:   A ajouter</p>
                                    </div>
                                    <div class="mt-2">
                                        <p>Pays d'Origine/Country:  Benin(A ajouter)</p>
                                    </div>
                                    <div class="mt-2">
                                        <p>Téléphone/Phone:(229)  {{ ($student->phone) ? $student->phone : "Aucun numéro"}}</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p>Validité/Validity</p>
                                {{$student->created_at->format("d/m/Y") . " au " }}
                            </div>
                            <div>
                                <p class="text-muted">Matricule(ID)</p>
                                <p>{{ $student->id}}</p>
                            </div>
                            
                            <div class="avatar avatar-lg mx-auto">
                                <img src="{{ $student->documents->where('document_type', 'Photo identité') ?? asset('assets/img/default.webp')}}" alt="Photo de l'élève" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-outline-primary" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Imprimer la Carte
                    </button>
                </div>
            </div>
        </div>
        
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Statut du compte</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="accountActive" checked>
                        <label class="form-check-label" for="accountActive">Account Active</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="statusNote" class="form-label">Note</label>
                    <textarea class="form-control" id="statusNote" rows="2" placeholder="Add a note about this student's status"></textarea>
                </div>
                <div class="d-grid">
                    <button class="btn btn-outline-success mb-2">
                        <i class="fas fa-envelope me-1"></i> Envoyer mot de passe de réinitialisation
                    </button>
                    <button class="btn btn-outline-danger">
                        <i class="fas fa-user-lock me-1"></i> Suspendre le compte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Parent Modal -->
<div class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editParentModalLabel">Editer les informations du parent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="" >
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="parentFirstName" class="form-label">Prénoms</label>
                            <input type="text" class="form-control" id="parentFirstName" value="{{ ($father) ? $father->firstname : " "}}">
                        </div>
                        <div class="col-md-6">
                            <label for="parentLastName" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="parentLastName" value="{{ ($father) ? $father->lastname : " "}}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="parentRelationship" class="form-label">Relation</label>
                        <select class="form-select" id="parentRelationship">
                            <option value="father" selected>Father</option>
                            <option value="mother">Mother</option>
                            <option value="guardian">Guardian</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="parentEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="parentEmail" value="{{ ($father) ? $father->email : " " }}">
                    </div>
                    <div class="mb-3">
                        <label for="parentPhone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="parentPhone" value="{{ ($father) ? $father->email : " " }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Mettre à jour</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Parent Modal -->
<div class="modal fade" id="addParentModal" tabindex="-1" aria-labelledby="addParentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParentModalLabel">Ajouter Parent/Guardien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Ajouter Parent/Guardien</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="parentOption" id="existingParent" value="existing" checked>
                            <label class="form-check-label" for="existingParent">
                                Parent Existant
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="parentOption" id="newParent" value="new">
                            <label class="form-check-label" for="newParent">
                                Nouveau Parent
                            </label>
                        </div>
                    </div>
                    
                    <div id="existingParentDiv">
                        <div class="mb-3">
                            <label for="selectExistingParent" class="form-label">Selectionner Parent</label>
                            <select class="form-select" id="selectExistingParent">
                                <option value="" selected disabled>Selection</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->lastame . " " . $supervisor->firstname}} ({{ ($supervisor->sex === "M") ? "Father" : "Mother"}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="existingRelationship" class="form-label">Relation</label>
                            <select class="form-select" id="existingRelationship">
                                <option value="father">Père</option>
                                <option value="mother">Mère</option>
                                <option value="guardian" selected>Guardien</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="newParentDiv" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="newParentFirstName" class="form-label">Prénoms</label>
                                <input type="text" class="form-control" id="newParentFirstName">
                            </div>
                            <div class="col-md-6">
                                <label for="newParentLastName" class="form-label">Nom de famille</label>
                                <input type="text" class="form-control" id="newParentLastName">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="newParentRelationship" class="form-label">Relation</label>
                            <select class="form-select" id="newParentRelationship">
                                <option value="father">Père</option>
                                <option value="mother">Mère</option>
                                <option value="guardian" selected>Guardien</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="newParentEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="newParentEmail">
                        </div>
                        <div class="mb-3">
                            <label for="newParentPhone" class="form-label">N° de téléphone</label>
                            <input type="tel" class="form-control" id="newParentPhone">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Ajouter Parent</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle parent options in add parent modal
        $('input[name="parentOption"]').change(function() {
            if ($(this).val() === 'existing') {
                $('#existingParentDiv').show();
                $('#newParentDiv').hide();
            } else {
                $('#existingParentDiv').hide();
                $('#newParentDiv').show();
            }
        });
    });
</script>
@endsection
@endsection