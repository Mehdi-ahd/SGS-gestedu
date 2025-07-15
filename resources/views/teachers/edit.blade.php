@extends('layouts.app')

@section('title', 'Modifier un enseignant')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier un enseignant</h1>
        <div>
            <a href="{{ route('teachers.show', $teacher->id ?? 1) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i> Voir le profil
            </a>
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informations de l'enseignant</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('teachers.update', $teacher->id ?? 1) }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="Martin" required>
                                    @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="Philippe" required>
                                    @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="1975-04-15" required>
                                    @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="sex" id="sexM" value="M" checked required>
                                            <label class="form-check-label" for="sexM">Masculin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sex" id="sexF" value="F" required>
                                            <label class="form-check-label" for="sexF">Féminin</label>
                                        </div>
                                    </div>
                                    @error('sex')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Photo</label>
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('img/teacher-avatar.jpg') }}" alt="Photo actuelle" class="img-thumbnail me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                        <span class="text-muted small">Photo actuelle</span>
                                    </div>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
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
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="philippe.martin@example.com" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="+33 6 12 34 56 78" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="home_address" class="form-label">Adresse <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('home_address') is-invalid @enderror" id="home_address" name="home_address" rows="3" required>123 Avenue des Sciences, 75001 Paris, France</textarea>
                                    @error('home_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">Statut</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="active" selected>Actif</option>
                                        <option value="inactive">Inactif</option>
                                        <option value="on_leave">En congé</option>
                                    </select>
                                    @error('status')
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
                                    <textarea class="form-control @error('qualifications') is-invalid @enderror" id="qualifications" name="qualifications" rows="3">Doctorat en Mathématiques, Université de Paris (2005)
Master en Sciences Physiques, École Normale Supérieure (2000)
Agrégation de Mathématiques (2002)</textarea>
                                    @error('qualifications')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="experience_years" class="form-label">Années d'expérience</label>
                                    <input type="number" class="form-control @error('experience_years') is-invalid @enderror" id="experience_years" name="experience_years" value="15" min="0">
                                    @error('experience_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Date d'embauche</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="2020-09-05">
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
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="subjects[]" id="subject1" value="1" checked>
                                                <label class="form-check-label" for="subject1">Mathématiques</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="subjects[]" id="subject2" value="2">
                                                <label class="form-check-label" for="subject2">Français</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="subjects[]" id="subject3" value="3">
                                                <label class="form-check-label" for="subject3">Histoire-Géographie</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="subjects[]" id="subject4" value="4" checked>
                                                <label class="form-check-label" for="subject4">Physique</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="subjects[]" id="subject5" value="5">
                                                <label class="form-check-label" for="subject5">Anglais</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="subjects[]" id="subject6" value="6">
                                                <label class="form-check-label" for="subject6">Informatique</label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('subjects')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes supplémentaires</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">Philippe est spécialisé dans la préparation aux concours et olympiades de mathématiques. Il anime également le club de sciences du lycée tous les mercredis après-midi.</textarea>
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
                                            <tr>
                                                <td>CV.pdf</td>
                                                <td><span class="badge bg-danger">PDF</span></td>
                                                <td>12/09/2020</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Diplome_Doctorat.pdf</td>
                                                <td><span class="badge bg-danger">PDF</span></td>
                                                <td>12/09/2020</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Attestation_Agregation.pdf</td>
                                                <td><span class="badge bg-danger">PDF</span></td>
                                                <td>12/09/2020</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
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
                        <label for="documentType" class="form-label">Type de document</label>
                        <select class="form-select" id="documentType" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="cv">CV</option>
                            <option value="diploma">Diplôme</option>
                            <option value="certificate">Certificat</option>
                            <option value="other">Autre</option>
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