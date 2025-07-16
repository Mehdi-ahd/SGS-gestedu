
@extends('layouts.parent')

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
        <!-- Mes Enfants Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Mes enfants</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->students()->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-child fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Nouveaux messages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Paiements en attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Événements Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Événements à venir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Mes Enfants -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Mes enfants</h6>
                    <a href="{{ route('parent.showChildren', Auth::user()->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye me-1"></i>Voir tous
                    </a>
                </div>
                <div class="card-body">
                    @if(Auth::user()->students()->count() > 0)
                        <div class="row">
                            @foreach(Auth::user()->students()->get() as $child)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-primary h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="https://randomuser.me/api/portraits/kids/{{ $loop->index + 1 }}.jpg" 
                                                    alt="{{ $child->getFullName() }}" 
                                                    class="rounded-circle me-3" 
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <h6 class="card-title mb-1">{{ $child->getFullName() }}</h6>
                                                    <span class="badge bg-primary">{{ $child->classroom->name ?? 'Non assigné' }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Niveau
                                                    </div>
                                                    <div class="small font-weight-bold text-gray-800">{{ $child->studyLevel->name ?? 'N/A' }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Présence
                                                    </div>
                                                    <div class="small font-weight-bold text-success">95%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-child fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun enfant enregistré</p>
                            <a href="#" class="btn btn-primary">Inscrire un enfant</a>
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
                        <a href="{{ route('parent.showChildren', Auth::user()->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-child text-primary me-3"></i>
                            <span>Voir mes enfants</span>
                        </a>
                        <a href="{{ route('payments.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-credit-card text-success me-3"></i>
                            <span>Mes paiements</span>
                        </a>
                        <a href="{{ route('schedules.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-info me-3"></i>
                            <span>Emplois du temps</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-file-alt text-warning me-3"></i>
                            <span>Bulletins scolaires</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-envelope text-secondary me-3"></i>
                            <span>Messages</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notifications récentes -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notifications récentes</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="me-3">
                                <i class="fas fa-circle text-success" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Nouvelle note disponible</div>
                                <div class="text-muted">Thomas - Mathématiques</div>
                                <div class="text-muted small">Il y a 2 heures</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="me-3">
                                <i class="fas fa-circle text-warning" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Réunion parents-professeurs</div>
                                <div class="text-muted">Vendredi 15 décembre</div>
                                <div class="text-muted small">Il y a 1 jour</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-circle text-info" style="font-size: 0.5rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold">Paiement traité</div>
                                <div class="text-muted">Frais de scolarité - Décembre</div>
                                <div class="text-muted small">Il y a 3 jours</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-sm btn-outline-primary">Voir toutes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Événements à venir -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Événements à venir</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <div class="card border-left-success h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="bg-success text-white rounded text-center p-2">
                                                <div class="font-weight-bold">15</div>
                                                <div class="small">DÉC</div>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Réunion parents-professeurs</h6>
                                            <p class="small text-muted mb-0">18h00 - Salle de conférence</p>
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
                                            <div class="bg-warning text-white rounded text-center p-2">
                                                <div class="font-weight-bold">20</div>
                                                <div class="small">DÉC</div>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Vacances de Noël</h6>
                                            <p class="small text-muted mb-0">Début des vacances scolaires</p>
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
                                            <div class="bg-info text-white rounded text-center p-2">
                                                <div class="font-weight-bold">08</div>
                                                <div class="small">JAN</div>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Rentrée scolaire</h6>
                                            <p class="small text-muted mb-0">Reprise des cours</p>
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
