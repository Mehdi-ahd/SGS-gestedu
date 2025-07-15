@extends('layouts.app')

@section('title', 'Tableau de bord élève')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord élève</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Exporter mes notes
        </a>
    </div>

    <!-- Bienvenue et résumé -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Bonjour, Thomas Dupont</div>
                            <div class="text-gray-600 mt-1">Vous avez <b>3 cours</b> aujourd'hui et <b>2 devoirs</b> à rendre cette semaine. Votre prochain cours est <b>Mathématiques</b> à <b>10h15</b> en <b>salle 204</b>.</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Moyenne générale -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Moyenne générale</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">14.5/20</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Devoirs à rendre -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Devoirs à rendre</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
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
                                Présence</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">97%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 97%"
                                            aria-valuenow="97" aria-valuemin="0" aria-valuemax="100"></div>
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

        <!-- Position dans la classe -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Position dans la classe</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5/28</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
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
                            <a class="dropdown-item" href="#">Exporter</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th>Horaire</th>
                                    <th>Matière</th>
                                    <th>Enseignant</th>
                                    <th>Salle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>08:30 - 10:00</td>
                                    <td>Histoire-Géographie</td>
                                    <td>Mme Dubois</td>
                                    <td>Salle 103</td>
                                </tr>
                                <tr class="table-primary">
                                    <td>10:15 - 11:45</td>
                                    <td>Mathématiques</td>
                                    <td>M. Martin</td>
                                    <td>Salle 204</td>
                                </tr>
                                <tr>
                                    <td>11:45 - 13:30</td>
                                    <td colspan="3" class="text-center">Pause déjeuner</td>
                                </tr>
                                <tr>
                                    <td>13:30 - 15:00</td>
                                    <td>Français</td>
                                    <td>Mme Petit</td>
                                    <td>Salle 105</td>
                                </tr>
                                <tr>
                                    <td>15:15 - 16:45</td>
                                    <td>Éducation physique</td>
                                    <td>M. Bernard</td>
                                    <td>Gymnase</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('schedules.index') }}" class="btn btn-sm btn-primary">Voir mon emploi du temps complet</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Devoirs à venir -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Devoirs à rendre</h6>
                </div>
                <div class="card-body">
                    <div class="assignment-item d-flex mb-3 pb-3 border-bottom">
                        <div class="assignment-date text-center me-3">
                            <div class="date-box bg-danger text-white px-3 py-2 rounded">
                                <div class="day fw-bold">23</div>
                                <div class="month small">Mai</div>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">Exercices d'équations</h6>
                            <p class="small text-muted mb-1">Mathématiques - M. Martin</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-danger">Demain</span>
                                <a href="#" class="btn btn-sm btn-outline-primary">Détails</a>
                            </div>
                        </div>
                    </div>
                    <div class="assignment-item d-flex mb-3 pb-3 border-bottom">
                        <div class="assignment-date text-center me-3">
                            <div class="date-box bg-warning text-white px-3 py-2 rounded">
                                <div class="day fw-bold">25</div>
                                <div class="month small">Mai</div>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">Dissertation Première Guerre mondiale</h6>
                            <p class="small text-muted mb-1">Histoire - Mme Dubois</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-warning">Dans 3 jours</span>
                                <a href="#" class="btn btn-sm btn-outline-primary">Détails</a>
                            </div>
                        </div>
                    </div>
                    <div class="assignment-item d-flex">
                        <div class="assignment-date text-center me-3">
                            <div class="date-box bg-info text-white px-3 py-2 rounded">
                                <div class="day fw-bold">30</div>
                                <div class="month small">Mai</div>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">Exposé sur Victor Hugo</h6>
                            <p class="small text-muted mb-1">Français - Mme Petit</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-info">Dans 8 jours</span>
                                <a href="#" class="btn btn-sm btn-outline-primary">Détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absences récentes -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Absences récentes</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="mb-1">Lundi 15 mai</h6>
                            <p class="small text-muted mb-0">Absence justifiée (rendez-vous médical)</p>
                        </div>
                        <span class="badge bg-success">Justifiée</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1">Jeudi 4 mai</h6>
                            <p class="small text-muted mb-0">Retard de 15 minutes (cours de français)</p>
                        </div>
                        <span class="badge bg-warning">Retard</span>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="#" class="btn btn-sm btn-primary">Voir toutes les absences</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Graphique des dernières notes -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mes dernières notes</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="gradesChart"></canvas>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a href="#" class="btn btn-sm btn-primary">Voir toutes mes notes</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des moyennes par matière -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Moyennes par matière</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Matière</th>
                                    <th>Moyenne</th>
                                    <th>Tendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mathématiques</td>
                                    <td>15.5/20</td>
                                    <td><i class="fas fa-arrow-up text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Français</td>
                                    <td>13.8/20</td>
                                    <td><i class="fas fa-arrow-right text-warning"></i></td>
                                </tr>
                                <tr>
                                    <td>Histoire-Géo</td>
                                    <td>16.2/20</td>
                                    <td><i class="fas fa-arrow-up text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Anglais</td>
                                    <td>12.5/20</td>
                                    <td><i class="fas fa-arrow-down text-danger"></i></td>
                                </tr>
                                <tr>
                                    <td>SVT</td>
                                    <td>14.0/20</td>
                                    <td><i class="fas fa-arrow-up text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Physique-Chimie</td>
                                    <td>15.7/20</td>
                                    <td><i class="fas fa-arrow-up text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Éducation physique</td>
                                    <td>17.0/20</td>
                                    <td><i class="fas fa-arrow-right text-warning"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Vie scolaire et événements -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Vie scolaire et événements</h6>
                </div>
                <div class="card-body">
                    <div class="event-item d-flex mb-3 pb-3 border-bottom">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-primary text-white px-3 py-2 rounded">
                                <div class="day fw-bold">28</div>
                                <div class="month small">Mai</div>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">Sortie scolaire au musée d'histoire</h6>
                            <p class="small text-muted mb-1">Organisé par Mme Dubois - Autorisation parentale requise</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Plus d'infos</a>
                        </div>
                    </div>
                    <div class="event-item d-flex mb-3 pb-3 border-bottom">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-success text-white px-3 py-2 rounded">
                                <div class="day fw-bold">02</div>
                                <div class="month small">Juin</div>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">Compétition interclasses de basket</h6>
                            <p class="small text-muted mb-1">Organisé par M. Bernard - Gymnase municipal</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Plus d'infos</a>
                        </div>
                    </div>
                    <div class="event-item d-flex">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-info text-white px-3 py-2 rounded">
                                <div class="day fw-bold">10</div>
                                <div class="month small">Juin</div>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1">Fête de fin d'année</h6>
                            <p class="small text-muted mb-1">Toute l'école - Cour principale</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Plus d'infos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CDI et ressources -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ressources et CDI</h6>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Mes livres empruntés</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Livre</th>
                                    <th>Date d'emprunt</th>
                                    <th>À rendre avant</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Les Misérables - Victor Hugo</td>
                                    <td>10/05/2023</td>
                                    <td>24/05/2023</td>
                                </tr>
                                <tr>
                                    <td>La Première Guerre mondiale - Collection Histoire</td>
                                    <td>15/05/2023</td>
                                    <td>29/05/2023</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mb-3">Ressources numériques</h5>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <a href="#" class="card bg-light text-decoration-none h-100">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-book fa-2x text-primary me-3"></i>
                                        <div>
                                            <h6 class="mb-0 text-dark">Bibliothèque numérique</h6>
                                            <p class="small text-muted mb-0">Plus de 5000 livres</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="#" class="card bg-light text-decoration-none h-100">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-video fa-2x text-danger me-3"></i>
                                        <div>
                                            <h6 class="mb-0 text-dark">Vidéothèque</h6>
                                            <p class="small text-muted mb-0">Cours et documentaires</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="#" class="card bg-light text-decoration-none h-100">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-puzzle-piece fa-2x text-success me-3"></i>
                                        <div>
                                            <h6 class="mb-0 text-dark">Exercices interactifs</h6>
                                            <p class="small text-muted mb-0">S'entraîner en ligne</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="#" class="card bg-light text-decoration-none h-100">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-globe fa-2x text-info me-3"></i>
                                        <div>
                                            <h6 class="mb-0 text-dark">Ressources langue</h6>
                                            <p class="small text-muted mb-0">Anglais, espagnol et allemand</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accès rapides -->
    <div class="row">
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
                                    <div class="mb-2"><i class="fas fa-book fa-3x text-primary"></i></div>
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Mes cours</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-calendar-alt fa-3x text-success"></i></div>
                                    <a href="{{ route('schedules.index') }}" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Emploi du temps</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-book-reader fa-3x text-info"></i></div>
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Médiathèque</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-user-cog fa-3x text-warning"></i></div>
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Mon compte</h5>
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
    // Graphique des dernières notes
    var ctx = document.getElementById('gradesChart').getContext('2d');
    var gradesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Contrôle Math 05/05', 
                'Dictée 08/05', 
                'Exposé Histoire 12/05', 
                'Interrogation Anglais 15/05', 
                'TP Physique 17/05', 
                'Devoir Maison 19/05'
            ],
            datasets: [{
                label: 'Notes sur 20',
                data: [16, 12.5, 17, 11, 14.5, 18],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)',
                    'rgba(133, 135, 150, 0.8)'
                ],
                borderColor: [
                    'rgba(78, 115, 223, 1)',
                    'rgba(28, 200, 138, 1)',
                    'rgba(54, 185, 204, 1)',
                    'rgba(246, 194, 62, 1)',
                    'rgba(231, 74, 59, 1)',
                    'rgba(133, 135, 150, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    min: 0,
                    max: 20,
                    ticks: {
                        stepSize: 2
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection