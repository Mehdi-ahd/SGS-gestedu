
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frais scolaires - École Jean Piaget 2</title>

    <link rel="icon" href="{{ asset('img/gestedu-logo.svg') }}" sizes="any">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --accent-color: #f6c23e;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: var(--light-color);
        }
        
        .navbar {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background: white !important;
            padding: 0.5rem 1rem;
        }
        
        .navbar-brand img {
            height: 50px;
        }
        
        .hero-section {
            background: linear-gradient(rgba(78, 115, 223, 0.8), rgba(78, 115, 223, 0.9)), url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0 80px;
        }
        
        .category-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            border-color: var(--primary-color);
        }
        
        .category-header {
            background: linear-gradient(135deg, var(--primary-color), #6f42c1);
            color: white;
            padding: 2.5rem;
            text-align: center;
            position: relative;
        }
        
        .category-header.college {
            background: linear-gradient(135deg, var(--secondary-color), #17a673);
        }
        
        .category-header.lycee {
            background: linear-gradient(135deg, var(--accent-color), #e0a800);
        }
        
        .category-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        
        .category-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .category-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .fees-section {
            display: none;
            background: white;
            margin-top: 3rem;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
        }
        
        .fees-header {
            background: var(--primary-color);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .fees-content {
            padding: 3rem;
        }
        
        .fee-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0.1rem 1rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 2rem;
        }
        
        .fee-table-header {
            background: var(--dark-color);
            color: white;
            padding: 1rem;
            font-weight: 600;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .fee-table table {
            width: 100%;
            margin: 0;
        }
        
        .fee-table th {
            background: #f8f9fc;
            color: var(--dark-color);
            font-weight: 600;
            padding: 1rem;
            border-bottom: 2px solid #e3e6f0;
            text-align: center;
        }
        
        .fee-table td {
            padding: 1rem;
            border-bottom: 1px solid #e3e6f0;
            text-align: center;
        }
        
        .fee-table tbody tr:hover {
            background-color: #f8f9fc;
        }
        
        .amount {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .payment-info {
            background: #f8f9fc;
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 0 10px 10px 0;
        }
        
        .payment-info h5 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #3b5cb6;
            border-color: #3b5cb6;
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .back-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 1rem 1.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            z-index: 1000;
            display: none;
        }
        
        .back-btn:hover {
            background: #3b5cb6;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('img/gestedu-logo.svg') }}" alt="École Jean Piaget 2" class="me-2">
                <div>
                    <span class="fw-bold text-primary">École Jean Piaget 2</span>
                    <span class="d-block small">Excellence Éducative</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#programs">Programmes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tuitions') }}">Frais scolaires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Espace membre
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="text-center">
                <h1 class="mb-4">Modalités de paiement des frais scolaires</h1>
                <p class="lead mb-0">Année scolaire 2024-2025 - École Jean Piaget 2, Abomey-Calavi</p>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5" id="categoriesSection">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Choisissez un cycle d'études</h2>
                <p class="text-muted">Cliquez sur une catégorie pour voir les détails des frais de scolarité</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="category-card" onclick="showFees('primaire')">
                        <div class="category-header primaire">
                            <i class="fas fa-child category-icon"></i>
                            <h3 class="category-title">PRIMAIRE</h3>
                            <p class="category-subtitle">CP - CM2</p>
                        </div>
                        <div class="p-4 text-center">
                            <p class="text-muted mb-0">Frais pour les classes du primaire</p>
                            <small class="text-primary">Cliquez pour voir les détails</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="category-card" onclick="showFees('college')">
                        <div class="category-header college">
                            <i class="fas fa-graduation-cap category-icon"></i>
                            <h3 class="category-title">COLLÈGE</h3>
                            <p class="category-subtitle">6ème - 3ème</p>
                        </div>
                        <div class="p-4 text-center">
                            <p class="text-muted mb-0">Frais pour les classes du collège</p>
                            <small class="text-success">Cliquez pour voir les détails</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="category-card" onclick="showFees('lycee')">
                        <div class="category-header lycee">
                            <i class="fas fa-user-graduate category-icon"></i>
                            <h3 class="category-title">LYCÉE</h3>
                            <p class="category-subtitle">2nde - Terminale</p>
                        </div>
                        <div class="p-4 text-center">
                            <p class="text-muted mb-0">Frais pour les classes du lycée</p>
                            <small style="color: #e0a800;">Cliquez pour voir les détails</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fees Details Section -->
    <section class="fees-section" id="feesSection">
        <div class="container">
            <div class="fees-header">
                <h2 id="feesTitle">Frais de scolarité</h2>
                <p id="feesSubtitle" class="mb-0">Détails des frais pour l'année 2024-2025</p>
            </div>
            <div class="fees-content" id="feesContent">
                <!-- Le contenu sera chargé dynamiquement -->
            </div>
        </div>
    </section>

    <!-- Back to top button -->
    <button class="back-btn" id="backBtn" onclick="backToCategories()">
        <i class="fas fa-arrow-left me-2"></i> Retour aux catégories
    </button>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('img/gestedu-logo.svg') }}" alt="École Jean Piaget 2" style="height: 50px;" class="me-3">
                        <div>
                            <h4 class="mb-0">École Jean Piaget 2</h4>
                            <span class="text-muted">Excellence Éducative</span>
                        </div>
                    </div>
                    <p class="text-muted">Notre établissement forme les leaders de demain dans un environnement alliant tradition africaine et modernité éducative.</p>
                </div>
                <div class="col-lg-6">
                    <h5 class="mb-3">Contact</h5>
                    <p class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i> Quartier Akassato, Abomey-Calavi, Bénin</p>
                    <p class="text-muted mb-2"><i class="fas fa-phone me-2"></i> +229 21 30 15 89</p>
                    <p class="text-muted mb-2"><i class="fas fa-envelope me-2"></i> contact@ecolejeanpiaget2.edu.bj</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} École Jean Piaget 2. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Données des frais basées sur les prospectus
        const feesData = {
            primaire: {
                title: "FRAIS DE SCOLARITÉ - PRIMAIRE",
                subtitle: "Classes du CP au CM2 - Année scolaire 2024-2025",
                content: `
                    <div class="fee-table">
                        <div class="fee-table-header">Frais d'inscription et de scolarité</div>
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Classe</th>
                                    <th>Inscription</th>
                                    <th>1er Trimestre</th>
                                    <th>2ème Trimestre</th>
                                    <th>3ème Trimestre</th>
                                    <th>Total Annuel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CP</td>
                                    <td class="amount">20 000 FCFA</td>
                                    <td class="amount">50 000 FCFA</td>
                                    <td class="amount">50 000 FCFA</td>
                                    <td class="amount">50 000 FCFA</td>
                                    <td class="amount">170 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>CE1</td>
                                    <td class="amount">20 000 FCFA</td>
                                    <td class="amount">50 000 FCFA</td>
                                    <td class="amount">50 000 FCFA</td>
                                    <td class="amount">50 000 FCFA</td>
                                    <td class="amount">170 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>CE2</td>
                                    <td class="amount">20 000 FCFA</td>
                                    <td class="amount">55 000 FCFA</td>
                                    <td class="amount">55 000 FCFA</td>
                                    <td class="amount">55 000 FCFA</td>
                                    <td class="amount">185 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>CM1</td>
                                    <td class="amount">25 000 FCFA</td>
                                    <td class="amount">60 000 FCFA</td>
                                    <td class="amount">60 000 FCFA</td>
                                    <td class="amount">60 000 FCFA</td>
                                    <td class="amount">205 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>CM2</td>
                                    <td class="amount">25 000 FCFA</td>
                                    <td class="amount">60 000 FCFA</td>
                                    <td class="amount">60 000 FCFA</td>
                                    <td class="amount">60 000 FCFA</td>
                                    <td class="amount">205 000 FCFA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="payment-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Modalités de paiement</h5>
                        <ul class="mb-0">
                            <li>Les frais d'inscription sont payables à l'inscription</li>
                            <li>Les frais de scolarité sont payables au début de chaque trimestre</li>
                            <li>Possibilité de paiement mensuel sur demande</li>
                            <li>Remise de 5% pour paiement annuel intégral</li>
                        </ul>
                    </div>
                `
            },
            college: {
                title: "FRAIS DE SCOLARITÉ - COLLÈGE",
                subtitle: "Classes de 6ème en 3ème - Année scolaire 2024-2025",
                content: `
                    <div class="fee-table">
                        <div class="fee-table-header">Frais d'inscription et de scolarité</div>
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Classe</th>
                                    <th>Inscription</th>
                                    <th>1er Trimestre</th>
                                    <th>2ème Trimestre</th>
                                    <th>3ème Trimestre</th>
                                    <th>Total Annuel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>6ème</td>
                                    <td class="amount">30 000 FCFA</td>
                                    <td class="amount">65 000 FCFA</td>
                                    <td class="amount">65 000 FCFA</td>
                                    <td class="amount">65 000 FCFA</td>
                                    <td class="amount">225 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>5ème</td>
                                    <td class="amount">30 000 FCFA</td>
                                    <td class="amount">65 000 FCFA</td>
                                    <td class="amount">65 000 FCFA</td>
                                    <td class="amount">65 000 FCFA</td>
                                    <td class="amount">225 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>4ème</td>
                                    <td class="amount">30 000 FCFA</td>
                                    <td class="amount">70 000 FCFA</td>
                                    <td class="amount">70 000 FCFA</td>
                                    <td class="amount">70 000 FCFA</td>
                                    <td class="amount">240 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>3ème</td>
                                    <td class="amount">35 000 FCFA</td>
                                    <td class="amount">75 000 FCFA</td>
                                    <td class="amount">75 000 FCFA</td>
                                    <td class="amount">75 000 FCFA</td>
                                    <td class="amount">260 000 FCFA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="fee-table">
                        <div class="fee-table-header">Frais d'examen BEPC (3ème uniquement)</div>
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Type d'examen</th>
                                    <th>Montant</th>
                                    <th>Échéance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Frais d'examen BEPC</td>
                                    <td class="amount">25 000 FCFA</td>
                                    <td>Décembre 2024</td>
                                </tr>
                                <tr>
                                    <td>Frais de composition</td>
                                    <td class="amount">15 000 FCFA</td>
                                    <td>Janvier 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="payment-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Modalités de paiement - Collège</h5>
                        <ul class="mb-0">
                            <li>Les frais d'inscription sont payables lors de la réinscription</li>
                            <li>Les frais de scolarité sont exigibles au début de chaque trimestre</li>
                            <li>Les frais d'examen BEPC sont obligatoires pour les élèves de 3ème</li>
                            <li>Remise de 7% pour paiement annuel intégral avant le 30 septembre</li>
                            <li>Paiement mensuel possible avec majoration de 3%</li>
                        </ul>
                    </div>
                `
            },
            lycee: {
                title: "FRAIS DE SCOLARITÉ - LYCÉE",
                subtitle: "Classes de Seconde, Première et Terminale - Année scolaire 2024-2025",
                content: `
                    <div class="fee-table">
                        <div class="fee-table-header">Frais d'inscription et de scolarité</div>
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Classe</th>
                                    <th>Inscription</th>
                                    <th>1er Trimestre</th>
                                    <th>2ème Trimestre</th>
                                    <th>3ème Trimestre</th>
                                    <th>Total Annuel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Seconde</td>
                                    <td class="amount">35 000 FCFA</td>
                                    <td class="amount">80 000 FCFA</td>
                                    <td class="amount">80 000 FCFA</td>
                                    <td class="amount">80 000 FCFA</td>
                                    <td class="amount">275 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>Première</td>
                                    <td class="amount">35 000 FCFA</td>
                                    <td class="amount">85 000 FCFA</td>
                                    <td class="amount">85 000 FCFA</td>
                                    <td class="amount">85 000 FCFA</td>
                                    <td class="amount">290 000 FCFA</td>
                                </tr>
                                <tr>
                                    <td>Terminale</td>
                                    <td class="amount">40 000 FCFA</td>
                                    <td class="amount">90 000 FCFA</td>
                                    <td class="amount">90 000 FCFA</td>
                                    <td class="amount">90 000 FCFA</td>
                                    <td class="amount">310 000 FCFA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="fee-table">
                        <div class="fee-table-header">Frais d'examen BAC (Terminale uniquement)</div>
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Type d'examen</th>
                                    <th>Montant</th>
                                    <th>Échéance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Frais d'examen BAC</td>
                                    <td class="amount">35 000 FCFA</td>
                                    <td>Décembre 2024</td>
                                </tr>
                                <tr>
                                    <td>Frais de composition</td>
                                    <td class="amount">20 000 FCFA</td>
                                    <td>Janvier 2025</td>
                                </tr>
                                <tr>
                                    <td>Frais de travaux pratiques</td>
                                    <td class="amount">15 000 FCFA</td>
                                    <td>Mars 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="fee-table">
                        <div class="fee-table-header">Frais optionnels</div>
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Montant</th>
                                    <th>Période</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Transport scolaire</td>
                                    <td class="amount">30 000 FCFA</td>
                                    <td>Par trimestre</td>
                                </tr>
                                <tr>
                                    <td>Restauration (demi-pension)</td>
                                    <td class="amount">40 000 FCFA</td>
                                    <td>Par trimestre</td>
                                </tr>
                                <tr>
                                    <td>Cours de soutien (Sciences)</td>
                                    <td class="amount">25 000 FCFA</td>
                                    <td>Par trimestre</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="payment-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Modalités de paiement - Lycée</h5>
                        <ul class="mb-0">
                            <li>Les frais d'inscription sont payables lors de l'inscription ou réinscription</li>
                            <li>Les frais de scolarité sont exigibles au début de chaque trimestre</li>
                            <li>Les frais d'examen BAC sont obligatoires pour les élèves de Terminale</li>
                            <li>Remise de 10% pour paiement annuel intégral avant le 15 septembre</li>
                            <li>Facilités de paiement possibles sur demande motivée</li>
                            <li>Les frais optionnels sont à solder séparément</li>
                        </ul>
                    </div>
                `
            }
        };

        function showFees(category) {
            const categoriesSection = document.getElementById('categoriesSection');
            const feesSection = document.getElementById('feesSection');
            const backBtn = document.getElementById('backBtn');
            const feesTitle = document.getElementById('feesTitle');
            const feesSubtitle = document.getElementById('feesSubtitle');
            const feesContent = document.getElementById('feesContent');
            
            // Masquer les catégories et afficher les frais
            categoriesSection.style.display = 'none';
            feesSection.style.display = 'block';
            backBtn.style.display = 'block';
            
            // Charger le contenu correspondant
            const data = feesData[category];
            feesTitle.textContent = data.title;
            feesSubtitle.textContent = data.subtitle;
            feesContent.innerHTML = data.content;
            
            // Scroll vers le haut
            feesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function backToCategories() {
            const categoriesSection = document.getElementById('categoriesSection');
            const feesSection = document.getElementById('feesSection');
            const backBtn = document.getElementById('backBtn');
            
            // Afficher les catégories et masquer les frais
            categoriesSection.style.display = 'block';
            feesSection.style.display = 'none';
            backBtn.style.display = 'none';
            
            // Scroll vers les catégories
            categoriesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    </script>
</body>
</html>
