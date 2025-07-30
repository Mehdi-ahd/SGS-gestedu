<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GestEdu - Espace Parent">
    <meta name="author" content="GestEdu">
    @yield("header_elements")
    <title>@yield('title') | GestEdu - Espace Parent</title>

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('img/gestedu-logo.svg') }}" sizes="any">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --white-color: #ffffff;
            --sidebar-width: 14rem;
            --navbar-height: 4.375rem;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--light-color);
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar-parent {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            background-color: var(--white-color);
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .15);
            z-index: 1050;
            padding: 0;
        }

        .navbar-parent .navbar-brand {
            display: flex;
            align-items: center;
            padding: 0 1rem;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.2rem;
            text-decoration: none;
        }

        .navbar-parent .navbar-brand:hover {
            color: var(--primary-color);
        }

        .navbar-parent .navbar-brand img {
            height: 35px;
            margin-right: 0.5rem;
        }

        /* Navbar desktop items - hidden on mobile */
        .navbar-desktop-items {
            display: flex;
        }

        @media (max-width: 768px) {
            .navbar-desktop-items {
                display: none;
            }
        }

        .navbar-parent .navbar-nav .nav-link {
            color: var(--dark-color);
            padding: 0 0.75rem;
            height: var(--navbar-height);
            display: flex;
            align-items: center;
        }

        .navbar-parent .navbar-nav .nav-link:hover {
            color: var(--primary-color);
        }

        .navbar-parent .dropdown-menu {
            border: none;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .15);
        }

        /* Mobile sidebar toggle */
        .mobile-sidebar-toggle {
            display: none;
            background: none;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .mobile-sidebar-toggle:hover {
            background-color: var(--primary-color);
            color: white;
        }

        @media (max-width: 768px) {
            .mobile-sidebar-toggle {
                display: inline-block;
            }
        }

        /* Layout Container */
        .layout-container {
            display: flex;
            min-height: 100vh;
            padding-top: var(--navbar-height);
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #1e7e34 100%);
            color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(0, 0, 0, 0.15);
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            height: calc(100vh - var(--navbar-height));
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        /* Mobile sidebar - hidden by default */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* Sidebar Content */
        .sidebar-content {
            padding: 1rem 0;
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

        /* User Profile Section (mobile only) */
        .sidebar-user-profile {
            text-align: center;
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 1rem;
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar-user-profile {
                display: block;
            }
        }

        .sidebar-user-profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 0.75rem;
        }

        .sidebar-user-profile .user-name {
            font-weight: 600;
            font-size: 1rem;
            color: #fff;
            margin-bottom: 0.25rem;
        }

        .sidebar-user-profile .user-role {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar hr {
            margin: 0.5rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-item {
            margin: 0 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            margin-bottom: 0.25rem;
        }

        .nav-link:hover, .nav-link:focus {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: #fff;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .nav-link i {
            font-size: 1rem;
            margin-right: 0.75rem;
            opacity: 0.9;
            min-width: 1rem;
        }

        .nav-link span {
            font-size: 0.9rem;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            background-color: var(--light-color);
            min-height: calc(100vh - var(--navbar-height));
        }

        /* Mobile content area */
        @media (max-width: 768px) {
            .content-area {
                margin-left: 0;
                padding: 1rem;
            }
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            background-color: var(--white-color);
        }

        .card-header {
            padding: 1rem 1.25rem;
            background-color: var(--white-color);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1e7e34;
            border-color: #1e7e34;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Alert for verification */
        .alert-verification {
            background-color: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
            margin: 0;
            border-radius: 0;
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            right: 0;
            z-index: 1040;
        }

        .layout-container.has-alert {
            padding-top: calc(var(--navbar-height) + 60px);
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: 100%;
            height: calc(100vh - var(--navbar-height));
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Border utilities */
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

    @yield('styles')
</head>
<body>
    <!-- Verification Alert (only if user needs verification) -->
    @if(Auth::check() && Auth::user()->status === "en attente de soumission")
        <div class="alert alert-verification alert-dismissible fade show" role="alert">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span class="flex-grow-1">
                        <strong>Vérification d'identité requise :</strong> 
                        Veuillez compléter votre vérification d'identité pour accéder à tous nos services.
                    </span>
                    <a href="{{ route('parent.verification') }}" class="btn btn-sm btn-warning ms-3">
                        Vérifier maintenant
                    </a>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-parent">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('parent.dashboard') }}">
                <img src="{{ asset('img/gestedu-logo.svg') }}" alt="Logo">
                GestEdu
            </a>

            <!-- Mobile sidebar toggle -->
            <button class="mobile-sidebar-toggle" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Desktop Navbar items -->
            <div class="navbar-desktop-items ms-auto">
                <!-- Search -->
                <div class="nav-item dropdown d-none d-lg-block me-3">
                    <form class="d-flex">
                        <input class="form-control form-control-sm" type="search" placeholder="Rechercher..." aria-label="Search">
                        <button class="btn btn-outline-primary btn-sm ms-1" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Notifications -->
                <div class="nav-item dropdown me-2">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger badge-sm">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item" href="#">Nouvelle note pour Thomas</a></li>
                        <li><a class="dropdown-item" href="#">Réunion parents-professeurs</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Voir toutes</a></li>
                    </ul>
                </div>

                <!-- User menu -->
                <div class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->getFullName()) }}&background=28a745&color=ffffff" alt="Profile" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                        <span class="d-none d-lg-inline text-dark">{{ Auth::user()->getFullName() }}</span>
                        <i class="fas fa-chevron-down ms-1"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('parent.profile') }}">
                            <i class="fas fa-user me-2"></i>Mon profil
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i>Paramètres
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Layout Container -->
    <div class="layout-container {{ Auth::check() && Auth::user()->status === 'en attente de soumission' ? 'has-alert' : '' }}">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-content">
                <!-- User Profile Section (visible on mobile) -->
                <div class="sidebar-user-profile">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->getFullName()) }}&background=28a745&color=ffffff" alt="Profile">
                    <div class="user-name">{{ Auth::user()->getFullName() }}</div>
                    <div class="user-role">Parent</div>
                </div>

                <ul class="navbar-nav">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}" href="{{ route('parent.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>

                    <hr>

                    <!-- Profile -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('parent.profile') ? 'active' : '' }}" href="{{ route('parent.profile') }}">
                            <i class="fas fa-user"></i>
                            <span>Mon profil</span>
                        </a>
                    </li>

                    <!-- Children -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('parent.children*') ? 'active' : '' }}" href="{{ route('parent.showChildren', Auth::user()->id) }}">
                            <i class="fas fa-child"></i>
                            <span>Mes enfants</span>
                        </a>
                    </li>

                    <!-- Student Registration -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('parent.student-registration') ? 'active' : '' }}" href="{{ route('parent.student-registration') }}">
                            <i class="fas fa-user-plus"></i>
                            <span>Inscrire un enfant</span>
                        </a>
                    </li>

                    <!-- Verification -->
                    @if(Auth::user()->status === 'en attente de soumission')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('parent.verification') ? 'active' : '' }}" href="{{ route('parent.verification') }}">
                                <i class="fas fa-shield-alt"></i>
                                <span>Vérification</span>
                            </a>
                        </li>
                    @endif

                    <!-- Payments -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('parent.payment.form') ? 'active' : '' }}" href="{{ route('parent.payments.index')}}">
                            <i class="fas fa-credit-card"></i>
                            <span>Paiements</span>
                        </a>
                    </li>

                    <!-- Schedule -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Emplois du temps</span>
                        </a>
                    </li>

                    <!-- Messages -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-envelope"></i>
                            <span>Messages</span>
                        </a>
                    </li>

                    <hr>

                    <!-- Reports -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-file-alt"></i>
                            <span>Bulletins</span>
                        </a>
                    </li>

                    <!-- Settings -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle sidebar on mobile
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }

            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }

            // Close sidebar on mobile when clicking a link
            const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
