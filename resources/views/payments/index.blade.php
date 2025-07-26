@extends("layouts.app")

@section("title", "Gestion des Paiements")

@section("header_elements")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
    }

    body {
        font-family: 'Nunito', sans-serif;
        background-color: var(--light-color);
    }

    .payment-card {
        background: #fff;
        border-radius: 0.35rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: 1px solid #e3e6f0;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .payment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .25rem 2rem 0 rgba(58, 59, 69, 0.2);
    }

    .payment-header {
        background: linear-gradient(135deg, var(--primary-color), #6f42c1);
        color: white;
        padding: 1rem;
        border-radius: 0.35rem 0.35rem 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .payment-amount {
        font-size: 1.2rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
    }

    .payment-body {
        padding: 1rem;
    }

    .payment-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-icon {
        width: 16px;
        color: var(--primary-color);
    }

    .detail-label {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.85rem;
    }

    .detail-value {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-paye {
        background-color: rgba(28, 200, 138, 0.1);
        color: var(--success-color);
    }

    .status-partiel {
        background-color: rgba(246, 194, 62, 0.1);
        color: var(--warning-color);
    }

    .status-impaye {
        background-color: rgba(231, 74, 59, 0.1);
        color: var(--danger-color);
    }

    .filter-section {
        background-color: white;
        border-radius: 0.35rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .pagination-section {
        background-color: white;
        border-radius: 0.35rem;
        padding: 1rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-controls {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .pagination-info {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .btn-pagination {
        padding: 0.5rem 1rem;
        border: 1px solid #e3e6f0;
        background: white;
        color: var(--dark-color);
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-pagination:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-pagination.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-pagination:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 2rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: #fff;
        border-radius: 0.35rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .empty-icon {
        font-size: 4rem;
        color: #d1d3e2;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section("content")
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Paiements</h1>
        <div>
            <button class="btn btn-success" onclick="exportPayments()">
                <i class="fas fa-file-excel me-2"></i>Exporter
            </button>
        </div>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
        <i class="fas fa-check me-2"></i>
        <span id="successText"></span>
        <button type="button" class="btn-close" onclick="hideMessage('successMessage')"></button>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="alert alert-danger alert-dismissible fade" role="alert" style="display: none;">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <span id="errorText"></span>
        <button type="button" class="btn-close" onclick="hideMessage('errorMessage')"></button>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h6 class="mb-3"><i class="fas fa-filter me-2"></i>Filtres</h6>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label for="filter_study_level" class="form-label">Niveau d'étude</label>
                    <select class="form-select" id="filter_study_level" name="study_level_id">
                        <option value="">Tous les niveaux</option>
                        <!-- Options chargées dynamiquement -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_year_session" class="form-label">Session</label>
                    <select class="form-select" id="filter_year_session" name="year_session_id">
                        <option value="">Toutes les sessions</option>
                        <option value="1">1er Trimestre</option>
                        <option value="2">2e Trimestre</option>
                        <option value="3">3e Trimestre</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_school_year" class="form-label">Année scolaire</label>
                    <select class="form-select" id="filter_school_year" name="school_year_id">
                        <option value="">Toutes les années</option>
                        <!-- Options chargées dynamiquement -->
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-primary me-2" onclick="loadPayments(1)">
                        <i class="fas fa-sync-alt me-1"></i>Filtrer
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                        <i class="fas fa-times me-1"></i>Effacer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
        <p class="mt-2">Chargement des paiements...</p>
    </div>

    <!-- Payments Container -->
    <div id="paymentsContainer" class="row">
        <!-- Les paiements seront chargés ici -->
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="empty-state" style="display: none;">
        <i class="fas fa-credit-card empty-icon"></i>
        <h4 class="text-gray-600 mb-2">Aucun paiement trouvé</h4>
        <p class="text-gray-500">Aucun paiement ne correspond aux critères de recherche.</p>
    </div>

    <!-- Pagination Section -->
    <div id="paginationSection" class="pagination-section" style="display: none;">
        <div class="pagination-info" id="paginationInfo"></div>
        <div class="pagination-controls" id="paginationControls"></div>
    </div>
</div>
@endsection

@section("scripts")
<script>
let currentPage = 1;
let totalPages = 1;
let totalPayments = 0;

// Token CSRF pour les requêtes
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Charger les données au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    loadStudyLevels();
    loadSchoolYears();
    loadPayments(1);
});

// Charger les niveaux d'étude
async function loadStudyLevels() {
    try {
        const response = await fetch('/school-structure/study-level', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error('Erreur lors du chargement');

        const studyLevels = await response.json();
        const select = document.getElementById('filter_study_level');

        select.innerHTML = '<option value="">Tous les niveaux</option>' +
            studyLevels.map(level => `<option value="${level.id}">${level.specification}</option>`).join('');
    } catch (error) {
        console.error('Erreur:', error);
    }
}

// Charger les années scolaires
async function loadSchoolYears() {
    // Pour cet exemple, générer quelques années
    const currentYear = new Date().getFullYear();
    const years = [
        { id: `${currentYear}-${currentYear + 1}`, name: `${currentYear}-${currentYear + 1}` },
        { id: `${currentYear - 1}-${currentYear}`, name: `${currentYear - 1}-${currentYear}` },
        { id: `${currentYear - 2}-${currentYear - 1}`, name: `${currentYear - 2}-${currentYear - 1}` }
    ];

    const select = document.getElementById('filter_school_year');
    select.innerHTML = '<option value="">Toutes les années</option>' +
        years.map(year => `<option value="${year.id}" ${year.id === `${currentYear}-${currentYear + 1}` ? 'selected' : ''}>${year.name}</option>`).join('');
}

// Charger les paiements
async function loadPayments(page = 1) {
    showLoading(true);

    try {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);

        const params = new URLSearchParams();
        formData.forEach((value, key) => {
            if (value) params.append(key, value);
        });
        params.append('page', page);
        params.append('per_page', 20);

        const response = await fetch(`/payments?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error('Erreur lors du chargement');

        const data = await response.json();

        currentPage = data.current_page || 1;
        totalPages = data.last_page || 1;
        totalPayments = data.total || 0;

        displayPayments(data.data || []);
        updatePagination();

    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors du chargement des paiements');
        displayPayments([]);
    } finally {
        showLoading(false);
    }
}

// Afficher les paiements
function displayPayments(payments) {
    const container = document.getElementById('paymentsContainer');
    const emptyState = document.getElementById('emptyState');

    if (payments.length === 0) {
        container.style.display = 'none';
        emptyState.style.display = 'block';
        return;
    }

    container.style.display = 'flex';
    emptyState.style.display = 'none';

    container.innerHTML = payments.map(payment => `
        <div class="col-md-6 col-lg-4">
            <div class="payment-card">
                <div class="payment-header">
                    <div>
                        <h6 class="mb-1">${payment.student?.first_name || 'N/A'} ${payment.student?.last_name || ''}</h6>
                        <small>${payment.tuition?.motif || 'N/A'}</small>
                    </div>
                    <div class="payment-amount">${formatAmount(payment.amount)} FCFA</div>
                </div>
                <div class="payment-body">
                    <div class="payment-details">
                        <div class="detail-item">
                            <i class="fas fa-graduation-cap detail-icon"></i>
                            <div>
                                <div class="detail-label">Niveau</div>
                                <div class="detail-value">${payment.tuition?.study_level?.specification || 'N/A'}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar detail-icon"></i>
                            <div>
                                <div class="detail-label">Session</div>
                                <div class="detail-value">${getSessionName(payment.tuition?.year_session_id)}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-credit-card detail-icon"></i>
                            <div>
                                <div class="detail-label">Méthode</div>
                                <div class="detail-value">${getPaymentMethodName(payment.payment_method)}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-day detail-icon"></i>
                            <div>
                                <div class="detail-label">Date</div>
                                <div class="detail-value">${formatDate(payment.payment_date)}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-info-circle detail-icon"></i>
                            <div>
                                <div class="detail-label">Statut</div>
                                <div class="detail-value">
                                    <span class="status-badge status-${payment.status}">
                                        ${getStatusName(payment.status)}
                                    </span>
                                </div>
                            </div>
                        </div>
                        ${payment.transaction_id ? `
                        <div class="detail-item">
                            <i class="fas fa-hashtag detail-icon"></i>
                            <div>
                                <div class="detail-label">Transaction</div>
                                <div class="detail-value">${payment.transaction_id}</div>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

// Mettre à jour la pagination
function updatePagination() {
    const paginationSection = document.getElementById('paginationSection');
    const paginationInfo = document.getElementById('paginationInfo');
    const paginationControls = document.getElementById('paginationControls');

    if (totalPayments === 0) {
        paginationSection.style.display = 'none';
        return;
    }

    paginationSection.style.display = 'flex';

    const startItem = (currentPage - 1) * 20 + 1;
    const endItem = Math.min(currentPage * 20, totalPayments);

    paginationInfo.textContent = `Affichage de ${startItem} à ${endItem} sur ${totalPayments} paiements`;

    let controls = '';

    // Bouton précédent
    controls += `<button class="btn-pagination" onclick="loadPayments(${currentPage - 1})" ${currentPage <= 1 ? 'disabled' : ''}>
        <i class="fas fa-angle-left"></i> Précédent
    </button>`;

    // Numéros de pages
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {
        controls += `<button class="btn-pagination" onclick="loadPayments(1)">1</button>`;
        if (startPage > 2) {
            controls += `<span class="px-2">...</span>`;
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        controls += `<button class="btn-pagination ${i === currentPage ? 'active' : ''}" onclick="loadPayments(${i})">${i}</button>`;
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            controls += `<span class="px-2">...</span>`;
        }
        controls += `<button class="btn-pagination" onclick="loadPayments(${totalPages})">${totalPages}</button>`;
    }

    // Bouton suivant
    controls += `<button class="btn-pagination" onclick="loadPayments(${currentPage + 1})" ${currentPage >= totalPages ? 'disabled' : ''}>
        Suivant <i class="fas fa-angle-right"></i>
    </button>`;

    paginationControls.innerHTML = controls;
}

// Effacer les filtres
function clearFilters() {
    document.getElementById('filterForm').reset();
    loadSchoolYears(); // Recharger pour remettre la sélection par défaut
    loadPayments(1);
}

// Exporter les paiements
function exportPayments() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);

    const params = new URLSearchParams();
    formData.forEach((value, key) => {
        if (value) params.append(key, value);
    });
    params.append('export', 'excel');

    window.open(`/payments/export?${params.toString()}`, '_blank');
}

// Afficher/masquer le spinner de chargement
function showLoading(show) {
    const spinner = document.getElementById('loadingSpinner');
    const container = document.getElementById('paymentsContainer');
    const emptyState = document.getElementById('emptyState');

    if (show) {
        spinner.style.display = 'block';
        container.style.display = 'none';
        emptyState.style.display = 'none';
    } else {
        spinner.style.display = 'none';
    }
}

// Fonctions utilitaires
function formatAmount(amount) {
    return new Intl.NumberFormat('fr-FR').format(amount);
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR');
}

function getSessionName(sessionId) {
    const sessions = {
        1: '1er Trimestre',
        2: '2e Trimestre',
        3: '3e Trimestre'
    };
    return sessions[sessionId] || 'N/A';
}

function getPaymentMethodName(method) {
    const methods = {
        'cash': 'Espèces',
        'bank_transfer': 'Virement bancaire',
        'check': 'Chèque',
        'credit_card': 'Carte de crédit',
        'mobile_money': 'Mobile Money',
        'online': 'Paiement en ligne'
    };
    return methods[method] || method;
}

function getStatusName(status) {
    const statuses = {
        'paye': 'Payé',
        'partiel': 'Partiel',
        'impaye': 'Impayé',
        'en_attente': 'En attente'
    };
    return statuses[status] || status;
}

function showSuccess(message) {
    document.getElementById('successText').textContent = message;
    const alert = document.getElementById('successMessage');
    alert.style.display = 'block';
    alert.classList.add('show');

    setTimeout(() => {
        hideMessage('successMessage');
    }, 5000);
}

function showError(message) {
    document.getElementById('errorText').textContent = message;
    const alert = document.getElementById('errorMessage');
    alert.style.display = 'block';
    alert.classList.add('show');

    setTimeout(() => {
        hideMessage('errorMessage');
    }, 5000);
}

function hideMessage(elementId) {
    const alert = document.getElementById(elementId);
    alert.classList.remove('show');
    setTimeout(() => {
        alert.style.display = 'none';
    }, 150);
}
</script>
@endsection