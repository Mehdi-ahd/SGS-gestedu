@extends('layouts.app')

@section('title', 'Ajouter un enseignant')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ajouter un enseignant</h1>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
        </a>
    </div>

    <!-- Formulaire d'ajout -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informations de l'enseignant</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="birthday" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
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
                                    <label for="photo" class="form-label">Photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                                    <small class="form-text text-muted">Format JPG ou PNG, max 2Mo</small>
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
                                    <label for="home_address" class="form-label">Adresse <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('home_address') is-invalid @enderror" id="home_address" name="home_address" rows="3" required>{{ old('home_address') }}</textarea>
                                    @error('home_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="npi" class="form-label">npi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="npi" name="npi" value="{{ old('npi') }}" required>
                                    @error('npi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <!-- Qualifications professionnelles -->
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Qualifications professionnelles</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="qualifications" class="form-label">Diplômes et certifications</label>
                                    <textarea class="form-control @error('qualifications') is-invalid @enderror" id="qualifications" name="qualifications" rows="3">{{ old('qualifications') }}</textarea>
                                    @error('qualifications')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="experience_years" class="form-label">Années d'expérience</label>
                                    <input type="number" class="form-control @error('experience_years') is-invalid @enderror" id="experience_years" name="experience_years" value="{{ old('experience_years') }}" min="0">
                                    @error('experience_years')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Date d'embauche</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Matières enseignées -->
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Matières enseignées</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Sélectionnez les matières enseignées</label>
                                    <div class="row">
                                        @foreach ($subjects as $subject)
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="subjects[]" id="{{ $subject->id }}" value="{{ $subject->id }}" {{ in_array( $subject->id, old('subjects', []) ) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $subject->id }}">{{ $subject->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{-- <div class="col-lg-3 col-md-6">
                                            @if ($number < $subjects->count())
                                                @foreach ($subjects as $subject)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="subjects[]" id="subject4" value="4" {{ in_array('4', old('subjects', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="subject4">Sciences</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div> --}}
                                    </div>
                                    @error('subjects')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes supplémentaires</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Documents supplémentaires -->
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Documents</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="cv" class="form-label">CV</label>
                                    <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" accept=".pdf,.doc,.docx">
                                    <small class="form-text text-muted">Format PDF ou Word, max 5Mo</small>
                                    @error('cv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="diploma" class="form-label">Diplôme(s)</label>
                                    <input type="file" class="form-control @error('diploma') is-invalid @enderror" id="diploma" name="diploma[]" accept=".pdf,.jpg,.png" multiple>
                                    <small class="form-text text-muted">Format PDF ou image, max 5Mo</small>
                                    @error('diploma')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons d'action -->
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('teachers.index') }}'">Annuler</button>
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