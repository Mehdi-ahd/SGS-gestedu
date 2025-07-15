@extends('layouts.parent')

@section('title', 'Tableau de bord parent')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord parent</h1>
        <div class="d-none d-sm-inline-block">
            <span class="text-muted">{{ date('d/m/Y') }}</span>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Mes enfants Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Mes enfants</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-child fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages non lus Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Messages non lus</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiements en attente Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Paiements en attente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">1</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prochains événements Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Prochains événements</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">4</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Mes enfants - Vue détaillée -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Mes enfants</h6>
                    <a href="{{ route('parent.showChildren', Auth::user()->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye me-1"></i>Voir tous
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Classe</th>
                                    <th>Moyenne</th>
                                    <th>Dernière note</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                            <div>
                                                <div class="font-weight-bold">Thomas Martin</div>
                                                <div class="small text-muted">Né le 15/03/2010</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>6ème A</td>
                                    <td><span class="badge bg-success">14.2/20</span></td>
                                    <td>Mathématiques - 16/20</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-chart-line"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profile" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                            <div>
                                                <div class="font-weight-bold">Emma Martin</div>
                                                <div class="small text-muted">Née le 22/08/2012</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>4ème B</td>
                                    <td><span class="badge bg-warning">12.8/20</span></td>
                                    <td>Français - 15/20</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-chart-line"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://randomuser.me/api/portraits/men/68.jpg" alt="Profile" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                            <div>
                                                <div class="font-weight-bold">Lucas Martin</div>
                                                <div class="small text-muted">Né le 10/11/2008</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>2nde C</td>
                                    <td><span class="badge bg-success">15.6/20</span></td>
                                    <td>Physique - 17/20</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-chart-line"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Événements et notifications -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Événements à venir</h6>
                </div>
                <div class="card-body">
                    <div class="event-item d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-primary text-white px-2 py-1 rounded">
                                <div class="day fw-bold">28</div>
                                <div class="month small">Mai</div>
                            </div>
                        </div>
                        <div class="event-content">
                            <h6 class="mb-1">Réunion parents-professeurs</h6>
                            <p class="small text-muted mb-1"><i class="fas fa-clock me-1"></i> 18:00 - 20:00</p>
                            <p class="mb-0">Classe de Thomas (6ème A)</p>
                        </div>
                    </div>
                    <div class="event-item d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-success text-white px-2 py-1 rounded">
                                <div class="day fw-bold">02</div>
                                <div class="month small">Juin</div>
                            </div>
                        </div>
                        <div class="event-content">
                            <h6 class="mb-1">Sortie scolaire</h6>
                            <p class="small text-muted mb-1"><i class="fas fa-clock me-1"></i> 08:00 - 17:00</p>
                            <p class="mb-0">Musée des Sciences (Emma - 4ème B)</p>
                        </div>
                    </div>
                    <div class="event-item d-flex align-items-start">
                        <div class="event-date text-center me-3">
                            <div class="date-box bg-warning text-white px-2 py-1 rounded">
                                <div class="day fw-bold">15</div>
                                <div class="month small">Juin</div>
                            </div>
                        </div>
                        <div class="event-content">
                            <h6 class="mb-1">Conseil de classe</h6>
                            <p class="small text-muted mb-1"><i class="fas fa-clock me-1"></i> 14:00 - 16:00</p>
                            <p class="mb-0">Lucas (2nde C)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accès rapides -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Accès rapides</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-3">
                            <a href="{{ route('parent.showChildren', Auth::user()->id) }}" class="card border-left-primary h-100 py-2 text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-child fa-2x text-primary"></i></div>
                                    <h6 class="mb-0 font-weight-bold text-gray-800">Mes enfants</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <a href="#" class="card border-left-success h-100 py-2 text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-file-alt fa-2x text-success"></i></div>
                                    <h6 class="mb-0 font-weight-bold text-gray-800">Bulletins</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <a href="#" class="card border-left-info h-100 py-2 text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-credit-card fa-2x text-info"></i></div>
                                    <h6 class="mb-0 font-weight-bold text-gray-800">Paiements</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <a href="#" class="card border-left-warning h-100 py-2 text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="mb-2"><i class="fas fa-envelope fa-2x text-warning"></i></div>
                                    <h6 class="mb-0 font-weight-bold text-gray-800">Messages</h6>
                                </div>
                            </a>
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
.date-box {
    min-width: 50px;
}
.event-item:last-child {
    border-bottom: none !important;
    padding-bottom: 0 !important;
    margin-bottom: 0 !important;
}
.card .stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    content: "";
}
</style>
@endsection