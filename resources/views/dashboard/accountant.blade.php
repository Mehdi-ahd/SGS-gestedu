@extends('layouts.app')

@section('title', 'Tableau de bord comptable')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord comptable</h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm me-2">
                <i class="fas fa-file-invoice-dollar fa-sm me-1"></i> Nouvelle facture
            </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Générer un rapport
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Bonjour, M. Rousseau</div>
                            <div class="text-gray-600 mt-1">Vous avez <b>12 paiements</b> en attente à traiter et <b>5 factures</b> à générer cette semaine. Le budget du trimestre est actuellement exécuté à <b>68%</b>.</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total recettes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Recettes (Mois courant)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">112 500 FCFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-euro-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total dépenses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Dépenses (Mois courant)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">94 200 FCFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Taux de paiement -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Taux de paiement</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">92.8%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 92.8%"
                                            aria-valuenow="92.8" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements en attente -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Paiements en attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Graphique des revenus vs dépenses -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenus vs Dépenses (6 derniers mois)</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Options:</div>
                            <a class="dropdown-item" href="#">Vue annuelle</a>
                            <a class="dropdown-item" href="#">Vue trimestrielle</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Exporter en PDF</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="revenueExpenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Répartition des recettes -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Répartition des recettes</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Options:</div>
                            <a class="dropdown-item" href="#">Détails par catégorie</a>
                            <a class="dropdown-item" href="#">Changer de période</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Exporter en PDF</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="revenueSourcesChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Frais de scolarité
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Cantine
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Activités extrascolaires
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Transport
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Autres
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Paiements récents -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Paiements récents</h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-list"></i> Tout voir
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Élève</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P-2023052</td>
                                    <td>Dupont Thomas</td>
                                    <td>Frais de scolarité</td>
                                    <td>350 €</td>
                                    <td>20/05/2023</td>
                                    <td><span class="badge bg-success">Validé</span></td>
                                </tr>
                                <tr>
                                    <td>P-2023051</td>
                                    <td>Martin Lucas</td>
                                    <td>Cantine (Mai)</td>
                                    <td>120 €</td>
                                    <td>20/05/2023</td>
                                    <td><span class="badge bg-success">Validé</span></td>
                                </tr>
                                <tr>
                                    <td>P-2023050</td>
                                    <td>Bernard Emma</td>
                                    <td>Transport (Mai)</td>
                                    <td>85 €</td>
                                    <td>19/05/2023</td>
                                    <td><span class="badge bg-success">Validé</span></td>
                                </tr>
                                <tr>
                                    <td>P-2023049</td>
                                    <td>Petit Hugo</td>
                                    <td>Voyage scolaire</td>
                                    <td>250 €</td>
                                    <td>19/05/2023</td>
                                    <td><span class="badge bg-warning">En attente</span></td>
                                </tr>
                                <tr>
                                    <td>P-2023048</td>
                                    <td>Dubois Marie</td>
                                    <td>Frais de scolarité</td>
                                    <td>350 €</td>
                                    <td>18/05/2023</td>
                                    <td><span class="badge bg-success">Validé</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Factures à payer -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Factures à payer</h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Nouvelle facture
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Fournisseur</th>
                                    <th>Objet</th>
                                    <th>Montant</th>
                                    <th>Échéance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-danger">
                                    <td>F-2023012</td>
                                    <td>Électricité de France</td>
                                    <td>Facture électricité</td>
                                    <td>1 850 €</td>
                                    <td>25/05/2023</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="table-danger">
                                    <td>F-2023015</td>
                                    <td>Service des Eaux</td>
                                    <td>Facture eau</td>
                                    <td>780 €</td>
                                    <td>28/05/2023</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>F-2023018</td>
                                    <td>Fournitures Scolaires Pro</td>
                                    <td>Matériel pédagogique</td>
                                    <td>2 340 €</td>
                                    <td>05/06/2023</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>F-2023021</td>
                                    <td>Maintenance Informatique</td>
                                    <td>Maintenance mensuelle</td>
                                    <td>850 €</td>
                                    <td>10/06/2023</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>F-2023022</td>
                                    <td>Assurances Éducation</td>
                                    <td>Police d'assurance</td>
                                    <td>3 200 €</td>
                                    <td>15/06/2023</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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
        <!-- Suivi de budget -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Suivi budgétaire par département</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Administration <span class="float-end">74%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 74%" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Enseignement <span class="float-end">62%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Restauration <span class="float-end">68%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 68%" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Transport <span class="float-end">53%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 53%" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Activités extrascolaires <span class="float-end">42%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 42%" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Maintenance <span class="float-end">75%</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements en retard -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Paiements en retard</h6>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-envelope"></i> Relances
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Élève</th>
                                    <th>Parent</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Retard</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Moreau Lucas</td>
                                    <td>Moreau Jean</td>
                                    <td>Frais de scolarité</td>
                                    <td>350 €</td>
                                    <td><span class="badge bg-danger">15 jours</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="fas fa-bell"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Robert Emma</td>
                                    <td>Robert Paul</td>
                                    <td>Cantine (Avril)</td>
                                    <td>120 €</td>
                                    <td><span class="badge bg-danger">10 jours</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="fas fa-bell"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Simon Léa</td>
                                    <td>Simon Pierre</td>
                                    <td>Transport (Mai)</td>
                                    <td>85 €</td>
                                    <td><span class="badge bg-warning">5 jours</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="fas fa-bell"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Durand Maxime</td>
                                    <td>Durand Sophie</td>
                                    <td>Frais de scolarité</td>
                                    <td>350 €</td>
                                    <td><span class="badge bg-warning">3 jours</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="fas fa-bell"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                                    <div class="mb-2"><i class="fas fa-money-bill-wave fa-3x text-primary"></i></div>
                                    <a href="{{ route('payments.index') }}" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Paiements</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-file-invoice fa-3x text-success"></i></div>
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Factures</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-chart-pie fa-3x text-info"></i></div>
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Rapports</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-chart-line fa-3x text-warning"></i></div>
                                    <a href="#" class="stretched-link text-decoration-none">
                                        <h5 class="mb-0 font-weight-bold text-gray-800">Budget</h5>
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
    // Graphique Revenus vs Dépenses
    var ctx1 = document.getElementById('revenueExpenseChart').getContext('2d');
    var revenueExpenseChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Déc', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai'],
            datasets: [
                {
                    label: 'Revenus',
                    data: [105000, 110000, 108500, 115000, 110500, 112500],
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
                },
                {
                    label: 'Dépenses',
                    data: [90000, 92000, 88500, 95000, 96500, 94200],
                    backgroundColor: 'rgba(231, 74, 59, 0.05)',
                    borderColor: 'rgba(231, 74, 59, 1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(231, 74, 59, 1)',
                    pointBorderColor: 'rgba(231, 74, 59, 1)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgba(231, 74, 59, 1)',
                    pointHoverBorderColor: 'rgba(231, 74, 59, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' €';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString() + ' €';
                        }
                    }
                }
            }
        }
    });

    // Graphique Répartition des recettes
    var ctx2 = document.getElementById('revenueSourcesChart').getContext('2d');
    var revenueSourcesChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Frais de scolarité', 'Cantine', 'Activités extrascolaires', 'Transport', 'Autres'],
            datasets: [{
                data: [65, 15, 8, 10, 2],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)'
                ],
                hoverBackgroundColor: [
                    'rgba(78, 115, 223, 1)',
                    'rgba(28, 200, 138, 1)',
                    'rgba(54, 185, 204, 1)',
                    'rgba(246, 194, 62, 1)',
                    'rgba(231, 74, 59, 1)'
                ],
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection