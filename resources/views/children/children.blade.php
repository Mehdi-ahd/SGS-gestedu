@extends('layouts.parent')

@section('title', 'Mes enfants')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="h3 mb-2 mb-md-0 text-gray-800">
            <i class="fas fa-child me-2"></i>
            Mes enfants
        </h1>
        
        <div class="d-flex gap-2">
            <a href="{{ route('parent.student-registration') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Inscrire un enfant
            </a>
            <a href="{{ route('parent.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Enfants inscrits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $children->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Inscriptions actives</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeEnrollments ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingEnrollments ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Année scolaire</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ date('Y') }}-{{ date('Y')+1 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Children Cards -->
    @if($children->isEmpty())
        <div class="text-center py-5">
            <div class="card shadow">
                <div class="card-body py-5">
                    <i class="fas fa-child fa-5x text-gray-300 mb-4"></i>
                    <h4 class="text-gray-600 mb-3">Aucun enfant inscrit</h4>
                    <p class="text-gray-500 mb-4">Vous n'avez pas encore d'enfant inscrit dans notre établissement.</p>
                    <a href="{{ route('parent.student-registration') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Inscrire mon premier enfant
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($children as $child)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <!-- Photo et informations principales -->
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $child->photo ? asset('storage/' . $child->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($child->firstname . ' ' . $child->lastname) . '&background=2563eb&color=fff' }}" 
                                     alt="Photo de {{ $child->firstname }}" 
                                     class="rounded-circle me-3" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1">{{ $child->firstname }} {{ $child->lastname }}</h5>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-birthday-cake me-1"></i>
                                        {{ \Carbon\Carbon::parse($child->birthday)->format('d/m/Y') }}
                                        ({{ \Carbon\Carbon::parse($child->birthday)->age }} ans)
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Informations académiques -->
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <div class="border-end">
                                        <div class="h6 mb-0 text-primary">{{ $child->latestInscription()->study_level->specification ?? 'N/A' }}</div>
                                        <small class="text-muted">Niveau</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="h6 mb-0 text-success">{{ $child->latestInscription()->group->id ?? 'N/A' }}</div>
                                    <small class="text-muted">Groupe</small>
                                </div>
                            </div>
                            
                            <!-- Statut -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Statut:</span>
                                @if($child->status === 'active')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Actif
                                    </span>
                                @elseif($child->status === 'pending')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-hourglass-half me-1"></i>
                                        En attente
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-pause-circle me-1"></i>
                                        Inactif
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Informations supplémentaires -->
                            <div class="small text-muted mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Derniere Inscription:</span>
                                    <span>{{ $child->latestInscription()->study_level->specification }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Année scolaire:</span>
                                    <span>{{ $child->latestInscription()->school_year_id }}</span>
                                </div>
                                @if($child->email)
                                <div class="d-flex justify-content-between">
                                    <span>Email:</span>
                                    <span>{{ $child->email ?? "Indisponible"}}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('parent.child.details', $child->id)}}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>
                                    Détails
                                </a>
                                <a href="" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-star me-1"></i>
                                    Notes
                                </a>
                                <a href="" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-calendar me-1"></i>
                                    Emploi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        {{-- @if($children->hasPages())
            <div class="d-flex justify-content-center">
                {{ $children->links() }}
            </div>
        @endif --}}
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation d'entrée des cartes
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Effet hover sur les cartes
        const childCards = document.querySelectorAll('.col-lg-6 .card');
        childCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 1rem 3rem rgba(0,0,0,.175)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
    });
</script>
@endsection
