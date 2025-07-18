@extends('layouts.parent')

@section('title', 'Détails de ' . $child->firstname)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h1 class="h3 mb-2 mb-md-0 text-gray-800">
                <i class="fas fa-user me-2"></i>
                {{ $child->getFullName() }}
            </h1>
            <p class="text-muted mb-0">Détails de l'élève</p>
        </div>
        
        <div class="d-flex flex-column flex-sm-row gap-2">
            <a href="" class="btn btn-info">
                <i class="fas fa-graduation-cap me-2"></i>
                Détails académiques
            </a>
            <a href="{{ route('parent.showChildren', Auth()->user()->id)}}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informations générales -->
        <div class="col-lg-8">
            <!-- Informations personnelles -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-2"></i>
                        Informations personnelles
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nom complet</label>
                            <p class="h6">{{ $child->getFullName() }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Date de naissance</label>
                            <p class="h6">{{ \Carbon\Carbon::parse($child->birthday)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($child->birthday)->age }} ans)</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Sexe</label>
                            <p class="h6">{{ $child->sex == 'M' ? 'Masculin' : 'Féminin' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Email</label>
                            <p class="h6">{{ $child->email ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Téléphone</label>
                            <p class="h6">{{ $child->phone ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Date d'inscription</label>
                            <p class="h6">{{ \Carbon\Carbon::parse($child->registration_date)->format('d/m/Y') }}</p>
                        </div>
                        @if($child->home_address)
                        <div class="col-12">
                            <label class="form-label text-muted">Adresse</label>
                            <p class="h6">{{ $child->home_address }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cursus scolaire -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Cursus scolaire
                    </h6>
                </div>
                <div class="card-body">
                    @if($child->inscriptions && $child->inscriptions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Année scolaire</th>
                                        <th>Niveau d'étude</th>
                                        <th class="d-none d-md-table-cell">Moyenne</th>
                                        <th class="d-none d-md-table-cell">Verdict</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($child->inscriptions as $inscription)
                                    <tr>
                                        <td>
                                            <strong>{{ $inscription->school_year_id }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $inscription->study_level->specification ?? 'N/A' }}</span>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            @if($inscription->final_average)
                                                <span class="badge {{ $inscription->final_average >= 10 ? 'bg-success' : 'bg-warning' }}">
                                                    {{ number_format($inscription->final_average, 2) }}/20
                                                </span>
                                            @else
                                                <span class="text-muted">En cours</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            @if($inscription->verdict)
                                                @if($inscription->verdict == 'passe')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Admis
                                                    </span>
                                                @elseif($inscription->verdict == 'redouble')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-redo me-1"></i>Redouble
                                                    </span>
                                                @elseif($inscription->verdict == 'exclu')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times me-1"></i>Exclu
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-muted">En cours</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('parent.child.academic-year-details', ['id' => $child->id, 'year_id' => $inscription->school_year_id]) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i>
                                                <span class="d-none d-sm-inline">Voir plus</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-graduation-cap fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-600">Aucun cursus disponible</h5>
                            <p class="text-muted">Les informations de cursus apparaîtront ici une fois disponibles.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Photo et statut -->
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img src="{{ $child->photo ? asset('storage/' . $child->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($child->firstname . ' ' . $child->lastname) . '&background=2563eb&color=fff' }}" 
                         alt="Photo de {{ $child->firstname }}" 
                         class="rounded-circle border border-3 border-primary mb-3" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                    
                    <h5 class="card-title">{{ $child->firstname }} {{ $child->lastname }}</h5>
                    
                    @if($child->status === 'active')
                        <span class="badge bg-success mb-3">
                            <i class="fas fa-check-circle me-1"></i>
                            Élève actif
                        </span>
                    @elseif($child->status === 'pending')
                        <span class="badge bg-warning mb-3">
                            <i class="fas fa-hourglass-half me-1"></i>
                            En attente
                        </span>
                    @else
                        <span class="badge bg-secondary mb-3">
                            <i class="fas fa-pause-circle me-1"></i>
                            Inactif
                        </span>
                    @endif
                </div>
            </div>

            <!-- Informations académiques actuelles -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Année en cours</h6>
                </div>
                <div class="card-body">
                    @if($child->latestInscription())
                        <div class="mb-3">
                            <small class="text-muted">Niveau d'étude</small>
                            <p class="h6 mb-0">{{ $child->latestInscription()->study_level->specification ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Classe/Groupe</small>
                            <p class="h6 mb-0">{{ $child->latestInscription()->group->id ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Année scolaire</small>
                            <p class="h6 mb-0">{{ $child->latestInscription()->school_year_id }}</p>
                        </div>
                        @if($child->latestInscription()->current_average)
                        <div class="mb-0">
                            <small class="text-muted">Moyenne actuelle</small>
                            <p class="h6 mb-0">
                                <span class="badge {{ $child->latestInscription()->current_average >= 10 ? 'bg-success' : 'bg-warning' }}">
                                    {{ number_format($child->latestInscription()->current_average, 2) }}/20
                                </span>
                            </p>
                        </div>
                        @endif
                    @else
                        <p class="text-muted text-center">Aucune inscription active</p>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-star me-2"></i>
                            Voir les notes
                        </a>
                        <a href="" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Emploi du temps
                        </a>
                        <a href="" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-credit-card me-2"></i>
                            Paiements
                        </a>
                        <a href="" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-file-alt me-2"></i>
                            Bulletins
                        </a>
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
        // Animation des cartes
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
    });
</script>
@endsection
