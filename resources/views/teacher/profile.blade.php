@extends('layouts.teacher')

@section('title', 'Mon profil')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mon profil</h1>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->getFullName()) }}&background=4e73df&color=ffffff&size=120" 
                         alt="Profile Picture" 
                         class="rounded-circle mb-3" 
                         style="width: 120px; height: 120px;">
                    <h5 class="card-title">{{ Auth::user()->getFullName() }}</h5>
                    <p class="text-muted">Professeur</p>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <small class="text-muted">Email</small>
                            <div>{{ Auth::user()->email }}</div>
                        </div>
                        @if(Auth::user()->phone)
                        <div class="col-12 mb-2">
                            <small class="text-muted">Téléphone</small>
                            <div>{{ Auth::user()->phone }}</div>
                        </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-edit me-1"></i>Modifier le profil
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-key me-1"></i>Changer mot de passe
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card shadow mt-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Statistiques rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Classes enseignées</span>
                        <span class="badge bg-primary">{{ Auth::user()->teachings()->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Élèves total</span>
                        <span class="badge bg-success">{{ Auth::user()->teachings()->withCount('students')->get()->sum('students_count') ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Années d'expérience</span>
                        <span class="badge bg-info">{{ now()->year - (Auth::user()->created_at ? Auth::user()->created_at->year : now()->year) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Classes -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mes classes</h6>
                </div>
                <div class="card-body">
                    @if(Auth::user()->teachings()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Matière</th>
                                        <th>Niveau d'étude</th>
                                        <th>Groupe</th>
                                        <th>Nombre d'élèves</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Auth::user()->teachings()->with(['studyLevel', 'group', 'subject'])->get() as $teaching)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-book text-primary me-2"></i>
                                                <strong>{{ $teaching->subject->name ?? 'N/A' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $teaching->studyLevel->specification ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $teaching->group->id ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $teaching->students()->count() ?? 0 }} élèves</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-users"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-sm">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune classe assignée</h5>
                            <p class="text-muted">Vous n'avez pas encore de classes assignées. Contactez l'administration pour plus d'informations.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Activité récente</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-circle text-success" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Notes saisies</div>
                                <div class="text-muted small">Mathématiques - 6ème A</div>
                                <div class="text-muted small">Il y a 2 heures</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-circle text-warning" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Cours terminé</div>
                                <div class="text-muted small">Physique - 3ème B</div>
                                <div class="text-muted small">Il y a 1 jour</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-circle text-info" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Présences mises à jour</div>
                                <div class="text-muted small">Mathématiques - 5ème C</div>
                                <div class="text-muted small">Il y a 2 jours</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.timeline {
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e3e6f0;
}
</style>
@endsection
