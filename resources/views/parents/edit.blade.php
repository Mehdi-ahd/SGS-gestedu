@extends('layouts.app')

@section('title', 'Modifier un parent')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier un parent</h1>
        <div>
            <a href="{{ route('parents.show', $parent->id ) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i> Voir le profil
            </a>
            <a href="{{ route('parents.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informations du parent</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('parents.update', $parent->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <!-- Informations personnelles -->
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Informations personnelles</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ $parent->lastname }}" required>
                                    @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ $parent->firstname }}" required>
                                    @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ $parent->birthday }}">
                                    @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="sex" id="sexM" value="M" {{ ($parent->sex = "M") ? "checked" : " " }} required>
                                            <label class="form-check-label" for="sexM">Masculin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sex" id="sexF" value="F" {{ ($parent->sex = "F") ? "checked" : " " }} required>
                                            <label class="form-check-label" for="sexF">Féminin</label>
                                        </div>
                                    </div>
                                    @error('sex')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="relationship" class="form-label">Relation avec l'élève <span class="text-danger">*</span></label>
                                    <select class="form-select @error('relationship') is-invalid @enderror" id="relationship" name="relationship" required>
                                        <option value="">-- Sélectionnez --</option>
                                        <option value="father" selected>Père</option>
                                        <option value="mother">Mère</option>
                                        <option value="guardian">Tuteur légal</option>
                                        <option value="other">Autre</option>
                                    </select>
                                    @error('relationship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Photo</label>
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ $supervisor->profile_picture ?? asset('assets/img/default.webp') }}" alt="Photo actuelle" class="img-thumbnail me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                        <span class="text-muted small">Photo actuelle</span>
                                    </div>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="identity_photo" name="identity_photo" accept="image/*">
                                    <small class="form-text text-muted">Format JPG ou PNG, max 2Mo. Laissez vide pour conserver la photo actuelle.</small>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Coordonnées -->
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Coordonnées</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $parent->email }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $parent->phone }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="alt_phone" class="form-label">Téléphone secondaire</label>
                                    <input type="tel" class="form-control @error('alt_phone') is-invalid @enderror" id="alt_phone" name="alt_phone" value="{{ $parent->second_phone }}">
                                    @error('alt_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="home_address" class="form-label">Adresse <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('home_address') is-invalid @enderror" id="home_address" name="home_address" rows="3" required>{{ $parent->home_address }}</textarea>
                                    @error('home_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="profession" class="form-label">Profession</label>
                                    <input type="text" class="form-control @error('profession') is-invalid @enderror" id="profession" name="profession" value="{{ $parent->job }}">
                                    @error('profession')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="En attente de soumission" {{ $parent->status === "en attente de soumission" ? "selected" : "" }} >En attente de soumission</option>
                                        <option value="En attente de validation" {{ $parent->status === "en attente de validation" ? "selected" : "" }} >En attente de validation</option>
                                        <option value="Verifié" {{ $parent->status === "verifié" ? "selected" : "" }} >Verifié</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- <div class="row mb-3">
                    <!-- Enfants -->
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Enfants associés</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Sélectionnez les enfants <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="children[]" id="child1" value="1" checked>
                                                <label class="form-check-label" for="child1">Dupont Thomas (6ème A)</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="children[]" id="child2" value="2">
                                                <label class="form-check-label" for="child2">Dubois Marie (5ème B)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="children[]" id="child3" value="3">
                                                <label class="form-check-label" for="child3">Martin Lucas (4ème C)</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="children[]" id="child4" value="4">
                                                <label class="form-check-label" for="child4">Bernard Emma (3ème A)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="children[]" id="child5" value="5">
                                                <label class="form-check-label" for="child5">Petit Hugo (2nde B)</label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('children')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> Si l'enfant n'est pas dans la liste, veuillez d'abord l'ajouter dans la section "Élèves".
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <!-- Informations supplémentaires -->
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Informations supplémentaires</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="emergency_contact" class="form-label">Contact d'urgence?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="emergency_contact" name="emergency_contact" value="1" checked>
                                        <label class="form-check-label" for="emergency_contact">
                                            Désigner comme contact d'urgence
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="can_pickup" class="form-label">Autorisé à récupérer l'enfant?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="can_pickup" name="can_pickup" value="1" checked>
                                        <label class="form-check-label" for="can_pickup">
                                            Autorisé à récupérer l'enfant à l'école
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">Préfère être contacté par email. À contacter en priorité en cas d'urgence concernant son fils.</textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Documents -->
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Documents</h6>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                                    <i class="fas fa-plus-circle me-1"></i> Ajouter un document
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nom du document</th>
                                                <th>Type</th>
                                                <th>Date d'ajout</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($documents as $document)
                                                <tr>
                                                <td>{{ $document->document_type }}</td>
                                                <td><span class="badge bg-danger">Pièce d'identité</span></td>
                                                <td>{{ $document->created_at->format("d/m/Y")}}</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-3">
                                    <label for="new_document" class="form-label">Ajouter un nouveau document</label>
                                    <input type="file" class="form-control @error('new_document') is-invalid @enderror" id="new_document" name="new_document" accept=".pdf,.doc,.docx,.jpg,.png">
                                    <small class="form-text text-muted">Formats acceptés : PDF, Word, images (max 5Mo)</small>
                                    @error('new_document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="new_document_type" class="form-label">Type du document</label>
                                    <select name="new_document_type" class="form-select"  id="new_document_type">
                                        <option value="Carte d'identité nationale">Carte d'identité nationale</option>
                                        <option value="CIP">CIP</option>
                                        <option value="Acte de naissance">Acte de naissance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons d'action -->
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('parents.index') }}'">Annuler</button>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-2">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un document -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Ajouter un document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="documentName" class="form-label">Nom du document</label>
                        <input type="text" class="form-control" id="documentName" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_document_type" class="form-label">Type de document</label>
                        <select class="form-select" id="new_document_type" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="Carte d'identité nationale">Carte d'identité nationale</option>
                            <option value="CIP">CIP</option>
                            <option value="Acte de naissance">Acte de naissance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="documentFile" class="form-label">Fichier</label>
                        <input type="file" class="form-control" id="documentFile" required>
                        <small class="form-text text-muted">Formats acceptés : PDF, Word, images (max 5Mo)</small>
                    </div>
                    <div class="mb-3">
                        <label for="documentDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="documentDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
</div>
@endsection