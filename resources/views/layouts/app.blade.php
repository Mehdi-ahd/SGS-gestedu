<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GestEdu - Système de gestion scolaire">
    <meta name="author" content="GestEdu">
    @yield("header_elements")
    <title>@yield('title') | GestEdu</title>

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
            padding-bottom: 4rem; /* Espace pour le bouton toggle */
        }
        
        /* Scrollbar personnalisé pour la sidebar */
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
        
        /* Sidebar Footer (Toggle Button) */
        .sidebar-footer {
            flex-shrink: 0;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(180deg, var(--primary-color) 0%, #224abe 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
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
        
        .sidebar-toggle {
            color: rgba(255, 255, 255, 0.8);
            background-color: transparent;
            border: none;
            width: 100%;
            padding: 1rem;
            font-size: 0.85rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover, .sidebar-toggle:focus {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-toggle i {
            font-size: 1rem;
        }
        
        /* Sidebar collapse */
        .sidebar-collapsed .sidebar-container {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-collapsed .sidebar-heading {
            display: none;
        }
        
        .sidebar-collapsed .nav-item .nav-link span {
            display: none;
        }
        
        .sidebar-collapsed .nav-item:has(.collapse) .nav-link::after {
            display: none;
        }
        
        .sidebar-collapsed .collapse {
            display: none !important;
        }
        
        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        
        .sidebar-collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.25rem;
        }
        
        .sidebar-collapsed .sidebar-brand-text {
            display: none;
        }
        
        /* Content wrapper */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        
        .sidebar-collapsed .content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
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
        
        /* Footer */
        footer.sticky-footer {
            padding: 1rem 0;
            margin-top: auto;
            background-color: #fff;
            color: #858796;
            font-size: 0.85rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-container {
                width: 100%;
                position: relative;
                height: auto;
                z-index: 1;
            }
            
            .sidebar-collapsed .sidebar-container {
                width: 100%;
            }
            
            .content-wrapper, .sidebar-collapsed .content-wrapper {
                margin-left: 0;
            }
            
            .sidebar-brand-text, .nav-link span, .sidebar-heading, .nav-item:has(.collapse) .nav-link::after {
                display: inline !important;
            }
            
            .nav-link {
                justify-content: flex-start !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .nav-link i {
                margin-right: 0.75rem !important;
                font-size: 1rem !important;
            }
            
            .sidebar-toggle {
                position: relative;
            }
            
            .sidebar-footer {
                position: relative;
            }
        }
    </style>

    <!-- Additional styles from child pages -->
    @yield('styles')
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper" class="{{ session('sidebar_collapsed') ? 'sidebar-collapsed' : '' }}">
        
        <!-- Sidebar Container -->
        <div class="sidebar-container">
            <ul class="sidebar sidebar-nav navbar-nav">
                <!-- Sidebar Header -->
                <div class="sidebar-header">
                    <a class="sidebar-brand" href="{{ route('index') }}">
                        <div class="sidebar-brand-icon">
                            <img src="{{ asset('img/gestedu-logo.svg') }}" alt="Logo" style="height: 35px;">
                        </div>
                        <div class="sidebar-brand-text mx-2">GestEdu</div>
                    </a>
                </div>

                <!-- Sidebar Content (Scrollable) -->
                <div class="sidebar-content">
                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <!-- Nav Item - Dashboard -->
                    <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Admins, Teachers, Accountants -->
                    @if(Auth::check() && !in_array(Auth::user()->role_id, ["supervisor"]))
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Gestion des élèves
                    </div>

                    <!-- Nav Item - Students -->
                    <li class="nav-item {{ request()->is('students*') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->is('students*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStudents" aria-expanded="{{ request()->is('students*') ? 'true' : 'false' }}" aria-controls="collapseStudents">
                            <i class="fas fa-fw fa-user-graduate"></i>
                            <span>Élèves</span>
                        </a>
                        <div id="collapseStudents" class="collapse {{ request()->is('students*') ? 'show' : '' }}">
                            <div class="collapse-inner rounded">
                                <ul>
                                    <li><a class="collapse-item {{ request()->is('students') ? 'active' : '' }}" href="{{ route('students.index') }}">Liste des élèves</a></li>
                                    
                                    @if (Auth::check() && in_array(Auth::user()->role_id, ['accountant', "admin"]))
                                        <li><a class="collapse-item {{ request()->is('students/create') ? 'active' : '' }}" href="{{ route('students.create') }}">Ajouter un élève</a></li>
                                        <li><a class="collapse-item {{ request()->is('students/reenrollment*') ? 'active' : '' }}" href="{{ route('students.reenrollment') }}">Réinscription</a></li>
                                    @endif
                                    @if(Auth::check() && in_array(Auth::user()->role_id, ["admin", "teacher"]))
                                        <li><a class="collapse-item {{ request()->is('attendance/create') ? 'active' : '' }}" href="{{ route('attendance.create') }}">Faire l'appel</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif

                    <!-- Admins, Accountants -->
                    @if(Auth::check() && in_array(Auth::user()->role_id, ["admin", 'accountant']))
                    <!-- Nav Item - Parents -->
                    <li class="nav-item {{ request()->is('parents*') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->is('parents*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseParents" aria-expanded="{{ request()->is('parents*') ? 'true' : 'false' }}" aria-controls="collapseParents">
                            <i class="fas fa-fw fa-users"></i>
                            <span>Parents</span>
                        </a>
                        <div id="collapseParents" class="collapse {{ request()->is('parents*') ? 'show' : '' }}">
                            <div class="collapse-inner rounded">
                                <ul>
                                    <li><a class="collapse-item {{ request()->is('parents') ? 'active' : '' }}" href="{{ route('parents.index') }}">Liste des parents</a></li>
                                    <li><a class="collapse-item {{ request()->is('parents/create') ? 'active' : '' }}" href="{{ route('parents.create') }}">Ajouter un parent</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif

                    <!-- Admins only -->
                    @if(Auth::check() && Auth::user()->isAdmin())
                    <!-- Nav Item - Teachers -->
                    <li class="nav-item {{ request()->is('teachers*') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->is('teachers*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTeachers" aria-expanded="{{ request()->is('teachers*') ? 'true' : 'false' }}" aria-controls="collapseTeachers">
                            <i class="fas fa-fw fa-chalkboard-teacher"></i>
                            <span>Enseignants</span>
                        </a>
                        <div id="collapseTeachers" class="collapse {{ request()->is('teachers*') ? 'show' : '' }}">
                            <div class="collapse-inner rounded">
                                <ul>
                                    <li><a class="collapse-item {{ request()->is('teachers') ? 'active' : '' }}" href="{{ route('teachers.index') }}">Liste des enseignants</a></li>
                                    <li><a class="collapse-item {{ request()->is('teachers/create') ? 'active' : '' }}" href="{{ route('teachers.create') }}">Ajouter un enseignant</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif

                    <!-- Everyone -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Académique
                    </div>

                    {{-- Un point important a revoir: les membres ayant d'autres roles mais avec des enfants inscrits, donc qui ont techniquement le role parent: (|| Auth::user()->students()->count() != 0) --}}
                    {{-- @if (Auth::user()->isParent() )
                        <!-- Nav Item - children -->
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsechildren" aria-expanded="false" aria-controls="collapsechildren">
                                <i class="fas fa-user"></i>
                                <span>Vos enfants</span>
                            </a>
                            <div id="collapsechildren" class="collapse">
                                <div class="collapse-inner rounded">
                                    <ul>
                                        <li><a class="collapse-item" href="{{ route("showChildren", Auth::user()->id ) }}">Liste des enfants</a></li>
                                        <li><a class="collapse-item" href="#">Effectuer une inscription</a></li>
                                        <li><a class="collapse-item" href="#">Effectuer une réinscription</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <!-- Nav Item - Payments -->
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsepayments" aria-expanded="false" aria-controls="collapsepayments">
                                <i class="fas fa-fw fa-file-invoice-dollar"></i>
                                <span>Vos Paiements</span>
                            </a>
                            <div id="collapsepayments" class="collapse">
                                <div class="collapse-inner rounded">
                                    <ul>
                                        <li><a class="collapse-item" href="#">Liste des paiements</a></li>
                                        <li><a class="collapse-item" href="#">Effectuer un nouveau paiement</a></li>
                                        <li><a class="collapse-item" href="#">Modalités des paiements</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif --}}
                    

                    <!-- Nav Item - Schedules -->
                    <li class="nav-item {{ request()->is('school-structure/schedules') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('school-structure.schedules.index') }}">
                            <i class="fas fa-fw fa-calendar-alt"></i>
                            <span>Emplois du temps</span>
                        </a>
                    </li>

                    <!-- Teachers and Admin -->
                    @if(Auth::check() && in_array(Auth::user()->role_id, ["admin", "teacher"]))
                        <!-- Nav Item - Examinations -->
                        <li class="nav-item {{ request()->is('examinations*') ? 'active' : '' }}">
                            <a class="nav-link {{ request()->is('examinations*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExams" aria-expanded="{{ request()->is('examinations*') ? 'true' : 'false' }}" aria-controls="collapseExams">
                                <i class="fas fa-fw fa-file-alt"></i>
                                <span>Évaluations</span>
                            </a>
                            <div id="collapseExams" class="collapse {{ request()->is('examinations*') ? 'show' : '' }}">
                                <div class="collapse-inner rounded">
                                    <ul>
                                        <li><a class="collapse-item" href="{{ route('examinations.create') }}">Créer une évaluation</a></li>
                                        <li><a class="collapse-item" href="#">Saisir les notes</a></li>
                                        <li><a class="collapse-item" href="#">Bulletins scolaires</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif

                    <!-- Accountant and Admin -->
                    @if(Auth::check() && in_array(Auth::user()->role_id, ["admin", "accountant"]))
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Finance
                    </div>

                    <!-- Nav Item - Payments -->
                    <li class="nav-item {{ request()->is('payments*') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->is('payments*') ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePayments" aria-expanded="{{ request()->is('payments*') ? 'true' : 'false' }}" aria-controls="collapsePayments">
                            <i class="fas fa-fw fa-money-bill-wave"></i>
                            <span>Paiements</span>
                        </a>
                        <div id="collapsePayments" class="collapse {{ request()->is('payments*') ? 'show' : '' }}">
                            <div class="collapse-inner rounded">
                                <ul>
                                    <li><a class="collapse-item" href="{{ route('payments.index') }}">Liste des paiements</a></li>
                                    <li><a class="collapse-item {{ request()->is('payments/create') ? "active" : "" }}" href="{{ route('payments.create')}}">Ajouter un paiement</a></li>
                                    <li><a class="collapse-item" href="#">Types de frais</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- Nav Item - Expenses -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExpenses" aria-expanded="false" aria-controls="collapseExpenses">
                            <i class="fas fa-fw fa-file-invoice-dollar"></i>
                            <span>Dépenses</span>
                        </a>
                        <div id="collapseExpenses" class="collapse">
                            <div class="collapse-inner rounded">
                                <ul>
                                    <li><a class="collapse-item" href="#">Liste des dépenses</a></li>
                                    <li><a class="collapse-item" href="#">Ajouter une dépense</a></li>
                                    <li><a class="collapse-item" href="#">Catégories</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif

                    <!-- Admin Only -->
                    @if(Auth::check() && Auth::user()->isAdmin() )
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Administration
                    </div>

                    <!-- Nav Item - Settings -->
                    <li class="nav-item {{ request()->is('roles*', 'users*') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->is('examinations*', 'users*', 'school-structure*') ? '' : ' collapsed ' }} " href="#" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                            <i class="fas fa-fw fa-cog"></i>
                            <span>Paramètres</span>
                        </a>
                        <div id="collapseSettings" class="collapse {{ request()->is('roles*', 'users*', 'account-confirmation*', 'school-structure*') ? 'show' : '' }}">
                            <div class="collapse-inner rounded">
                                <ul>
                                    <li><a class="collapse-item" href="#">Général</a></li>
                                    <li><a class="collapse-item {{ request()->is('account-confirmation*') ? 'active' : '' }} " href="{{ route("accountConfirmationIndex") }}">Confirmation des comptes</a></li>
                                    <li><a class="collapse-item {{ request()->is('school-structure*') ? 'active' : '' }} " href="{{ route("school-structure.study-level.index")}}">Structure scolaire</a></li>
                                    <li><a class="collapse-item {{ request()->is('roles*') ? 'active' : '' }} " href="{{ route("roles.index") }}">Rôles et permissions</a></li>
                                    <li><a class="collapse-item" href="#">Sauvegarde</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
                                <i class="fas fa-users"></i>
                                <span>Gestion des utilisateurs</span>
                            </a>
                            <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-bs-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <h6 class="collapse-header">Utilisateurs:</h6>
                                    <a class="collapse-item" href="<?= route('index') ?>">Liste des utilisateurs</a>
                                    <a class="collapse-item" href="<?= route('accountConfirmationIndex') ?>">Validation des comptes</a>
                                    <a class="collapse-item" href="<?= route('admin.invitation-tokens') ?>">Invitations</a>
                                    <a class="collapse-item" href="<?= route('parents.index') ?>">Parents</a>
                                    <a class="collapse-item" href="<?= route('teachers.index') ?>">Professeurs</a>
                                    <a class="collapse-item" href="<?= route('students.index') ?>">Élèves</a>
                                </div>
                            </div>
                        </li>
                    @endif

                    <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">
                </div>

                <!-- Sidebar Footer -->
                <div class="sidebar-footer">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-angle-left"></i>
                    </button>
                </div>
            </ul>
        </div>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">Centre d'Alertes</h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">12 décembre 2023</div>
                                    <span class="font-weight-bold">Un nouveau rapport mensuel est prêt à télécharger!</span>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Voir toutes les alertes</a>
                        </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">Centre de Messages</h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://via.placeholder.com/60x60" alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Salut! Je me demandais si vous pourriez m'aider avec quelque chose.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Lire plus de messages</a>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->getFullName() ?? 'Utilisateur' }}</span>
                            <img class="img-profile rounded-circle profile-img" src="https://randomuser.me/api/portraits/men/59.jpg">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profil
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Paramètres
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Journal d'activité
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Déconnexion
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; GestEdu 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à terminer votre session actuelle.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script>
        (function() {
            "use strict";

            // Toggle the side navigation
            document.getElementById("sidebarToggle").addEventListener("click", function(e) {
                e.preventDefault();
                document.body.classList.toggle("sidebar-collapsed");
                
                // Save state to session storage
                const isCollapsed = document.body.classList.contains("sidebar-collapsed");
                fetch('/toggle-sidebar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ collapsed: isCollapsed })
                });
            });

            // Toggle the side navigation (mobile)
            const sidebarToggleTop = document.getElementById("sidebarToggleTop");
            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener("click", function(e) {
                    e.preventDefault();
                    document.body.classList.toggle("sidebar-collapsed");
                });
            }

            // Smooth scrolling for sidebar
            const sidebarContent = document.querySelector('.sidebar-content');
            if (sidebarContent) {
                // Auto-scroll to active item on page load
                const activeItem = sidebarContent.querySelector('.nav-item.active');
                if (activeItem) {
                    setTimeout(() => {
                        activeItem.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }, 100);
                }
            }
        })();
    </script>

    <!-- Additional scripts from child pages -->
    @yield('scripts')
</body>
</html>