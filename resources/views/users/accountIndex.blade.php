@extends("layouts.app")

@section("styles")

<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #1cc88a;
        --success-color: #1cc88a;
        --danger-color: #e74a3b;
        --warning-color: #f6c23e;
        --info-color: #36b9cc;
        --dark-color: #5a5c69;
        --light-color: #f8f9fc;
        --sidebar-width: 14rem;
        --sidebar-collapsed-width: 6.5rem;
        --topbar-height: 4.375rem;
    }
    
    body {
        font-family: 'Nunito', sans-serif;
        background-color: var(--light-color);
        overflow-x: hidden;
    }
    
    /* Sidebar Container */
    .sidebar-container {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        z-index: 1000;
        transition: all 0.3s ease;
    }
    
    /* Sidebar */
    .sidebar {
        height: 100%;
        background: linear-gradient(180deg, var(--primary-color) 0%, #224abe 100%);
        color: #fff;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    /* Sidebar Header (Brand) */
    .sidebar-header {
        flex-shrink: 0;
        height: var(--topbar-height);
        background: rgba(0, 0, 0, 0.1);
    }
    
    .sidebar-brand {
        height: 100%;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #fff;
    }
    
    .sidebar-brand-icon {
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }
    
    .sidebar-brand-text {
        font-weight: 700;
        font-size: 1.2rem;
    }
    
    /* Sidebar Content (Scrollable) */
    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding-bottom: 4rem;
    }
    
    .sidebar-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-content::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }
    
    .sidebar-content::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }
    
    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
    
    .sidebar hr {
        margin: 0.5rem 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .sidebar-heading {
        text-transform: uppercase;
        font-weight: 800;
        font-size: 0.65rem;
        padding: 0.5rem 1rem;
        color: rgba(255, 255, 255, 0.4);
    }
    
    .nav-item {
        position: relative;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.3s ease;
    }
    
    .nav-link:hover, .nav-link:focus {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .nav-link.active {
        color: #fff;
        font-weight: 700;
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .nav-link i {
        font-size: 1rem;
        margin-right: 0.75rem;
        opacity: 0.8;
        min-width: 1rem;
    }
    
    .nav-link span {
        font-size: 0.85rem;
    }
    
    .nav-item:has(.collapse) .nav-link::after {
        content: '\f107';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-left: auto;
        transition: all 0.3s;
    }
    
    .nav-item:has(.collapse) .nav-link.collapsed::after {
        transform: rotate(-90deg);
    }
    
    /* Collapse items styling */
    .collapse-inner {
        background-color: rgba(255, 255, 255, 0.95);
        margin: 0 1rem 0.5rem 1rem;
        border-radius: 0.25rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .collapse-inner ul {
        list-style: none;
        padding: 0.5rem 0;
        margin: 0;
    }
    
    .collapse-inner li {
        margin: 0;
    }
    
    .collapse-item {
        display: block;
        padding: 0.5rem 1rem;
        color: var(--dark-color);
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .collapse-item:hover {
        background-color: var(--light-color);
        color: var(--primary-color);
    }
    
    .collapse-item.active {
        background-color: var(--primary-color);
        color: #fff;
        font-weight: 600;
    }
    
    /* Content wrapper */
    .content-wrapper {
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    
    /* Topbar */
    .topbar {
        height: var(--topbar-height);
        background-color: #fff;
        box-shadow: 0 .125rem .25rem rgba(58, 59, 69, .15);
        z-index: 1;
    }
    
    .topbar .nav-item .nav-link {
        color: var(--dark-color);
        height: var(--topbar-height);
        display: flex;
        align-items: center;
        padding: 0 0.75rem;
        position: relative;
    }
    
    .topbar .nav-item .nav-link:hover, .topbar .nav-item .nav-link:focus {
        color: var(--primary-color);
        background-color: transparent;
    }
    
    .topbar .nav-item .nav-link i {
        font-size: 1rem;
        margin-right: 0;
        opacity: 1;
    }
    
    .topbar .dropdown-menu {
        position: absolute;
        right: 0;
        left: auto;
        width: auto;
        border: none;
        box-shadow: 0 .125rem .25rem rgba(58, 59, 69, .15);
    }
    
    .badge-counter {
        position: absolute;
        transform: scale(0.7);
        transform-origin: top right;
        right: 0.25rem;
        top: 0.25rem;
    }
    
    .profile-img {
        height: 100px;
        width: 100px;
        object-fit: cover;
    }
    
    /* Card design */
    .card {
        border: none;
        border-radius: 0.25rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        padding: 0.75rem 1.25rem;
        background-color: rgba(0, 0, 0, 0.02);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    /* Border left cards */
    .border-left-primary {
        border-left: 0.25rem solid var(--primary-color) !important;
    }
    
    .border-left-success {
        border-left: 0.25rem solid var(--success-color) !important;
    }
    
    .border-left-info {
        border-left: 0.25rem solid var(--info-color) !important;
    }
    
    .border-left-warning {
        border-left: 0.25rem solid var(--warning-color) !important;
    }
    
    .border-left-danger {
        border-left: 0.25rem solid var(--danger-color) !important;
    }

    /* ================ NOUVELLES STYLES POUR LA PAGE CONFIRMATION DES COMPTES ================ */
    
    /* Styles spécifiques à la table de confirmation des comptes */
    .account-table {
        background-color: #fff;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .account-table th {
        background-color: var(--primary-color);
        color: #fff;
        font-weight: 600;
        padding: 1rem 0.75rem;
        border: none;
    }
    
    .account-table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .account-table tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
    }
    
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending {
        background-color: rgba(246, 194, 62, 0.2);
        color: #d4a017;
    }
    
    .status-verification {
        background-color: rgba(54, 185, 204, 0.2);
        color: #2c9fb3;
    }
    
    .status-approved {
        background-color: rgba(28, 200, 138, 0.2);
        color: #1cc88a;
    }
    
    .status-rejected {
        background-color: rgba(231, 74, 59, 0.2);
        color: #e74a3b;
    }
    
    .user-info {
        display: flex;
        align-items: center;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        margin-right: 0.75rem;
    }
    
    .user-details h6 {
        margin: 0;
        font-weight: 600;
        color: var(--dark-color);
    }
    
    .user-details small {
        color: #858796;
    }
    
    .filter-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
    }
    
    .filter-card .form-control, .filter-card .form-select {
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
        color: var(--dark-color);
    }
    
    .filter-card .form-control::placeholder {
        color: #999;
    }
    
    .filter-card label {
        color: #fff;
        font-weight: 600;
    }
    
    .stats-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
        color: #fff;
        border: none;
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    
    .stats-label {
        font-size: 0.875rem;
        opacity: 0.9;
    }
    
    .action-btn {
        border: none;
        border-radius: 20px;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    }
    
    .btn-view {
        background-color: var(--info-color);
        color: #fff;
    }
    
    .btn-view:hover {
        background-color: #2b9cb3;
        color: #fff;
    }
    
    .search-section {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
    }
    
    .search-section h4 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar-container {
            width: 100%;
            position: relative;
            height: auto;
            z-index: 1;
        }
        
        .content-wrapper {
            margin-left: 0;
        }
        
        .account-table {
            font-size: 0.875rem;
        }
        
        .user-info {
            flex-direction: column;
            text-align: center;
        }
        
        .user-avatar {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
    }
</style>

@endsection

@section("content")

<div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Confirmation des comptes</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Exporter la liste
                </a>
            </div>

            <!-- Statistics Cards Row -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="stats-label text-uppercase mb-1">En attente de vérification</div>
                                    <div class="stats-number"> {{ $usersInawait }} </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x" style="opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">En vérification</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersInawaitConfirm }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-search fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Validés</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersConfirm }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rejetés</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where("status", "rejeté")->count()}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="search-section">
                <h4><i class="fas fa-filter me-2"></i>Filtres et recherche</h4>
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="search" class="form-label">Rechercher</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Nom, prénom ou email..." value="">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <select class="form-select" id="role" name="role">
                                <option value="">Tous les rôles</option>
                                <option value="1">Administrateur</option>
                                <option value="2">Professeur</option>
                                <option value="3">Parent</option>
                                <option value="4">Étudiant</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Statut</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Tous les statuts</option>
                                <option value="en attente de validation">En attente</option>
                                <option value="en attente de vérification">En vérification</option>
                                <option value="validé">Validé</option>
                                <option value="rejeté">Rejeté</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-light w-100">
                                <i class="fas fa-search me-1"></i>Filtrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Accounts Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Comptes en attente de validation</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Actions:</div>
                            <a class="dropdown-item" href="#">Exporter en CSV</a>
                            <a class="dropdown-item" href="#">Exporter en PDF</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Actualiser</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table account-table mb-0">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Rôle</th>
                                    <th>Date d'inscription</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">MD</div>
                                                <div class="user-details">
                                                    <h6>{{ $user->getFullName() }}</h6>
                                                    <small>{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge {{ ($user->role->id === "teacher") ? " bg-success " : " bg-primary " }} ">{{ $user->role->name }}</span></td>
                                        <td>{{ $user->get_date() }}</td>
                                        <td><span class="status-badge status-pending">{{ $user->status }}</span></td>
                                        <td>
                                            <a href="{{ route("accountConfirmationShow", $user->id) }}" class="action-btn btn-view">
                                                <i class="fas fa-eye me-1"></i>Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-muted">
                    Affichage de 1 à 6 sur 20 résultats
                </div>
                <nav aria-label="Navigation des pages">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

@endsection

@section("scripts")

<script>
        // Toggle the side navigation
        (function($) {
            "use strict"; // Start of use strict
            
            // Toggle the side navigation
            $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                };
            });
            
            // Close any open menu accordions when window is resized below 768px
            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.sidebar .collapse').collapse('hide');
                };
                
                // Toggle the side navigation when window is resized below 480px
                if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
                    $("body").addClass("sidebar-toggled");
                    $(".sidebar").addClass("toggled");
                    $('.sidebar .collapse').collapse('hide');
                };
            });
            
            // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
            $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
                if ($(window).width() > 768) {
                    var e0 = e.originalEvent,
                        delta = e0.wheelDelta || -e0.detail;
                    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                    e.preventDefault();
                }
            });
            
        })(jQuery); // End of use strict
    </script>

@endsection