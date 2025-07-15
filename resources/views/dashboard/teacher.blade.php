@extends('layouts.app')

@section('title', 'Tableau de bord enseignant')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord enseignant</h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm me-2">
                <i class="fas fa-calendar-plus fa-sm me-1"></i> Ajouter un événement
            </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Exporter mes données
            </a>
        </div>
    </div>

    <!-- Bienvenue et résumé -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Bonjour, Philippe Martin</div>
                            <div class="text-gray-600 mt-1">Vous avez <b>3 cours</b> aujourd'hui et <b>2 devoirs</b> à corriger cette semaine. Votre prochain cours est à <b>10h15</b> avec la classe <b>3ème A</b> en <b>salle 204</b>.</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Élèves sous ma responsabilité -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Élèves</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">120</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes enseignées -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Classes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Heures de cours par semaine -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Heures/semaine</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18h</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Moyenne de classe -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Moyenne de mes classes</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">13.5/20</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 67.5%"
                                            aria-valuenow="13.5" aria-valuemin="0" aria-valuemax="20"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Emploi du temps du jour -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Emploi du temps - Aujourd'hui</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Options:</div>
                            <a class="dropdown-item" href="#">Vue semaine</a>
                            <a class="dropdown-item" href="#">Vue mois</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Imprimer</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th>Horaire</th>
                                    <th>Classe</th>
                                    <th>Salle</th>
                                    <th>Matière</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>08:30 - 10:00</td>
                                    <td>4ème B</td>
                                    <td>Salle 103</td>
                                    <td>Mathématiques</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Faire l'appel">
                                            <i class="fas fa-clipboard-list"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Voir la classe">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <td>10:15 - 11:45</td>
                                    <td>3ème A</td>
                                    <td>Salle 204</td>
                                    <td>Physique</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Faire l'appel">
                                            <i class="fas fa-clipboard-list"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Voir la classe">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>13:30 - 15:00</td>
                                    <td>Terminale A</td>
                                    <td>Labo 2</td>
                                    <td>Mathématiques</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Faire l'appel">
                                            <i class="fas fa-clipboard-list"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Voir la classe">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>15:15 - 16:45</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>Libre</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-sm btn-primary">Voir l'emploi du temps complet</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des devoirs à corriger -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Devoirs à corriger</h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Contrôle de Mathématiques</h6>
                                <small class="text-danger">Échéance: Demain</small>
                            </div>
                            <p class="mb-1">Classe: 3ème A</p>
                            <small class="text-muted">25 copies à corriger</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Exercices d'équations</h6>
                                <small class="text-warning">Échéance: Dans 3 jours</small>
                            </div>
                            <p class="mb-1">Classe: 4ème B</p>
                            <small class="text-muted">28 copies à corriger</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Problèmes de physique</h6>
                                <small>Échéance: Dans 5 jours</small>
                            </div>
                            <p class="mb-1">Classe: Terminale A</p>
                            <small class="text-muted">22 copies à corriger</small>
                        </a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-sm btn-primary">Voir tous les devoirs</a>
                    </div>
                </div>
            </div>

            <!-- Rappels -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Rappels importants</h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-1">Réunion des enseignants</h6>
                            <p class="small text-muted mb-0">23 Mai, 16h00 - Salle des profs</p>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="reminder1">
                            <label class="custom-control-label" for="reminder1"></label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-1">Rendre les notes trimestrielles</h6>
                            <p class="small text-muted mb-0">25 Mai - Secrétariat</p>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="reminder2">
                            <label class="custom-control-label" for="reminder2"></label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1">Conseil de classe - 3ème A</h6>
                            <p class="small text-muted mb-0">30 Mai, 17h30 - Salle du conseil</p>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="reminder3">
                            <label class="custom-control-label" for="reminder3"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Graphique des résultats -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Résultats par classe</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="resultsChart"></canvas>
                    </div>
                    <hr>
                    <div class="text-center small">
                        <span class="me-2">
                            <i class="fas fa-circle text-primary"></i> 3ème A
                        </span>
                        <span class="me-2">
                            <i class="fas fa-circle text-success"></i> 4ème B
                        </span>
                        <span class="me-2">
                            <i class="fas fa-circle text-info"></i> 5ème C
                        </span>
                        <span class="me-2">
                            <i class="fas fa-circle text-warning"></i> Terminale A
                        </span>
                        <span class="me-2">
                            <i class="fas fa-circle text-danger"></i> Terminale B
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages récents -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Messages récents</h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-envelope"></i> Nouveau message
                    </a>
                </div>
                <div class="card-body">
                    <div class="message-item d-flex mb-3 pb-3 border-bottom">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas Dubois" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0">Thomas Dubois <span class="badge bg-secondary ms-2">Parent</span></h6>
                                <small class="text-muted">Hier, 16:43</small>
                            </div>
                            <p class="mb-0">Bonjour M. Martin, je souhaiterais un rendez-vous concernant les résultats de mon fils en mathématiques...</p>
                        </div>
                    </div>
                    <div class="message-item d-flex mb-3 pb-3 border-bottom">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Marie Laurent" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0">Marie Laurent <span class="badge bg-info ms-2">Direction</span></h6>
                                <small class="text-muted">19/05, 09:15</small>
                            </div>
                            <p class="mb-0">Confirmation de la réunion pédagogique du 23 mai. Votre présence est requise...</p>
                        </div>
                    </div>
                    <div class="message-item d-flex">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Paul Bernard" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0">Paul Bernard <span class="badge bg-primary ms-2">Collègue</span></h6>
                                <small class="text-muted">18/05, 14:22</small>
                            </div>
                            <p class="mb-0">Peux-tu me passer tes fiches sur les équations du second degré ? Merci d'avance...</p>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-sm btn-primary">Voir tous les messages</a>
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
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Mes classes</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-book fa-3x text-success"></i></div>
                                    <a href="{{ route('attendance.create') }}" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Faire l'appel</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-edit fa-3x text-info"></i></div>
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Saisir des notes</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-file-alt fa-3x text-warning"></i></div>
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Ressources pédagogiques</h5>
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
    // Graphique des résultats par classe
    var ctx = document.getElementById('resultsChart').getContext('2d');
    var resultsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Moins de 8', '8 à 10', '10 à 12', '12 à 14', '14 à 16', '16 à 18', '18 à 20'],
            datasets: [
                {
                    label: '3ème A',
                    backgroundColor: 'rgba(78, 115, 223, 0.8)',
                    data: [2, 3, 5, 8, 6, 3, 1]
                },
                {
                    label: '4ème B',
                    backgroundColor: 'rgba(28, 200, 138, 0.8)',
                    data: [1, 4, 6, 10, 5, 2, 0]
                },
                {
                    label: 'Terminale A',
                    backgroundColor: 'rgba(246, 194, 62, 0.8)',
                    data: [0, 2, 4, 7, 8, 5, 2]
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre d\'élèves'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Fourchette de notes'
                    }
                }
            }
        }
    });

    // Activer les tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endsection