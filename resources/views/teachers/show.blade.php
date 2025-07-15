@extends('layouts.app')

@section('title', 'Détails de l\'enseignant')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de l'enseignant</h1>
        <div>
            <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i> Modifier
            </a>
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
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
                    <img src="{{ asset('img/teacher-avatar.jpg') }}" alt="Photo de l'enseignant" class="img-profile rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h4 class="font-weight-bold">{{ $teacher->getFullNameAttribute() }}</h4>
                    <p class="text-muted mb-1">Enseignant de @foreach ($teacher->subject as $sbject)
                        $subject->name
                    @endforeach </p>
                    <p class="mb-4"><span class="badge bg-success">Actif</span></p>
                    
                    <div class="d-flex justify-content-center mb-2">
                        <a href="mailto:philippe.martin@example.com" class="btn btn-outline-primary me-2">
                            <i class="fas fa-envelope me-1"></i> Email
                        </a>
                        <a href="tel:+33612345678" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-1"></i> Appeler
                        </a>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">ID: #1</small>
                        <small class="text-muted">Inscrit depuis: 05/09/2020</small>
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
                            <p>Philippe Martin</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Date de naissance</h6>
                            <p>15/04/1975 (50 ans)</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Email</h6>
                            <p>philippe.martin@example.com</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Téléphone</h6>
                            <p>+33 6 12 34 56 78</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Genre</h6>
                            <p>Masculin</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">Statut</h6>
                            <p><span class="badge bg-success">Actif</span></p>
                        </div>
                        <div class="col-12 mb-3">
                            <h6 class="text-primary">Adresse</h6>
                            <p>123 Avenue des Sciences, 75001 Paris, France</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Qualifications -->
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Qualifications et expérience</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-primary">Diplômes et certifications</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Doctorat en Mathématiques, Université de Paris (2005)</li>
                            <li class="list-group-item">Master en Sciences Physiques, École Normale Supérieure (2000)</li>
                            <li class="list-group-item">Agrégation de Mathématiques (2002)</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-primary">Expérience</h6>
                        <p><i class="fas fa-briefcase me-2"></i> 15 ans d'expérience en enseignement</p>
                        <p><i class="fas fa-calendar-alt me-2"></i> Date d'embauche: 05/09/2020</p>
                    </div>
                    
                    <div>
                        <h6 class="text-primary">Documents</h6>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-file-pdf me-2 text-danger"></i> CV.pdf
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-file-pdf me-2 text-danger"></i> Diplome_Doctorat.pdf
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-file-pdf me-2 text-danger"></i> Attestation_Agregation.pdf
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Matières et emploi du temps -->
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Matières enseignées</h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-calendar-alt me-1"></i> Voir l'emploi du temps
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Niveau</th>
                                    <th>Classes</th>
                                    <th>Heures/Semaine</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mathématiques</td>
                                    <td>Terminale</td>
                                    <td>Term A, Term B</td>
                                    <td>8h</td>
                                </tr>
                                <tr>
                                    <td>Mathématiques</td>
                                    <td>Première</td>
                                    <td>1ère C</td>
                                    <td>4h</td>
                                </tr>
                                <tr>
                                    <td>Physique</td>
                                    <td>Seconde</td>
                                    <td>2nde D, 2nde E</td>
                                    <td>6h</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div>
                        <h6 class="text-primary">Notes</h6>
                        <p>Philippe est spécialisé dans la préparation aux concours et olympiades de mathématiques. Il anime également le club de sciences du lycée tous les mercredis après-midi.</p>
                    </div>
                    
                    <div class="mt-4">
                        <h6 class="text-primary">Statistiques</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card bg-primary text-white shadow">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <h5>120</h5>
                                            <div class="small">Élèves</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-success text-white shadow">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                                            <h5>18h</h5>
                                            <div class="small">Heures/semaine</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-info text-white shadow">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                                            <h5>5</h5>
                                            <div class="small">Classes</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection