@extends('layouts.app')

@section('title', 'Tableau de bord administrateur')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord administrateur</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Générer un rapport
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Élèves Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Élèves inscrits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">1,285</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Professeurs Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Enseignants</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">68</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Classes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Classes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-school fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Présence Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Taux de présence</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">94.2%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 94.2%"
                                            aria-valuenow="94.2" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart - Inscriptions -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Inscriptions par mois</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Options:</div>
                            <a class="dropdown-item" href="#">Exporter les données</a>
                            <a class="dropdown-item" href="#">Modifier les filtres</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Voir les détails</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="inscriptionsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart - Répartition des élèves -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Répartition par niveau</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Options:</div>
                            <a class="dropdown-item" href="#">Exporter les données</a>
                            <a class="dropdown-item" href="#">Changer de visualisation</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Voir les détails</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="repartitionChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Sixième
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Cinquième
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Quatrième
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Troisième
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Seconde
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-secondary"></i> Première
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-dark"></i> Terminale
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Dernières inscriptions -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dernières inscriptions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Élève</th>
                                    <th>Classe</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Martin Lucas</td>
                                    <td>4ème C</td>
                                    <td>12/05/2023</td>
                                    <td><a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Dubois Emma</td>
                                    <td>6ème A</td>
                                    <td>10/05/2023</td>
                                    <td><a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Petit Hugo</td>
                                    <td>2nde B</td>
                                    <td>08/05/2023</td>
                                    <td><a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Bernard Thomas</td>
                                    <td>5ème D</td>
                                    <td>05/05/2023</td>
                                    <td><a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Robert Léa</td>
                                    <td>1ère S</td>
                                    <td>03/05/2023</td>
                                    <td><a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-sm btn-primary">Voir toutes les inscriptions</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Événements à venir -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Événements à venir</h6>
                </div>
                <div class="card-body">
                    <div class="event-item d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-primary text-white px-3 py-2 rounded">
                                <div class="day fw-bold">25</div>
                                <div class="month small">Mai</div>
                            </div>
                        </div>
                        <div class="event-content">
                            <h6 class="mb-1">Conseil de classe - Terminale A</h6>
                            <p class="small text-muted mb-1"><i class="fas fa-clock me-1"></i> 14:00 - 16:00 | <i class="fas fa-map-marker-alt me-1"></i> Salle de conférence</p>
                            <p class="mb-0">Réunion pour évaluer les résultats scolaires des élèves de Terminale A.</p>
                        </div>
                    </div>
                    <div class="event-item d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-info text-white px-3 py-2 rounded">
                                <div class="day fw-bold">28</div>
                                <div class="month small">Mai</div>
                            </div>
                        </div>
                        <div class="event-content">
                            <h6 class="mb-1">Journée portes ouvertes</h6>
                            <p class="small text-muted mb-1"><i class="fas fa-clock me-1"></i> 09:00 - 17:00 | <i class="fas fa-map-marker-alt me-1"></i> Tout l'établissement</p>
                            <p class="mb-0">Accueil des futurs élèves et leurs parents pour présenter l'établissement.</p>
                        </div>
                    </div>
                    <div class="event-item d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-success text-white px-3 py-2 rounded">
                                <div class="day fw-bold">02</div>
                                <div class="month small">Juin</div>
                            </div>
                        </div>
                        <div class="event-content">
                            <h6 class="mb-1">Réunion du personnel</h6>
                            <p class="small text-muted mb-1"><i class="fas fa-clock me-1"></i> 10:00 - 12:00 | <i class="fas fa-map-marker-alt me-1"></i> Amphithéâtre</p>
                            <p class="mb-0">Réunion de fin d'année avec tous les enseignants et le personnel administratif.</p>
                        </div>
                    </div>
                    <div class="event-item d-flex align-items-start">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-warning text-white px-3 py-2 rounded">
                                <div class="day fw-bold">10</div>
                                <div class="month small">Juin</div>
                            </div>
                        </div>
                        <div class="event-content">
                            <h6 class="mb-1">Cérémonie de remise des diplômes</h6>
                            <p class="small text-muted mb-1"><i class="fas fa-clock me-1"></i> 15:00 - 18:00 | <i class="fas fa-map-marker-alt me-1"></i> Grand auditorium</p>
                            <p class="mb-0">Cérémonie officielle pour les élèves de Terminale.</p>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-sm btn-primary">Voir tous les événements</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Accès rapides -->
        <div class="col-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Accès rapides</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-user-graduate fa-3x text-primary"></i></div>
                                    <a href="{{ route('students.index') }}" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Gestion des élèves</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-chalkboard-teacher fa-3x text-success"></i></div>
                                    <a href="{{ route('teachers.index') }}" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Gestion des enseignants</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-users fa-3x text-info"></i></div>
                                    <a href="{{ route('parents.index') }}" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Gestion des parents</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-calendar-alt fa-3x text-warning"></i></div>
                                    <a href="{{ route('schedules.index') }}" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Emplois du temps</h5>
                                    </a>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des inscriptions
    var ctx1 = document.getElementById('inscriptionsChart').getContext('2d');
    var inscriptionsChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Sept', 'Oct', 'Nov', 'Déc', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            datasets: [{
                label: 'Nouvelles inscriptions',
                data: [45, 28, 15, 12, 56, 23, 18, 12, 30, 22],
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(78, 115, 223, 1)',
                pointHoverRadius: 5,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique de répartition des élèves
    var ctx2 = document.getElementById('repartitionChart').getContext('2d');
    var repartitionChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Sixième', 'Cinquième', 'Quatrième', 'Troisième', 'Seconde', 'Première', 'Terminale'],
            datasets: [{
                data: [185, 190, 175, 180, 190, 185, 180],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)',
                    'rgba(133, 135, 150, 0.8)',
                    'rgba(90, 92, 105, 0.8)'
                ],
                hoverBackgroundColor: [
                    'rgba(78, 115, 223, 1)',
                    'rgba(28, 200, 138, 1)',
                    'rgba(54, 185, 204, 1)',
                    'rgba(246, 194, 62, 1)',
                    'rgba(231, 74, 59, 1)',
                    'rgba(133, 135, 150, 1)',
                    'rgba(90, 92, 105, 1)'
                ],
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%',
            maintainAspectRatio: false
        }
    });
</script>
@endsection