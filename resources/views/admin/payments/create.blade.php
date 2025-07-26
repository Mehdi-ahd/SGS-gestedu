
@extends('layouts.app')

@section('title', 'Enregistrer un paiement')

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

    .search-section {
        background-color: white;
        border-radius: 0.35rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .student-result {
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .student-result:hover {
        background-color: var(--light-color);
        border-color: var(--primary-color);
        transform: translateY(-1px);
    }

    .student-result.selected {
        background-color: rgba(78, 115, 223, 0.1);
        border-color: var(--primary-color);
    }

    .payment-form-section {
        background-color: white;
        border-radius: 0.35rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        display: none;
    }

    .payment-form-section.show {
        display: block;
    }

    .student-info {
        background-color: var(--light-color);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .fee-option {
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .fee-option:hover {
        background-color: var(--light-color);
        border-color: var(--primary-color);
    }

    .fee-option.selected {
        background-color: rgba(78, 115, 223, 0.1);
        border-color: var(--primary-color);
    }

    .fee-option.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background-color: #f8f9fa;
    }

    .fee-title {
        font-weight: 600;
        color: var(--dark-color);
    }

    .fee-amount {
        color: var(--primary-color);
        font-weight: 600;
    }

    .fee-status {
        font-size: 0.8rem;
        padding: 0.2rem 0.5rem;
        border-radius: 0.25rem;
    }

    .status-available {
        background-color: rgba(28, 200, 138, 0.1);
        color: var(--success-color);
    }

    .status-blocked {
        background-color: rgba(231, 74, 59, 0.1);
        color: var(--danger-color);
    }

    .validation-error {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Enregistrer un paiement</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
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

    <!-- Student Search Section -->
    <div class="search-section">
        <h5 class="mb-3"><i class="fas fa-search me-2"></i>Rechercher un élève</h5>
        <div class="row">
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" id="studentSearch" class="form-control" 
                           placeholder="Tapez le nom, prénom ou numéro d'élève...">
                    <button class="btn btn-primary" type="button" onclick="searchStudent()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Search Results -->
        <div id="searchResults" class="mt-3" style="display: none;">
            <h6>Résultats de recherche :</h6>
            <div id="studentsList"></div>
        </div>
    </div>

    <!-- Payment Form Section -->
    <div id="paymentFormSection" class="payment-form-section">
        <h5 class="mb-3"><i class="fas fa-credit-card me-2"></i>Détails du paiement</h5>
        
        <!-- Student Info -->
        <div id="studentInfo" class="student-info">
            <!-- Student information will be displayed here -->
        </div>

        <form id="paymentForm">
            <input type="hidden" id="selectedEnrollmentId" name="enrollment_id">
            <input type="hidden" id="selectedTuitionId" name="tuition_id">

            <!-- Available Fees -->
            <div class="mb-4">
                <h6>Frais disponibles :</h6>
                <div id="availableFees">
                    <!-- Available fees will be displayed here -->
                </div>
            </div>

            <!-- Payment Details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Montant à payer <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="amount" name="amount" 
                                   min="0" step="0.01" required readonly>
                            <span class="input-group-text">FCFA</span>
                        </div>
                        <div id="amountError" class="validation-error" style="display: none;"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Méthode de paiement <span class="text-danger">*</span></label>
                        <select class="form-select" id="paymentMethod" name="payment_method" required>
                            <option value="">Sélectionner une méthode</option>
                            <option value="cash">Espèces</option>
                            <option value="bank_transfer">Virement bancaire</option>
                            <option value="check">Chèque</option>
                            <option value="mobile_money">Mobile Money</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="transactionId" class="form-label">Numéro de transaction</label>
                        <input type="text" class="form-control" id="transactionId" name="transaction_id" 
                               placeholder="Optionnel">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="paymentDate" class="form-label">Date de paiement <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="paymentDate" name="payment_date" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes (optionnel)</label>
                <textarea class="form-control" id="notes" name="notes" rows="3" 
                          placeholder="Commentaires ou notes sur le paiement..."></textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                    <i class="fas fa-times me-1"></i>Annuler
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Enregistrer le paiement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let selectedEnrollment = null;
let availableFees = [];

// Recherche d'élève
async function searchStudent() {
    const search = document.getElementById('studentSearch').value.trim();
    
    if (search.length < 2) {
        showError('Veuillez saisir au moins 2 caractères');
        return;
    }

    try {
        const response = await fetch('{{ route("admin.payments.search-student") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ search: search })
        });

        const data = await response.json();

        if (data.success) {
            displaySearchResults(data.enrollments);
        } else {
            showError(data.message || 'Aucun élève trouvé');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors de la recherche');
    }
}

// Afficher les résultats de recherche
function displaySearchResults(enrollments) {
    const container = document.getElementById('studentsList');
    const resultsSection = document.getElementById('searchResults');

    if (enrollments.length === 0) {
        container.innerHTML = '<p class="text-muted">Aucun élève trouvé</p>';
    } else {
        let html = '';
        enrollments.forEach(enrollment => {
            html += `
                <div class="student-result" onclick="selectStudent(${JSON.stringify(enrollment).replace(/"/g, '&quot;')})">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${enrollment.student.first_name} ${enrollment.student.last_name}</h6>
                            <small class="text-muted">
                                ${enrollment.study_level.specification} - ${enrollment.school_year}
                            </small>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">ID: ${enrollment.student.student_id}</small>
                        </div>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    resultsSection.style.display = 'block';
}

// Sélectionner un élève
async function selectStudent(enrollment) {
    selectedEnrollment = enrollment;
    
    // Mettre à jour l'affichage
    document.querySelectorAll('.student-result').forEach(el => el.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    
    // Afficher les informations de l'élève
    displayStudentInfo(enrollment);
    
    // Charger les frais disponibles
    await loadAvailableFees(enrollment.id);
    
    // Afficher le formulaire de paiement
    document.getElementById('paymentFormSection').classList.add('show');
    document.getElementById('selectedEnrollmentId').value = enrollment.id;
}

// Afficher les informations de l'élève
function displayStudentInfo(enrollment) {
    const container = document.getElementById('studentInfo');
    container.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6><i class="fas fa-user me-2"></i>Informations de l'élève</h6>
                <p class="mb-1"><strong>Nom complet:</strong> ${enrollment.student.first_name} ${enrollment.student.last_name}</p>
                <p class="mb-1"><strong>Numéro d'élève:</strong> ${enrollment.student.student_id}</p>
            </div>
            <div class="col-md-6">
                <h6><i class="fas fa-graduation-cap me-2"></i>Inscription</h6>
                <p class="mb-1"><strong>Niveau:</strong> ${enrollment.study_level.specification}</p>
                <p class="mb-1"><strong>Année scolaire:</strong> ${enrollment.school_year}</p>
            </div>
        </div>
    `;
}

// Charger les frais disponibles
async function loadAvailableFees(enrollmentId) {
    try {
        const response = await fetch(`{{ route("admin.payments.available-fees") }}?enrollment_id=${enrollmentId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            availableFees = data.fees;
            displayAvailableFees(data.fees);
        } else {
            showError(data.message || 'Erreur lors du chargement des frais');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors du chargement des frais');
    }
}

// Afficher les frais disponibles
function displayAvailableFees(fees) {
    const container = document.getElementById('availableFees');
    
    if (fees.length === 0) {
        container.innerHTML = '<p class="text-muted">Aucun frais disponible pour cet élève</p>';
        return;
    }

    let html = '';
    fees.forEach(fee => {
        const isDisabled = !fee.can_pay;
        html += `
            <div class="fee-option ${isDisabled ? 'disabled' : ''}" 
                 onclick="${isDisabled ? '' : `selectFee(${JSON.stringify(fee).replace(/"/g, '&quot;')})`}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fee-title">${fee.fee_type}</div>
                        <small class="text-muted">${fee.year_session?.session_name || 'N/A'}</small>
                    </div>
                    <div class="text-end">
                        <div class="fee-amount">${formatAmount(fee.amount)} FCFA</div>
                        <div class="fee-status ${fee.can_pay ? 'status-available' : 'status-blocked'}">
                            ${fee.can_pay ? 'Disponible' : fee.reason || 'Bloqué'}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

// Sélectionner un frais
function selectFee(fee) {
    // Mettre à jour l'affichage
    document.querySelectorAll('.fee-option').forEach(el => el.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    
    // Remplir les champs du formulaire
    document.getElementById('selectedTuitionId').value = fee.id;
    document.getElementById('amount').value = fee.amount;
}

// Soumission du formulaire
document.getElementById('paymentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("admin.payments.store") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showSuccess(data.message || 'Paiement enregistré avec succès');
            resetForm();
        } else {
            showError(data.message || 'Erreur lors de l\'enregistrement');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showError('Erreur lors de l\'enregistrement');
    }
});

// Recherche en temps réel
document.getElementById('studentSearch').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        searchStudent();
    }
});

// Réinitialiser le formulaire
function resetForm() {
    document.getElementById('paymentForm').reset();
    document.getElementById('paymentFormSection').classList.remove('show');
    document.getElementById('searchResults').style.display = 'none';
    document.getElementById('studentSearch').value = '';
    selectedEnrollment = null;
    availableFees = [];
}

// Fonctions utilitaires
function formatAmount(amount) {
    return new Intl.NumberFormat('fr-FR').format(amount);
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
</script>
@endsection
