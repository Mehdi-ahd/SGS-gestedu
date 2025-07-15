<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GestEdu - Système de gestion scolaire">
    <meta name="author" content="GestEdu">
    <title>Connexion | GestEdu</title>

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('img/gestedu-logo.svg') }}" sizes="any">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset ('assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('assets/css/all.min.css')}}">

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
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            max-width: 550px;
            width: 100%;
            padding: 0;
            border: none;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            padding: 2rem 1rem;
        }
        
        .school-logo {
            height: 80px;
            margin-bottom: 1rem;
        }
        
        .card-body {
            padding: 2rem;
            background-color: #fff;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 10rem;
            font-size: 0.9rem;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
            border-color: #bac8f3;
        }
        
        .form-check-label {
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 1rem;
            border-radius: 10rem;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #3b5cb8;
            border-color: #3b5cb8;
            transform: translateY(-2px);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .text-gray-600 {
            color: #6e707e !important;
        }
        
        .text-gray-900 {
            color: #3a3b45 !important;
        }
        
        .divider {
            position: relative;
            margin: 1.5rem 0;
            height: 1.5rem;
        }
        
        .divider:before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        .divider-text {
            position: relative;
            padding: 0 1rem;
            background-color: #fff;
            display: inline-block;
        }
        
        .card-footer {
            background-color: #f8f9fc;
            padding: 1.5rem;
            text-align: center;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 0.75rem;
            cursor: pointer;
            color: #6e707e;
        }
        
        .input-group-text {
            border-top-right-radius: 10rem;
            border-bottom-right-radius: 10rem;
            cursor: pointer;
        }
        
        .alert {
            border-radius: 0.5rem;
        }
        
        .role-selector {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .role-btn {
            border: 2px solid #e3e6f0;
            background-color: transparent;
            color: #6e707e;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            margin: 0 0.5rem;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .role-btn i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .role-btn.active {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background-color: rgba(78, 115, 223, 0.1);
        }
        
        .role-btn:hover {
            transform: translateY(-2px);
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card login-card">
                    <div class="card-header bg-white">
                        <a href="{{ route("index")}}">
                            <img src="{{ asset('img/gestedu-logo.svg') }}" alt="GestEdu Logo" class="school-logo">
                        </a>
                        
                        <h4 class="text-gray-900 mb-1">Bienvenue sur GestEdu</h4>
                        <p class="text-gray-600 mb-0">Système de gestion scolaire</p>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>Erreur :</strong> Identifiants incorrects
                        </div>
                        @endif

                        <!-- Login Form -->
                        <form class="user" method="POST" action="{{ route('login.post') }}">
                            @csrf
                            
                            <div class="form-group mb-4">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" value="{{ old('email') }}" required autofocus>
                            </div>
                            
                            <div class="form-group position-relative mb-4">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                                <span class="toggle-password" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">
                                Connexion
                            </button>
                        </form>
                        <div class="text-center mt-4">Pas encore de compte? <a href="{{ route("register") }}">S'inscrire</a></div>
                        <div class="text-center mt-4">
                            <a class="small" href="#">Mot de passe oublié ?</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p class="mb-0">© {{ date('Y') }} GestEdu - Tous droits réservés</p>
                    </div>
                </div>

                <!-- Demo Info Card -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Identifiants de démonstration</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body py-2 px-3">
                                        <h6 class="mb-1"><i class="fas fa-user-shield me-2 text-primary"></i> Admin</h6>
                                        <p class="small mb-0">admin@gestedu.edu / admin123</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body py-2 px-3">
                                        <h6 class="mb-1"><i class="fas fa-chalkboard-teacher me-2 text-success"></i> Enseignant</h6>
                                        <p class="small mb-0">prof@gestedu.edu / prof123</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body py-2 px-3">
                                        <h6 class="mb-1"><i class="fas fa-user-graduate me-2 text-info"></i> Élève</h6>
                                        <p class="small mb-0">eleve@gestedu.edu / eleve123</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body py-2 px-3">
                                        <h6 class="mb-1"><i class="fas fa-users me-2 text-warning"></i> Parent</h6>
                                        <p class="small mb-0">parent@gestedu.edu / parent123</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body py-2 px-3">
                                        <h6 class="mb-1"><i class="fas fa-calculator me-2 text-danger"></i> Comptable</h6>
                                        <p class="small mb-0">compta@gestedu.edu / compta123</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset ('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset ('assets/js/all.min.js')}}"></script>

    <script>
        // Toggle password visibility
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Role selector
        document.addEventListener('DOMContentLoaded', function() {
            const roleButtons = document.querySelectorAll('.role-btn');
            const roleInput = document.getElementById('role-input');
            
            roleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    roleButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Set role input value
                    roleInput.value = this.getAttribute('data-role');
                    
                    // Update credentials based on role
                    const credentials = {
                        admin: {
                            email: 'admin@gestedu.edu',
                            password: 'admin123'
                        },
                        teacher: {
                            email: 'prof@gestedu.edu',
                            password: 'prof123'
                        },
                        student: {
                            email: 'eleve@gestedu.edu',
                            password: 'eleve123'
                        },
                        parent: {
                            email: 'parent@gestedu.edu',
                            password: 'parent123'
                        },
                        accountant: {
                            email: 'compta@gestedu.edu',
                            password: 'compta123'
                        }
                    };
                    
                    const role = this.getAttribute('data-role');
                    document.getElementById('email').value = credentials[role].email;
                    document.getElementById('password').value = credentials[role].password;
                });
            });
        });
    </script>
</body>
</html>