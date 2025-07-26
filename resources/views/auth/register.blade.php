<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GestEdu - Système de gestion scolaire">
    <meta name="author" content="GestEdu">
    <title>Inscription | GestEdu</title>

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
        
        .register-card {
            max-width: 650px;
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
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }
        
        .role-btn {
            border: 2px solid #e3e6f0;
            background-color: transparent;
            color: #6e707e;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin: 0.5rem;
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
                <div class="card register-card">
                    <div class="card-header bg-white">
                        <img src="{{ asset('img/gestedu-logo.svg') }}" alt="GestEdu Logo" class="school-logo">
                        <h4 class="text-gray-900 mb-1">Créer un compte GestEdu</h4>
                        <p class="text-gray-600 mb-0">Remplissez le formulaire ci-dessous pour vous inscrire</p>
                    </div>
                    <div class="card-body">
                        @if (session("error"))
                            <div class="alert alert-danger">
                                {{ session("error") }}
                            </div>
                        @endif
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>Erreur :</strong> Veuillez corriger les erreurs ci-dessous.
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Register Form -->
                        <form class="user" method="POST" action="{{ route('register.post') }}">
                            @csrf
                            
                            <!-- Le rôle par défaut sera défini côté serveur -->
                            <input type="hidden" name="role" value="supervisor">
                            
                            <div class="alert alert-info mb-4" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                Vous vous inscrivez en tant que parent ou tuteur. Les autres types de comptes sont créés par l'administration.
                            </div>
                            
                            <div class="form-group">
                                <label for="lastname" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="firstname" class="form-label">Prénoms</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}" required autofocus>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            
                            <div class="form-group position-relative">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            
                            <div class="form-group position-relative">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <span class="toggle-password" onclick="togglePasswordVisibility('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            
                            <input type="hidden" class="form-control" name="token" value="{{$token}}">
                            
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                                    <label class="form-check-label" for="agree">
                                        J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a>
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">
                                Créer mon compte
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <span class="small">Vous avez déjà un compte ? </span>
                            <a class="small" href="{{ route('login') }}">Connectez-vous ici</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p class="mb-0">© {{ date('Y') }} GestEdu - Tous droits réservés</p>
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
        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.querySelector(`#${fieldId} + .toggle-password i`);
            
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
                });
            });
        });
    </script>
</body>
</html>