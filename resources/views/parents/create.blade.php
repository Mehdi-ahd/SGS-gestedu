@extends('layouts.app')

@section('title', 'Ajouter un parent')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ajouter un parent</h1>
        <a href="{{ route('parents.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
        </a>
    </div>

    <!-- Formulaire d'ajout -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informations du parent</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('parents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
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
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                                    @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                                    @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday') }}">
                                    @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="sex" id="sexM" value="M" {{ old('sex') == 'M' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="sexM">Masculin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sex" id="sexF" value="F" {{ old('sex') == 'F' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="sexF">Féminin</label>
                                        </div>
                                    </div>
                                    @error('sex')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="job" class="form-label">Profession</label>
                                    <input type="text" class="form-control @error('job') is-invalid @enderror" id="job" name="job" value="{{ old('job') }}">
                                    @error('job')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="relationship" class="form-label">Relation avec l'élève <span class="text-danger">*</span></label>
                                    <select class="form-select @error('relationship') is-invalid @enderror" id="relationship" name="relationship" required>
                                        <option value="">-- Sélectionnez --</option>
                                        <option value="father" {{ old('relationship') == 'father' ? 'selected' : '' }}>Père</option>
                                        <option value="mother" {{ old('relationship') == 'mother' ? 'selected' : '' }}>Mère</option>
                                        <option value="guardian" {{ old('relationship') == 'guardian' ? 'selected' : '' }}>Tuteur légal</option>
                                        <option value="other" {{ old('relationship') == 'other' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                    @error('relationship')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                                    <small class="form-text text-muted">Format JPG ou PNG, max 2Mo</small>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
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
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="second_phone" class="form-label">Téléphone secondaire</label>
                                    <input type="tel" class="form-control @error('second_phone') is-invalid @enderror" id="second_phone" name="second_phone" value="{{ old('second_phone') }}">
                                    @error('second_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="home_address" class="form-label">Adresse <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('home_address') is-invalid @enderror" id="home_address" name="home_address" rows="3" required>{{ old('home_address') }}</textarea>
                                    @error('home_address')
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
                                            @foreach ($children as $child)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="children[]" id="{{ $child->id }}" value="{{ $child->id }}" {{ in_array( $child->id , old('children', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $child->id }}">{{ $child->getFullNameAttribute() . " " . "(La classe doit etre ici)"}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="children[]" id="child3" value="3" {{ in_array('3', old('children', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="child3">Martin Lucas (4ème C)</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="children[]" id="child4" value="4" {{ in_array('4', old('children', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="child4">Bernard Emma (3ème A)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="children[]" id="child5" value="5" {{ in_array('5', old('children', [])) ? 'checked' : '' }}>
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
                </div>

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
                                        <input class="form-check-input" type="checkbox" id="emergency_contact" name="emergency_contact" value="1" {{ old('emergency_contact') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="emergency_contact">
                                            Désigner comme contact d'urgence
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="can_pickup" class="form-label">Autorisé à récupérer l'enfant?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="can_pickup" name="can_pickup" value="1" {{ old('can_pickup') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="can_pickup">
                                            Autorisé à récupérer l'enfant à l'école
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                    <!-- Documents -->
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Documents</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="identity_photo" class="form-label">Pièce d'identité</label>
                                    <input type="file" class="form-control @error('identity_photo') is-invalid @enderror" id="identity_photo" name="identity_photo" accept=".pdf,.jpg,.png">
                                    <small class="form-text text-muted">Format PDF ou image, max 5Mo</small>
                                    @error('identity_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="other_documents" class="form-label">Autres documents</label>
                                    <input type="file" class="form-control @error('other_documents') is-invalid @enderror" id="other_documents" name="other_documents[]" accept=".pdf,.jpg,.png,.doc,.docx" multiple>
                                    <small class="form-text text-muted">Formats acceptés : PDF, images, Word (max 5Mo par fichier)</small>
                                    @error('other_documents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                            <i class="fas fa-save me-2"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection