@extends('layouts.app')

@section('title', 'Détails du parent')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails du parent</h1>
        <div>
            <a href="{{ route('parents.edit', $supervisor->id) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i> Modifier
            </a>
            <a href="{{ route('parents.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Profil de base -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $supervisor->profile_picture ?? asset('assets/img/default.webp')}}" alt="Photo du parent" class="img-profile rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h4 class="font-weight-bold">{{ $supervisor->getFullNameAttribute() }}</h4>
                    <p class="text-muted mb-1">{{ ($supervisor->sex === "M") ? "Père" : "Mère"}}</p>
                    <p class="mb-4"><span class="badge bg-success">Actif</span></p>
                    
                    <div class="d-flex justify-content-center mb-2">
                        <a href="mailto:{{ $supervisor->email }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-envelope me-1"></i> Email
                        </a>
                        <a href="tel:{{ $supervisor->phone }}" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-1"></i> Appeler
                        </a>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">ID: {{ $supervisor->id }}</small>
                        <small class="text-muted">Inscrit depuis: {{ $supervisor->created_at->format("d/m/Y") }}</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Informations personnelles -->
        <div class="col-md-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations personnelles</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Nom complet</h6>
                            <p>{{ $supervisor->getFullNameAttribute() }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Relation</h6>
                            <p>{{ ($supervisor->sex === "M") ? "Père" : "Mère"}}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Email</h6>
                            <p>{{ $supervisor->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Téléphone principal</h6>
                            <p>{{ $supervisor->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Téléphone secondaire</h6>
                            <p>{{ $supervisor->second_phone ?? "" }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Profession</h6>
                            <p>{{ ($supervisor->job) ? $supervisor->job : "Aucun métier enregistré" }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Adresse de travail</h6>
                            <p>{{ $supervisor->work_address }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <h6 class="text-primary">Adresse</h6>
                            <p>{{ $supervisor->home_address }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Contact d'urgence</h6>
                            <p><span class="badge bg-success">Oui</span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Autorisé à récupérer l'enfant</h6>
                            <p><span class="badge bg-success">Oui</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Enfants associés -->
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Enfants associés</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Classe</th>
                                    <th>Date de naissance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($children as $child)
                                    <tr>
                                        <td>{{ $child->id }}</td>
                                        <td>{{ $child->lastname }}</td>
                                        <td>{{ $child->firstname }}</td>
                                        <td>A gérer</td>
                                        <td>{{ $child->birthday }}</td>
                                        <td>
                                            <a href="{{ route("students.show", $child->id )}}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <strong>A gérer</strong>
        <!-- Communications -->
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Communications récentes</h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-envelope me-1"></i> Envoyer un message
                    </a>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="font-weight-bold"><i class="fas fa-envelope me-2 text-primary"></i> Email envoyé</span>
                                <small class="text-muted">15/03/2023</small>
                            </div>
                            <p class="mb-0">Convocation à la réunion parents-professeurs du deuxième trimestre</p>
                        </div>
                        <div class="timeline-item mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="font-weight-bold"><i class="fas fa-phone me-2 text-success"></i> Appel téléphonique</span>
                                <small class="text-muted">02/02/2023</small>
                            </div>
                            <p class="mb-0">Discussion concernant les résultats du premier semestre</p>
                        </div>
                        <div class="timeline-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="font-weight-bold"><i class="fas fa-comment me-2 text-info"></i> Message reçu</span>
                                <small class="text-muted">15/12/2022</small>
                            </div>
                            <p class="mb-0">Demande d'informations sur le voyage scolaire</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="btn btn-link">Voir l'historique complet</a>
                </div>
            </div>
        </div>
        
        <!-- Documents -->
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Documents</h6>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter
                    </button>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach ($documents as $document)
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-id-card me-2 text-danger"></i> {{ $document->document_type }}
                                    <small class="d-block text-muted">Ajouté le {{ $document->created_at->format("d/m/Y") }}</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notes et commentaires</h6>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        <div class="mb-3">
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Ajouter une note...">Préfère être contacté par email. À contacter en priorité en cas d'urgence concernant son fils.</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Enregistrer la note
                        </button>
                    </form>
                </div>
            </div>
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
                            <option value="id">Pièce d'identité</option>
                            <option value="authorization">Autorisation parentale</option>
                            <option value="medical">Document médical</option>
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