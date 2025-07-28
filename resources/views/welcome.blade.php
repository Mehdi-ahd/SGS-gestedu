<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>École Jean Piaget 2 - Excellence Éducative au Bénin</title>

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
            background: linear-gradient(rgba(28, 200, 138, 0.8), rgba(28, 200, 138, 0.9)), url('https://img.freepik.com/photos-gratuite/jeune-etudiante-africaine-masque-tenant-ses-manuels-scolaires-campus_181624-41232.jpg?semt=ais_hybrid&w=740');
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
                <img src="{{ asset('img/gestedu-logo.svg') }}" alt="École Jean Piaget 2" class="me-2">
                <div>
                    <span class="fw-bold text-primary">École Jean Piaget 2</span>
                    <span class="d-block small">Excellence Éducative</span>
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
                        <a class="nav-link" href="{{ route('tuitions') }}">Frais scolaires</a>
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
                <h1>Bienvenue à l'École Jean Piaget 2</h1>
                <p>Située à Abomey-Calavi au Bénin, notre établissement d'excellence forme les leaders de demain dans un environnement stimulant et bienveillant. Découvrez notre approche pédagogique innovante qui allie tradition africaine et modernité éducative.</p>
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
                    <p>Fondée en 2010 à Abomey-Calavi, l'École Jean Piaget 2 s'engage à offrir une éducation de qualité supérieure qui combine excellence académique, valeurs africaines et ouverture sur le monde moderne.</p>
                    <p>Notre approche pédagogique unique permet à chaque élève de développer son plein potentiel dans un environnement multiculturel qui valorise nos racines tout en préparant à l'avenir.</p>
                    <p>Avec des enseignants hautement qualifiés et des installations modernes adaptées au climat tropical, nous préparons nos élèves à réussir dans un monde globalisé tout en gardant leurs valeurs africaines.</p>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Formation complète</h6>
                                    <small class="text-muted">De la maternelle au BAC</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Encadrement personnalisé</h6>
                                    <small class="text-muted">Suivi individuel</small>
                                </div>
                            </div>
                        </div>
                    </div>

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
                        <img src="https://img.freepik.com/photos-gratuite/femme-africaine-enseignant-aux-enfants-classe_23-2148892564.jpg?semt=ais_hybrid&w=740&q=80" alt="Classe africaine à l'École Jean Piaget 2" class="img-fluid rounded shadow">
                        <div class="position-absolute bottom-0 end-0 bg-primary text-white p-4 rounded-top-left" style="border-top-left-radius: 20px;">
                            <h4 class="mb-0">14+</h4>
                            <p class="mb-0">Années d'excellence</p>
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
                        <div class="number">800+</div>
                        <div class="text">Élèves</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="number">92%</div>
                        <div class="text">Taux de réussite au BAC</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="number">45+</div>
                        <div class="text">Enseignants qualifiés</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="number">15+</div>
                        <div class="text">Nationalités représentées</div>
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
                <p class="lead text-muted mt-3">Des cursus adaptés aux réalités africaines et aux standards internationaux</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon">
                                <i class="fas fa-child"></i>
                            </div>
                            <h4>Maternelle</h4>
                            <p class="text-muted">Programme d'éveil adapté aux petits, intégrant les langues locales et le français dans un environnement ludique et sécurisé.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #1cc88a;">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h4>Primaire</h4>
                            <p class="text-muted">Enseignement fondamental solide avec emphasis sur la lecture, l'écriture, les mathématiques et l'initiation aux sciences dans un cadre africain.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #f6c23e;">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h4>Collège</h4>
                            <p class="text-muted">Formation équilibrée préparant au lycée avec renforcement en sciences, langues et culture générale adaptée au contexte béninois.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #e74a3b;">
                                <i class="fas fa-award"></i>
                            </div>
                            <h4>Lycée Général</h4>
                            <p class="text-muted">Préparation au Baccalauréat avec des filières scientifiques et littéraires, encadrement personnalisé pour l'orientation universitaire.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #36b9cc;">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h4>Informatique</h4>
                            <p class="text-muted">Formation moderne aux outils informatiques et à la programmation, préparant aux métiers du numérique en pleine expansion en Afrique.</p>
                            <a href="#" class="btn btn-outline-primary mt-3">En savoir plus</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="card-body">
                            <div class="feature-icon" style="background-color: #858796;">
                                <i class="fas fa-globe-africa"></i>
                            </div>
                            <h4>Culture et Langues</h4>
                            <p class="text-muted">Valorisation du patrimoine culturel africain, apprentissage des langues locales et étrangères pour une ouverture sur le monde.</p>
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
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="card-img-top" alt="Délibération des examens">
                        <div class="card-body">
                            <div class="date">25 Juillet 2024</div>
                            <h5 class="card-title">Délibération des résultats d'examens nationaux</h5>
                            <p class="card-text">Les résultats des examens nationaux ont été délibérés. L'École Jean Piaget 2 maintient son niveau d'excellence avec des taux de réussite exceptionnels.</p>
                            <a href="#" class="btn btn-link px-0">Lire la suite <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <img src="https://images.unsplash.com/photo-1562813733-b31f71025d54?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" class="card-img-top" alt="Résultats CEP">
                        <div class="card-body">
                            <div class="date">20 Juillet 2024</div>
                            <h5 class="card-title">100% de réussite au CEP 2024</h5>
                            <p class="card-text">Tous nos élèves du CM2 ont brillamment réussi le Certificat d'Études Primaires. Un taux de 100% qui témoigne de la qualité de notre enseignement primaire.</p>
                            <a href="#" class="btn btn-link px-0">Lire la suite <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="news-card">
                        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1422&q=80" class="card-img-top" alt="Résultats CAP">
                        <div class="card-body">
                            <div class="date">15 Juillet 2024</div>
                            <h5 class="card-title">100% au CAP série F3 - Excellence technique</h5>
                            <p class="card-text">Nos élèves de la série F3 affichent un taux de réussite parfait au CAP. Cette performance confirme notre engagement dans la formation technique de qualité.</p>
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
                <p class="lead mb-0">Témoignages de notre communauté éducative</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <img src="https://images.unsplash.com/photo-1506277886164-e25aa3f4ef7f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1287&q=80" alt="Aïcha Kone" class="testimonial-img">
                        <h5>Aïcha Koné</h5>
                        <p class="small mb-3">Élève en Terminale S</p>
                        <p>"L'École Jean Piaget 2 m'a donné confiance en moi. Les professeurs nous encouragent à viser l'excellence tout en restant fiers de nos origines africaines. Je me prépare maintenant pour intégrer une grande université."</p>
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
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Kouame Adjoua" class="testimonial-img">
                        <h5>M. Kouamé Adjoua</h5>
                        <p class="small mb-3">Parent d'élève</p>
                        <p>"En tant que parent, je suis très satisfait du niveau d'encadrement et de la qualité de l'enseignement. Mon fils a progressé remarquablement et a développé un vrai goût pour les études."</p>
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
                        <img src="https://images.unsplash.com/photo-1594736797933-d0dc8fbe7d5d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1287&q=80" alt="Fatima Barro" class="testimonial-img">
                        <h5>Fatima Barro</h5>
                        <p class="small mb-3">Ancienne élève, Promotion 2022</p>
                        <p>"Grâce à la formation reçue à Jean Piaget 2, j'ai pu intégrer l'université d'Abomey-Calavi en médecine. L'école m'a donné les bases solides nécessaires pour réussir mes études supérieures."</p>
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
                    <p class="mb-4">Vous avez des questions ou souhaitez inscrire votre enfant ? Notre équipe est à votre disposition pour vous accompagner dans votre démarche.</p>

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Adresse</h5>
                            <p class="mb-0">Quartier Akassato, Abomey-Calavi, Bénin</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Téléphone</h5>
                            <p class="mb-0">+229 21 30 15 89</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Email</h5>
                            <p class="mb-0">contact@ecolejeanpiaget2.edu.bj</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Horaires d'ouverture</h5>
                            <p class="mb-0">Lundi - Vendredi: 7h00 - 17h00</p>
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
                                            <option value="inscription">Demande d'inscription</option>
                                            <option value="information">Informations générales</option>
                                            <option value="visit">Visite de l'établissement</option>
                                            <option value="frais">Frais scolaires</option>
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="/" class="d-flex align-items-center mb-4">
                        <img src="{{ asset('img/gestedu-logo.svg') }}" alt="École Jean Piaget 2" style="height: 50px;" class="me-3">
                        <div>
                            <h4 class="text-white mb-0">École Jean Piaget 2</h4>
                            <span>Excellence Éducative</span>
                        </div>
                    </a>
                    <p>Notre établissement forme les leaders de demain dans un environnement alliant tradition africaine et modernité éducative.</p>
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
                        <li><a href="{{ route('tuitions') }}">Frais scolaires</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5>Programmes</h5>
                    <ul>
                        <li><a href="#">Maternelle</a></li>
                        <li><a href="#">Primaire</a></li>
                        <li><a href="#">Collège</a></li>
                        <li><a href="#">Lycée</a></li>
                        <li><a href="#">Informatique</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5>Services</h5>
                    <ul>
                        <li><a href="#">Calendrier scolaire</a></li>
                        <li><a href="#">Restauration</a></li>
                        <li><a href="#">Transport scolaire</a></li>
                        <li><a href="#">Activités extrascolaires</a></li>
                        <li><a href="#">Bibliothèque</a></li>
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
                    <p class="mb-0">&copy; {{ date('Y') }} École Jean Piaget 2. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#">Mentions légales</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#">Politique de confidentialité</a></li>
                        <li class="list-inline-item">|</li>
                        <li class="list-inline-item"><a href="#">Règlement intérieur</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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