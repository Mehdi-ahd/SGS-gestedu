<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lycée International GestEdu - Excellence Académique</title>

    <link rel="icon" href="{{ asset('img/gestedu-logo.svg') }}" sizes="any">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ asset ('assets/css/bootstrap.min.css')}}" rel="stylesheet"> --}}
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link rel="stylesheet" href="{{ asset ('assets/css/all.min.css')}}"> --}}
    
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
            background: linear-gradient(rgba(78, 115, 223, 0.8), rgba(78, 115, 223, 0.9)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            min-height: 600px;
            display: flex;
            align-items: center;
        }
        
        .hero-content {
            max-width: 800px;
        }
        
        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 2.5rem;
            font-weight: 600;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -12px;
            width: 70px;
            height: 4px;
            background-color: var(--primary-color);
        }
        
        .feature-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }
        
        .feature-card .card-body {
            padding: 2rem;
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            color: white;
            font-size: 1.75rem;
            border-radius: 50%;
            margin-bottom: 1.5rem;
        }
        
        .stats-section {
            background-color: var(--light-color);
            padding: 5rem 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 2rem;
        }
        
        .stat-item .number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .stat-item .text {
            font-size: 1.1rem;
            color: var(--dark-color);
        }
        
        .news-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 30px;
            height: 100%;
        }
        
        .news-card img {
            height: 200px;
            object-fit: cover;
        }
        
        .news-card .card-body {
            padding: 1.5rem;
        }
        
        .news-card .date {
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .testimonial-section {
            background: linear-gradient(rgba(28, 200, 138, 0.8), rgba(28, 200, 138, 0.9)), url('https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 0;
        }
        
        .testimonial-card {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            backdrop-filter: blur(5px);
        }
        
        .testimonial-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1.5rem;
            border: 5px solid rgba(255, 255, 255, 0.3);
        }
        
        .footer {
            background-color: #212529;
            color: rgba(255, 255, 255, 0.8);
            padding: 5rem 0 1rem;
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .footer ul {
            padding-left: 0;
            list-style: none;
        }
        
        .footer ul li {
            margin-bottom: 0.75rem;
        }
        
        .footer ul li a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer ul li a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .social-icons a {
            display: inline-flex;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1.25rem;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
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
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .btn-light {
            background-color: white;
            color: var(--primary-color);
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-light:hover {
            background-color: #f8f9fa;
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('img/gestedu-logo.svg') }}" alt="GestEdu Logo" class="me-2">
                <div>
                    <span class="fw-bold text-primary">Lycée International</span>
                    <span class="d-block small">Excellence Académique</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#programs">Programmes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#news">Actualités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
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
            <div class="hero-content">
                <h1>Bienvenue au Lycée International GestEdu</h1>
                <p>Notre établissement d'excellence forme les leaders de demain dans un environnement stimulant et bienveillant. Découvrez notre approche pédagogique innovante et nos programmes académiques reconnus internationalement.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#programs" class="btn btn-light">
                        <i class="fas fa-book me-2"></i> Nos programmes
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light">
                        <i class="fas fa-user-plus me-2"></i> Inscription
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5" id="about">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="section-title">À propos de notre établissement</h2>
                    <p>Fondé en 1985, le Lycée International GestEdu s'engage à offrir une éducation de qualité supérieure qui combine excellence académique, développement personnel et ouverture sur le monde.</p>
                    <p>Notre approche pédagogique unique permet à chaque élève de développer son plein potentiel dans un environnement multiculturel et stimulant.</p>
                    <p>Avec des enseignants hautement qualifiés et des installations modernes, nous préparons nos élèves à réussir dans un monde globalisé et en constante évolution.</p>
                    <div class="mt-4">
                        <a href="#" class="btn btn-primary me-3">
                            <i class="fas fa-school me-2"></i> Notre histoire
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-users me-2"></i> Notre équipe
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Campus du Lycée International GestEdu" class="img-fluid rounded shadow">
                        <div class="position-absolute bottom-0 end-0 bg-primary text-white p-4 rounded-top-left" style="border-top-left-radius: 20px;">
                            <h4 class="mb-0">25+</h4>
                            <p class="mb-0">Années d'excellence académique</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="number">1200+</div>
                        <div class="text">Élèves</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="number">95%</div>
                        <div class="text">Taux de réussite</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="number">60+</div>
                        <div class="text">Enseignants qualifiés</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="number">30+</div>
                        <div class="text">Pays représentés</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="py-5" id="programs">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title d-inline-block">Nos programmes éducatifs</h2>
                <p class="lead text-muted mt-3">Découvrez nos cursus adaptés aux besoins de chaque élève</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h4>Collège International</h4>
                            <p class="text-muted">Notre programme de collège offre un équilibre parfait entre les matières fondamentales et les activités d'enrichissement. Les élèves développent leur curiosité intellectuelle et leurs compétences sociales.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #1cc88a;">
                                <i class="fas fa-globe"></i>
                            </div>
                            <h4>Lycée Français</h4>
                            <p class="text-muted">Notre cursus de lycée prépare les élèves au Baccalauréat avec un enseignement rigoureux et une attention particulière à l'orientation académique et professionnelle.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #f6c23e;">
                                <i class="fas fa-award"></i>
                            </div>
                            <h4>Baccalauréat International</h4>
                            <p class="text-muted">Programme reconnu mondialement préparant les élèves à l'entrée dans les meilleures universités internationales. Développe la pensée critique et l'ouverture culturelle.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #e74a3b;">
                                <i class="fas fa-language"></i>
                            </div>
                            <h4>Section Linguistique</h4>
                            <p class="text-muted">Programmes bilingues et plurilingues permettant aux élèves de maîtriser plusieurs langues et de développer une sensibilité interculturelle dès le plus jeune âge.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #36b9cc;">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <h4>Sciences et Technologies</h4>
                            <p class="text-muted">Parcours spécialisé dans les domaines scientifiques avec laboratoires équipés et projets innovants préparant aux carrières dans les STEM.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #858796;">
                                <i class="fas fa-palette"></i>
                            </div>
                            <h4>Arts et Culture</h4>
                            <p class="text-muted">Programme dédié aux arts visuels, à la musique, au théâtre et à la littérature pour les élèves souhaitant développer leur créativité et leur expression artistique.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-5 bg-light" id="news">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="section-title mb-0">Actualités et événements</h2>
                <a href="#" class="btn btn-outline-primary">Toutes les actualités</a>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <img src="https://images.unsplash.com/photo-1511377107391-116a9d5d26bf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" class="card-img-top" alt="Remise des diplômes">
                        <div class="card-body">
                            <div class="date">15 Mai 2023</div>
                            <h5 class="card-title">Cérémonie de remise des diplômes</h5>
                            <p class="card-text">La promotion 2023 a célébré la fin de ses études lors d'une cérémonie exceptionnelle. Félicitations à tous nos diplômés !</p>
                            <a href="#" class="btn btn-link px-0">Lire la suite <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1422&q=80" class="card-img-top" alt="Compétition sportive">
                        <div class="card-body">
                            <div class="date">5 Mai 2023</div>
                            <h5 class="card-title">Victoire au tournoi inter-lycées de football</h5>
                            <p class="card-text">Notre équipe a remporté la finale du championnat régional. Une performance exceptionnelle qui témoigne de l'esprit d'équipe.</p>
                            <a href="#" class="btn btn-link px-0">Lire la suite <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <img src="https://images.unsplash.com/photo-1544928147-79a2dbc1f389?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1374&q=80" class="card-img-top" alt="Conférence scientifique">
                        <div class="card-body">
                            <div class="date">28 Avril 2023</div>
                            <h5 class="card-title">Conférence sur les enjeux climatiques</h5>
                            <p class="card-text">Des scientifiques renommés ont animé une série de conférences pour sensibiliser nos élèves aux défis environnementaux.</p>
                            <a href="#" class="btn btn-link px-0">Lire la suite <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="container py-3">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-4">Ce que disent nos élèves et parents</h2>
                <p class="lead mb-0">Découvrez les témoignages de notre communauté</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Sarah Laurent" class="testimonial-img">
                        <h5>Sarah Laurent</h5>
                        <p class="small mb-3">Élève en Terminale</p>
                        <p>"Le Lycée International m'a offert bien plus qu'une éducation académique. J'ai développé ma confiance en moi et découvert ma passion pour les sciences. Les enseignants sont exceptionnels et toujours disponibles."</p>
                        <div class="mt-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Thomas Dubois" class="testimonial-img">
                        <h5>Thomas Dubois</h5>
                        <p class="small mb-3">Parent d'élève</p>
                        <p>"La décision d'inscrire notre fils dans cet établissement a été l'une des meilleures que nous ayons prises. L'environnement est à la fois stimulant et bienveillant. La communication avec les équipes est excellente."</p>
                        <div class="mt-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Emma Petit" class="testimonial-img">
                        <h5>Emma Petit</h5>
                        <p class="small mb-3">Ancienne élève, Promotion 2020</p>
                        <p>"Grâce à la préparation reçue au Lycée International, j'ai pu intégrer une grande université à l'étranger. Les compétences linguistiques et interculturelles acquises sont inestimables dans mon parcours."</p>
                        <div class="mt-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h2 class="section-title">Contactez-nous</h2>
                    <p class="mb-4">Vous avez des questions ou souhaitez en savoir plus sur nos programmes ? Notre équipe est à votre disposition pour vous accompagner.</p>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Adresse</h5>
                            <p class="mb-0">123 Avenue des Sciences, 75001 Paris, France</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Téléphone</h5>
                            <p class="mb-0">+33 (0)1 23 45 67 89</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Email</h5>
                            <p class="mb-0">contact@lycee-international.edu</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Horaires d'ouverture</h5>
                            <p class="mb-0">Lundi - Vendredi: 8h00 - 18h00</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="card border-0 shadow">
                        <div class="card-body p-5">
                            <h4 class="mb-4">Envoyez-nous un message</h4>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nom complet</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" id="phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Sujet</label>
                                        <select class="form-select" id="subject" required>
                                            <option value="" selected disabled>Sélectionnez un sujet</option>
                                            <option value="admission">Demande d'admission</option>
                                            <option value="information">Informations générales</option>
                                            <option value="visit">Visite de l'établissement</option>
                                            <option value="career">Carrières / Recrutement</option>
                                            <option value="other">Autre</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i> Envoyer le message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <div class="map-section">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9916256937604!2d2.292292615463156!3d48.85837007928757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sTour%20Eiffel!5e0!3m2!1sfr!2sfr!4v1651962636747!5m2!1sfr!2sfr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="/" class="d-flex align-items-center mb-4">
                        <img src="{{ asset('img/gestedu-logo.svg') }}" alt="GestEdu Logo" style="height: 50px;" class="me-3">
                        <div>
                            <h4 class="text-white mb-0">Lycée International</h4>
                            <span>Excellence Académique</span>
                        </div>
                    </a>
                    <p>Notre établissement d'excellence forme les leaders de demain dans un environnement stimulant et bienveillant.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5>Liens rapides</h5>
                    <ul>
                        <li><a href="/">Accueil</a></li>
                        <li><a href="#about">À propos</a></li>
                        <li><a href="#programs">Programmes</a></li>
                        <li><a href="#news">Actualités</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5>Programmes</h5>
                    <ul>
                        <li><a href="#">Collège International</a></li>
                        <li><a href="#">Lycée Français</a></li>
                        <li><a href="#">Baccalauréat International</a></li>
                        <li><a href="#">Section Linguistique</a></li>
                        <li><a href="#">Sciences et Technologies</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5>Ressources</h5>
                    <ul>
                        <li><a href="#">Calendrier scolaire</a></li>
                        <li><a href="#">Restauration</a></li>
                        <li><a href="#">Transport scolaire</a></li>
                        <li><a href="#">Activités extrascolaires</a></li>
                        <li><a href="#">Centre de documentation</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4">
                    <h5>Connexion</h5>
                    <ul>
                        <li><a href="{{ route('login') }}">Espace membre</a></li>
                        <li><a href="#">Portail élèves</a></li>
                        <li><a href="#">Portail enseignants</a></li>
                        <li><a href="#">Portail parents</a></li>
                        <li><a href="#">Support technique</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-5" style="opacity: 0.1;">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">&copy; {{ date('Y') }} Lycée International GestEdu. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#">Mentions légales</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#">Politique de confidentialité</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#">Cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="{{ asset ('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset ('assets/js/all.min.js')}}"></script> --}}
    
    <script>
        // Ajouter une classe au nav quand on scrolle
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('shadow-sm');
                } else {
                    navbar.classList.remove('shadow-sm');
                }
            });
            
            // Pour que le menu soit visible au départ
            setTimeout(function() {
                document.querySelector('.navbar').style.transform = 'translateY(0)';
            }, 200);
        });
    </script>
</body>
</html>