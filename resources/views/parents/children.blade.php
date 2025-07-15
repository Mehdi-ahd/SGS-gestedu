@extends('layouts.app')

@section('title', 'Tableau de bord parent')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord parent</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Télécharger les bulletins
        </a>
    </div>

    <!-- Content Row - Résumé des enfants -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Mes enfants</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Options:</div>
                            <a class="dropdown-item" href="#">Voir tous les détails</a>
                            <a class="dropdown-item" href="#">Exporter les données</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Paramètres de notification</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ( $children as $child )
                            <div class="col-xl-6 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="https://randomuser.me/api/portraits/kids/1.jpg" alt="Thomas Dupont" class="rounded-circle mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h5 class="card-title mb-0">{{ $child->lastname }}</h5>
                                                <div class="text-muted">{{ $child->inscription->school_year }}</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-2">
                                                <div class="card bg-light">
                                                    <div class="card-body py-2 px-3">
                                                        <div class="small text-uppercase font-weight-bold text-primary">Moyenne générale</div>
                                                        <div class="h5 mb-0">14.5/20</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="card bg-light">
                                                    <div class="card-body py-2 px-3">
                                                        <div class="small text-uppercase font-weight-bold text-primary">Assiduité</div>
                                                        <div class="h5 mb-0">97%</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="card bg-light">
                                                    <div class="card-body py-2 px-3">
                                                        <div class="small text-uppercase font-weight-bold text-primary">Comportement</div>
                                                        <div class="h5 mb-0">Très bien</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="card bg-light">
                                                    <div class="card-body py-2 px-3">
                                                        <div class="small text-uppercase font-weight-bold text-primary">Devoirs à venir</div>
                                                        <div class="h5 mb-0">2</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <a href="#" class="btn btn-sm btn-primary me-2">
                                                <i class="fas fa-book me-1"></i> Notes
                                            </a>
                                            <a href="#" class="btn btn-sm btn-info me-2">
                                                <i class="fas fa-calendar-alt me-1"></i> Emploi du temps
                                            </a>
                                            <a href="#" class="btn btn-sm btn-success">
                                                <i class="fas fa-comments me-1"></i> Contacter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                <div class="d-flex align-item-center">
                                    Vous n'avez pas d'enfants inscrits
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique d'évolution des moyennes
    var ctx = document.getElementById('gradesChart').getContext('2d');
    var gradesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sept', 'Oct', 'Nov', 'Déc', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai'],
            datasets: [
                {
                    label: 'Thomas - Moyenne générale',
                    data: [13.5, 13.8, 14.0, 13.5, 14.2, 14.4, 14.3, 14.5, 14.5],
                    borderColor: 'rgba(78, 115, 223, 1)',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 5,
                    lineTension: 0.3,
                    fill: true
                },
                {
                    label: 'Julie - Moyenne générale',
                    data: [15.2, 15.5, 15.7, 15.8, 16.0, 16.2, 16.1, 16.3, 16.2],
                    borderColor: 'rgba(28, 200, 138, 1)',
                    backgroundColor: 'rgba(28, 200, 138, 0.1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(28, 200, 138, 1)',
                    pointBorderColor: 'rgba(28, 200, 138, 1)',
                    pointHoverRadius: 5,
                    lineTension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    min: 10,
                    max: 20,
                    ticks: {
                        stepSize: 2
                    },
                    title: {
                        display: true,
                        text: 'Moyenne sur 20'
                    }
                }
            }
        }
    });
</script>
@endsection