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

        /* ================ NOUVELLES STYLES POUR LA PAGE DÉTAILS DU COMPTE ================ */
        
        /* Breadcrumb personnalisé */
        .custom-breadcrumb {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        
        .custom-breadcrumb .breadcrumb {
            margin: 0;
            background: transparent;
        }
        
        .custom-breadcrumb .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        
        .custom-breadcrumb .breadcrumb-item a:hover {
            color: #fff;
        }
        
        .custom-breadcrumb .breadcrumb-item.active {
            color: #fff;
            font-weight: 600;
        }
        
        .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.6);
        }
        
        /* Profile header */
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            border-radius: 1rem;
            color: #fff;
            margin-bottom: 2rem;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .profile-name {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .profile-role {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            display: inline-block;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-pending {
            background: linear-gradient(135deg, #f6c23e 0%, #dda119 100%);
            color: #fff;
        }
        
        .status-verification {
            background: linear-gradient(135deg, #36b9cc 0%, #2c9fb3 100%);
            color: #fff;
        }
        
        /* Info cards */
        .info-card {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .info-card h5 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(78, 115, 223, 0.1);
        }
        
        .info-row {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--dark-color);
            min-width: 140px;
            margin-right: 1rem;
        }
        
        .info-value {
            color: #5a5c69;
            flex: 1;
        }
        
        /* Documents section */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .document-card {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .document-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }
        
        .document-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            margin: 0 auto 1rem auto;
        }
        
        .document-title {
            font-weight: 600;
            color: var(--dark-color);
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .document-preview {
            width: 100%;
            height: 200px;
            border-radius: 0.5rem;
            background: var(--light-color);
            border: 2px dashed #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        
        .document-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            border-radius: 0.25rem;
        }
        
        .document-preview iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 0.25rem;
        }
        
        .document-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        
        .doc-btn {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .doc-btn-view {
            background-color: var(--info-color);
            color: #fff;
        }
        
        .doc-btn-view:hover {
            background-color: #2c9fb3;
            color: #fff;
        }
        
        .doc-btn-download {
            background-color: var(--success-color);
            color: #fff;
        }
        
        .doc-btn-download:hover {
            background-color: #17a673;
            color: #fff;
        }
        
        /* Action buttons */
        .action-section {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            margin-top: 2rem;
        }
        
        .action-section h4 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 150px;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
        }
        
        .btn-approve {
            background-color: var(--success-color);
            color: #fff;
        }
        
        .btn-approve:hover {
            background-color: #17a673;
            color: #fff;
        }
        
        .btn-reject {
            background-color: var(--danger-color);
            color: #fff;
        }
        
        .btn-reject:hover {
            background-color: #c0392b;
            color: #fff;
        }
        
        .btn-back {
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--dark-color);
        }
        
        .btn-back:hover {
            background-color: #fff;
            color: var(--dark-color);
        }
        
        /* Reject modal */
        .reject-form {
            background: var(--light-color);
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            display: none;
        }
        
        .reject-form.show {
            display: block;
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
            
            .profile-header {
                text-align: center;
            }
            
            .documents-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .action-btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>

@endsection

@section("content")
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="custom-breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="account-confirmation-index.html">Confirmation des comptes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Martin Dubois</li>
            </ol>
        </nav>
    </div>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <div class="profile-avatar">MD</div>
            </div>
            <div class="col-md-7">
                <div class="profile-name">{{ $user->getFullName() }}</div>
                <div class="mb-2">{{ $user->email }}</div>
                <span class="profile-role">{{ $user->role->name }}</span>
            </div>
            <div class="col-md-3 text-center">
                <div class="status-badge status-pending">
                    <i class="fas fa-clock me-2"></i>{{ $user->status }}
                </div>
                <div class="mt-2 text-white-50">
                    <small>Inscrit le {{ $user->get_date() }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="row">
        <div class="col-lg-6">
            <div class="info-card">
                <h5><i class="fas fa-user me-2"></i>Informations personnelles</h5>
                <div class="info-row">
                    <span class="info-label">Nom complet :</span>
                    <span class="info-value">{{ $user->getFullName() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email :</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone :</span>
                    <span class="info-value">{{ $user->phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date de naissance :</span>
                    <span class="info-value">{{ ( $user->birthday ) ? $user->getBirthday() : "Indisponible" }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sexe :</span>
                    <span class="info-value">{{ $user->getSex() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse :</span>
                    <span class="info-value">{{ $user->home_address }}</span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="info-card">
                <h5><i class="fas fa-briefcase me-2"></i>Informations professionnelles</h5>
                <div class="info-row">
                    <span class="info-label">Profession :</span>
                    <span class="info-value">{{ $user->job }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Employeur :</span>
                    <span class="info-value">( A revoir )</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse professionnelle :</span>
                    <span class="info-value">{{ ($user->work_address) ? $user->work_address : "Indisponible" }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone professionnel :</span>
                    <span class="info-value">{{ $user->phone }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="info-card">
        <h5><i class="fas fa-folder me-2"></i>Documents fournis</h5>
        <div class="documents-grid">
            <!-- Document 1 - Image CNI -->
            <div class="document-card">
                <div class="document-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="document-title">Carte d'identité</div>
                <div class="document-preview">
                    <img src="{{ Storage::url($user->documents->first()->document_path) }}" alt="Carte d'identité recto">
                </div>
                <div class="document-actions">
                    <button class="doc-btn doc-btn-view" onclick="viewDocument('cni-recto')">
                        <i class="fas fa-eye me-1"></i>Voir
                    </button>
                    <a href="#" class="doc-btn doc-btn-download">
                        <i class="fas fa-download me-1"></i>Télécharger
                    </a>
                </div>
            </div>

            <!-- Document 2 - PDF -->
            <div class="document-card">
                <div class="document-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div class="document-title">Justificatif de domicile</div>
                <div class="document-preview">
                    <iframe src="https://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf" type="application/pdf"></iframe>
                </div>
                <div class="document-actions">
                    <button class="doc-btn doc-btn-view" onclick="viewDocument('justificatif-domicile')">
                        <i class="fas fa-eye me-1"></i>Voir
                    </button>
                    <a href="#" class="doc-btn doc-btn-download">
                        <i class="fas fa-download me-1"></i>Télécharger
                    </a>
                </div>
            </div>

            <!-- Document 3 - Image photo -->
            <div class="document-card">
                <div class="document-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="document-title">Photo d'identité</div>
                <div class="document-preview">
                    <img src="https://via.placeholder.com/150x180/1cc88a/ffffff?text=PHOTO+ID" alt="Photo d'identité">
                </div>
                <div class="document-actions">
                    <button class="doc-btn doc-btn-view" onclick="viewDocument('photo-identite')">
                        <i class="fas fa-eye me-1"></i>Voir
                    </button>
                    <a href="#" class="doc-btn doc-btn-download">
                        <i class="fas fa-download me-1"></i>Télécharger
                    </a>
                </div>
            </div>

            <!-- Document 4 - PDF Contrat de travail -->
            <div class="document-card">
                <div class="document-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="document-title">Contrat de travail</div>
                <div class="document-preview">
                    <div class="text-center">
                        <i class="fas fa-file-pdf fa-3x text-muted"></i>
                        <br><small class="text-muted">Fichier PDF</small>
                    </div>
                </div>
                <div class="document-actions">
                    <button class="doc-btn doc-btn-view" onclick="viewDocument('contrat-travail')">
                        <i class="fas fa-eye me-1"></i>Voir
                    </button>
                    <a href="#" class="doc-btn doc-btn-download">
                        <i class="fas fa-download me-1"></i>Télécharger
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Section -->
    <div class="action-section">
        <h4><i class="fas fa-gavel me-2"></i>Actions de validation</h4>
        <div class="action-buttons">
            <button class="action-btn btn-approve" onclick="approveAccount()">
                <i class="fas fa-check me-2"></i>Valider le compte
            </button>
            <button class="action-btn btn-reject" onclick="toggleRejectForm()">
                <i class="fas fa-times me-2"></i>Rejeter le compte
            </button>
            <a href="{{ route("accountConfirmationIndex") }}" class="action-btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>

        <!-- Reject Form -->
        <div id="rejectForm" class="reject-form">
            <h6 class="text-dark mb-3">Motif de rejet</h6>
            <form method="POST" action="">
                <div class="mb-3">
                    <textarea class="form-control" name="rejection_reason" rows="4" placeholder="Veuillez préciser la raison du rejet du compte..." required></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>Confirmer le rejet
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="toggleRejectForm()">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentModalLabel">Aperçu du document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="documentModalBody">
                <!-- Document content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <a href="#" class="btn btn-primary" id="downloadDocumentBtn">
                    <i class="fas fa-download me-1"></i>Télécharger
                </a>
            </div>
        </div>
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

    // Functions for account validation page
    function viewDocument(docType) {
        const modal = new bootstrap.Modal(document.getElementById('documentModal'));
        const modalBody = document.getElementById('documentModalBody');
        const modalTitle = document.getElementById('documentModalLabel');
        
        // Simulate document loading based on type
        switch(docType) {
            case 'cni-recto':
                modalTitle.textContent = 'Carte d\'identité - Recto';
                modalBody.innerHTML = '<img src="{{Storage::url($user->documents->first()->document_path)}}" class="img-fluid" alt="CNI Recto">';
                break;
            case 'justificatif-domicile':
                modalTitle.textContent = 'Justificatif de domicile';
                modalBody.innerHTML = '<iframe src="https://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf" width="100%" height="600px"></iframe>';
                break;
            case 'photo-identite':
                modalTitle.textContent = 'Photo d\'identité';
                modalBody.innerHTML = '<div class="text-center"><img src="https://via.placeholder.com/300x360/1cc88a/ffffff?text=PHOTO+IDENTITE" class="img-fluid" alt="Photo identité" style="max-height: 600px;"></div>';
                break;
            case 'contrat-travail':
                modalTitle.textContent = 'Contrat de travail';
                modalBody.innerHTML = '<iframe src="https://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf" width="100%" height="600px"></iframe>';
                break;
            default:
                modalBody.innerHTML = '<p>Document non disponible.</p>';
        }
        
        modal.show();
    }

    function toggleRejectForm() {
        const form = document.getElementById('rejectForm');
        form.classList.toggle('show');
    }

    function approveAccount() {
        if (confirm('Êtes-vous sûr de vouloir valider ce compte ?')) {
            // Simulate approval
            alert('Le compte a été validé avec succès !');
            window.location.href = 'account-confirmation-index.html';
        }
    }
</script>

@endsection