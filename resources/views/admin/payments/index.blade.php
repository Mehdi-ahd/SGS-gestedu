
@extends('layouts.app')

@section('title', 'Gestion des Paiements')

@section('styles')
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

    .payment-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: all 0.3s;
        margin-bottom: 1rem;
    }

    .payment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.25);
    }

    .payment-header {
        background: linear-gradient(135deg, var(--primary-color), var(--info-color));
        color: white;
        border-radius: 0.75rem 0.75rem 0 0;
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

    .filter-controls {
        display: flex;
        gap: 1rem;
        align-items: end;
        flex-wrap: wrap;
    }

    .no-payments {
        text-align: center;
        color: var(--dark-color);
        padding: 2rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Paiements</h1>
        <div>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Enregistrer un paiement
            </a>
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
        <div class="filter-controls">
            <div>
                <label class="form-label">Année scolaire</label>
                <select id="filterYear" class="form-select" data-filter="year">
                    <option value="">Toutes les années</option>
                    @for($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}-{{ $year + 1 }}">{{ $year }}-{{ $year + 1 }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="form-label">Niveau d'étude</label>
                <select id="filterLevel" class="form-select" data-filter="level">
                    <option value="">Tous les niveaux</option>
                    @foreach($studyLevels as $level)
                        <option value="{{ $level->specification }}">{{ $level->specification }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Type de frais</label>
                <select id="filterFeeType" class="form-select" data-filter="fee_type">
                    <option value="">Tous les types</option>
                    <option value="inscription">Frais d'inscription</option>
                    <option value="reinscription">Frais de réinscription</option>
                    <option value="scolarite">Frais de scolarité</option>
                </select>
            </div>
            <div>
                <label class="form-label">Trimestre</label>
                <select id="filterTrimester" class="form-select" data-filter="trimester">
                    <option value="">Tous les trimestres</option>
                    @foreach($yearSessions as $session)
                        <option value="{{ $session->id }}">{{ $session->session_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button class="btn btn-secondary" onclick="clearFilters()">
                    <i class="fas fa-times me-1"></i>Effacer
                </button>
            </div>
        </div>
    </div>

    <!-- Payments List -->
    <div id="paymentsContainer">
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="d-flex justify-content-center mt-4">
        <!-- Pagination will be inserted here -->
    </div>
</div>
@endsection

@section('scripts')
<script>
let allPayments = [];
let filteredPayments = [];
let currentPage = 1;
const itemsPerPage = 20;

// Charger les paiements
async function loadPayments() {
    try {
        const response = await fetch('{{ route("admin.payments.data") }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            allPayments = data.payments;
            filteredPayments = [...allPayments];
            displayPayments();
        } else {
            showError('Erreur lors du chargement des paiements');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors du chargement des paiements');
    }
}

// Afficher les paiements
function displayPayments() {
    const container = document.getElementById('paymentsContainer');
    
    if (filteredPayments.length === 0) {
        container.innerHTML = '<div class="no-payments"><i class="fas fa-inbox fa-3x mb-3"></i><p>Aucun paiement trouvé</p></div>';
        return;
    }

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paymentsToShow = filteredPayments.slice(startIndex, endIndex);

    let html = '';
    paymentsToShow.forEach(payment => {
        html += createPaymentCard(payment);
    });

    container.innerHTML = html;
    updatePagination();
}

// Créer une carte de paiement
function createPaymentCard(payment) {
    return `
        <div class="payment-card" 
             data-year="${payment.enrollment?.school_year || ''}"
             data-level="${payment.enrollment?.study_level?.specification || ''}"
             data-fee-type="${payment.tuition?.fee_type || ''}"
             data-trimester="${payment.tuition?.year_session?.id || ''}">
            <div class="card">
                <div class="payment-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${payment.enrollment?.student?.first_name || ''} ${payment.enrollment?.student?.last_name || ''}</h6>
                            <small>${payment.enrollment?.study_level?.specification || 'N/A'} - ${payment.enrollment?.school_year || 'N/A'}</small>
                        </div>
                        <div class="text-end">
                            <div class="h5 mb-0">${formatAmount(payment.amount)} FCFA</div>
                            <small>${payment.tuition?.fee_type || 'N/A'}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="payment-details">
                        <div class="detail-item">
                            <i class="fas fa-book detail-icon"></i>
                            <div>
                                <div class="detail-label">Frais</div>
                                <div class="detail-value">${payment.tuition?.fee_type || 'N/A'}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar detail-icon"></i>
                            <div>
                                <div class="detail-label">Trimestre</div>
                                <div class="detail-value">${payment.tuition?.year_session?.session_name || 'N/A'}</div>
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
                                <div class="detail-value">${formatDate(payment.paid_at)}</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="status-badge status-${payment.status}">
                            ${getStatusName(payment.status)}
                        </span>
                        ${payment.transaction_id ? `<small class="text-muted">ID: ${payment.transaction_id}</small>` : ''}
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Filtrage
document.addEventListener('DOMContentLoaded', function() {
    loadPayments();

    // Écouter les changements de filtres
    document.querySelectorAll('[data-filter]').forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
});

function applyFilters() {
    const yearFilter = document.getElementById('filterYear').value;
    const levelFilter = document.getElementById('filterLevel').value;
    const feeTypeFilter = document.getElementById('filterFeeType').value;
    const trimesterFilter = document.getElementById('filterTrimester').value;

    filteredPayments = allPayments.filter(payment => {
        return (!yearFilter || (payment.enrollment?.school_year || '').includes(yearFilter)) &&
               (!levelFilter || (payment.enrollment?.study_level?.specification || '') === levelFilter) &&
               (!feeTypeFilter || (payment.tuition?.fee_type || '') === feeTypeFilter) &&
               (!trimesterFilter || (payment.tuition?.year_session?.id || '').toString() === trimesterFilter);
    });

    currentPage = 1;
    displayPayments();
}

function clearFilters() {
    document.querySelectorAll('[data-filter]').forEach(filter => {
        filter.value = '';
    });
    filteredPayments = [...allPayments];
    currentPage = 1;
    displayPayments();
}

// Pagination
function updatePagination() {
    const totalPages = Math.ceil(filteredPayments.length / itemsPerPage);
    const container = document.getElementById('paginationContainer');

    if (totalPages <= 1) {
        container.innerHTML = '';
        return;
    }

    let html = '<nav><ul class="pagination">';
    
    // Bouton précédent
    html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage - 1})">Précédent</button>
             </li>`;

    // Numéros de page
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                        <button class="page-link" onclick="changePage(${i})">${i}</button>
                     </li>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    // Bouton suivant
    html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage + 1})">Suivant</button>
             </li>`;

    html += '</ul></nav>';
    container.innerHTML = html;
}

function changePage(page) {
    const totalPages = Math.ceil(filteredPayments.length / itemsPerPage);
    if (page >= 1 && page <= totalPages) {
        currentPage = page;
        displayPayments();
    }
}

// Fonctions utilitaires
function formatAmount(amount) {
    return new Intl.NumberFormat('fr-FR').format(amount);
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString('fr-FR');
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
        'completed': 'Payé',
        'partial': 'Partiel',
        'pending': 'En attente',
        'failed': 'Échoué'
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
    }, 300);
}

function exportPayments() {
    // TODO: Implémenter l'export
    showSuccess('Fonctionnalité d\'export en cours de développement');
}
</script>
@endsection
