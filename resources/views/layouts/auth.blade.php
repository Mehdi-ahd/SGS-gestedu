<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestEdu - @yield('title', 'Authentification')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset ('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('assets/css/all.min.css')}}">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e67e22;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            background-color: #f8f9fa;
        }
        
        .auth-container {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .auth-card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .auth-header .logo {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .auth-header .subtitle {
            color: #6c757d;
            font-size: 1rem;
        }
        
        .bg-image {
            background-image: url('https://source.unsplash.com/random/1200x800/?school');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            width: 100%;
        }
        
        .content-overlay {
            background-color: rgba(44, 62, 80, 0.85);
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 40px;
        }
        
        .welcome-text {
            color: white;
        }
        
        .welcome-text h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .welcome-text p {
            font-size: 1.1rem;
            max-width: 500px;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .welcome-text .feature {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .welcome-text .feature i {
            font-size: 1.5rem;
            margin-right: 15px;
            color: var(--accent-color);
        }
        
        @media (max-width: 992px) {
            .bg-image {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="row g-0 w-100">
        <!-- Left side - Auth form -->
        <div class="col-lg-6">
            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="logo"><i class="fas fa-school"></i> GestEdu</div>
                        <div class="subtitle">@yield('subtitle', 'Système de Gestion Scolaire')</div>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
        
        <!-- Right side - Background image with welcome text -->
        <div class="col-lg-6">
            <div class="bg-image">
                <div class="content-overlay">
                    <div class="welcome-text">
                        <h1>Bienvenue sur GestEdu</h1>
                        <p>La solution complète pour gérer votre établissement scolaire, centraliser vos données et optimiser vos processus administratifs.</p>
                        
                        <div class="feature">
                            <i class="fas fa-user-graduate"></i>
                            <div>Gestion complète des étudiants, enseignants et parents</div>
                        </div>
                        
                        <div class="feature">
                            <i class="fas fa-calendar-alt"></i>
                            <div>Planification des cours et suivi des présences</div>
                        </div>
                        
                        <div class="feature">
                            <i class="fas fa-file-alt"></i>
                            <div>Organisation des examens et suivi des résultats</div>
                        </div>
                        
                        <div class="feature">
                            <i class="fas fa-money-bill-wave"></i>
                            <div>Gestion des paiements et des frais scolaires</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset ('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset ('assets/js/all.min.js')}}"></script>
    
    @yield('scripts')
</body>
</html>