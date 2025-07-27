
@extends('layouts.teacher')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bienvenue, {{ Auth::user()->getFullName() }}</h1>
        <div class="d-none d-sm-inline-block">
            <small class="text-muted">Dernière connexion : {{ now()->format('d/m/Y à H:i') }}</small>
        </div>
    </div>

    <!-- Content Row - Quick Stats -->
    <div class="row">
        <!-- Mes Classes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Mes classes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->teachings()->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Élèves Total Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total élèves</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->teachings()->withCount('students')->get()->sum('students_count') ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cours cette semaine Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Cours cette semaine</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes à saisir Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Notes à saisir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Mes Classes -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Mes classes enseignées</h6>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye me-1"></i>Voir toutes
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $teachings = Auth::user()->teachings()->with(['studyLevel', 'group', 'subject'])->take(4)->get();
                    @endphp
                    @if($teachings->count() > 0)
                        <div class="row">
                            @foreach($teachings as $teaching)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-primary h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="me-3">
                                                    <i class="fas fa-book fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="card-title mb-1">{{ $teaching->subject->name ?? 'N/A' }}</h6>
                                                    <span class="badge bg-primary">{{ $teaching->studyLevel->specification ?? 'N/A' }} - {{ $teaching->group->id ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Niveau
                                                    </div>
                                                    <div class="small font-weight-bold text-gray-800">{{ $teaching->studyLevel->specification ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Groupe
                                                    </div>
                                                    <div class="small font-weight-bold text-success">{{ $teaching->group->id ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucune classe assignée</p>
                            <a href="#" class="btn btn-primary">Voir l'emploi du temps</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Accès rapides -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Accès rapides</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-chalkboard-teacher text-primary me-3"></i>
                            <span>Mes classes</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-success me-3"></i>
                            <span>Emploi du temps</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-star text-info me-3"></i>
                            <span>Saisir les notes</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-user-check text-warning me-3"></i>
                            <span>Gérer les présences</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-envelope text-secondary me-3"></i>
                            <span>Messages</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Emploi du temps aujourd'hui -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Emploi du temps aujourd'hui</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="me-3">
                                <div class="bg-primary text-white rounded text-center p-2" style="min-width: 50px;">
                                    <div class="font-weight-bold small">08:00</div>
                                </div>
                            </div>
                            <div>
                                <div class="font-weight-bold">Mathématiques</div>
                                <div class="text-muted">6ème A - Salle 101</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="me-3">
                                <div class="bg-success text-white rounded text-center p-2" style="min-width: 50px;">
                                    <div class="font-weight-bold small">10:00</div>
                                </div>
                            </div>
                            <div>
                                <div class="font-weight-bold">Physique</div>
                                <div class="text-muted">3ème B - Labo</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-info text-white rounded text-center p-2" style="min-width: 50px;">
                                    <div class="font-weight-bold small">14:00</div>
                                </div>
                            </div>
                            <div>
                                <div class="font-weight-bold">Mathématiques</div>
                                <div class="text-muted">5ème C - Salle 203</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-sm btn-outline-primary">Voir emploi complet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Statistiques de la semaine -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Activités de la semaine</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <div class="card border-left-success h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-check-circle fa-2x text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Cours terminés</h6>
                                            <p class="small text-muted mb-0">8 cours cette semaine</p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar bg-success" style="width: 67%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 mb-3">
                            <div class="card border-left-warning h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-users fa-2x text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Présence moyenne</h6>
                                            <p class="small text-muted mb-0">92% de présence</p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar bg-warning" style="width: 92%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 mb-3">
                            <div class="card border-left-info h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-star fa-2x text-info"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Notes saisies</h6>
                                            <p class="small text-muted mb-0">15 évaluations cette semaine</p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar bg-info" style="width: 75%"></div>
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
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes statistiques
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
        card.classList.add('fade-in');
    });
});
</script>

@section('styles')
<style>
.fade-in {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
</style>
@endsection
@endsection
