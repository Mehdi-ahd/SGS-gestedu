
@extends('layouts.parent')

@section('title', 'Paiements')

@section('styles')
<style>
    .child-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .child-card:hover {
        transform: translateY(-5px);
    }

    .child-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .child-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .child-avatar {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .child-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .detail-item {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }

    .detail-label {
        font-size: 0.8rem;
        opacity: 0.8;
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-size: 1rem;
        font-weight: bold;
    }

    .total-amount {
        font-size: 1.5rem;
        font-weight: bold;
        color: #FFD700;
    }

    .inscription-type {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        background: rgba(255,255,255,0.2);
    }

    .no-children {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .payment-modal .modal-content {
        border-radius: 15px;
    }

    .payment-summary {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .tuition-item {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.5rem;
        border-left: 4px solid #667eea;
    }

    .tuition-amount {
        font-weight: bold;
        color: #28a745;
    }

    .session-header {
        background: #667eea;
        color: white;
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-weight: bold;
    }

    .btn-pay {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 500;
        transition: transform 0.2s;
    }

    .btn-pay:hover {
        transform: translateY(-2px);
        color: white;
    }

    .btn-pay:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-credit-card me-2"></i>Paiements des frais scolaires
        </h1>
        <div>
            <span class="badge bg-info me-2">Année scolaire: {{ date('Y') }}-{{ date('Y') + 1 }}</span>
            <a href="{{ route('parent.payments.history') }}" class="btn btn-outline-primary">
                <i class="fas fa-history me-1"></i>Historique
            </a>
        </div>
    </div>

    <div class="row" id="childrenContainer">
        <div class="col-12 text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal de paiement -->
<div class="modal fade payment-modal" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-credit-card me-2"></i>Paiement des frais scolaires
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="payment-content">
                    <!-- Le contenu sera chargé ici -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-pay" id="proceed-payment" style="display: none;">
                    <i class="fas fa-lock me-1"></i>Procéder au paiement
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadValidatedInscriptions();
});

async function loadValidatedInscriptions() {
    try {
        const currentYear = `${new Date().getFullYear()}-${new Date().getFullYear() + 1}`;
        const response = await fetch(`/parent/payments/validated-inscriptions?year=${currentYear}`);
        const data = await response.json();

        if (data.success) {
            displayChildren(data.inscriptions);
        } else {
            document.getElementById('childrenContainer').innerHTML = 
                '<div class="col-12"><div class="no-children"><i class="fas fa-exclamation-circle fa-3x mb-3 text-muted"></i><h5>Erreur</h5><p class="text-muted">Impossible de charger les inscriptions validées.</p></div></div>';
        }
    } catch (error) {
        console.error('Erreur:', error);
        document.getElementById('childrenContainer').innerHTML = 
            '<div class="col-12"><div class="no-children"><i class="fas fa-exclamation-circle fa-3x mb-3 text-muted"></i><h5>Erreur</h5><p class="text-muted">Erreur lors du chargement des données.</p></div></div>';
    }
}

function displayChildren(inscriptions) {
    const container = document.getElementById('childrenContainer');

    if (inscriptions.length === 0) {
        container.innerHTML = 
            '<div class="col-12"><div class="no-children"><i class="fas fa-user-graduate fa-3x mb-3 text-muted"></i><h5>Aucune inscription validée</h5><p class="text-muted">Aucune inscription validée pour l\'année scolaire en cours.</p></div></div>';
        return;
    }

    let html = '';
    inscriptions.forEach(inscription => {
        const isReinscription = inscription.student.has_previous_completed_inscription;
        
        html += `
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="child-card" onclick="openPaymentModal(${inscription.id})">
                    <div class="child-header">
                        <div class="child-info">
                            <div class="child-avatar">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div>
                                <h4 class="mb-1">${inscription.student.firstname} ${inscription.student.lastname}</h4>
                                <span class="inscription-type">
                                    ${isReinscription ? 'Réinscription' : 'Inscription'}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="child-details">
                        <div class="detail-item">
                            <div class="detail-label">Niveau d'étude</div>
                            <div class="detail-value">${inscription.study_level.specification}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Groupe</div>
                            <div class="detail-value">${inscription.group ? inscription.group.id : 'Non assigné'}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Année scolaire</div>
                            <div class="detail-value">${inscription.school_year_id}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Total des frais</div>
                            <div class="detail-value total-amount">${new Intl.NumberFormat('fr-FR').format(inscription.total_tuitions)} FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

async function openPaymentModal(inscriptionId) {
    try {
        // Afficher le modal avec un spinner
        document.getElementById('payment-content').innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Chargement des informations de paiement...</span>
                </div>
            </div>
        `;
        
        const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
        modal.show();

        // Charger les détails de paiement
        const response = await fetch(`/parent/payments/details/${inscriptionId}`);
        const data = await response.json();

        if (data.success) {
            displayPaymentDetails(data);
        } else {
            document.getElementById('payment-content').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    ${data.message || 'Erreur lors du chargement des détails de paiement'}
                </div>
            `;
        }
    } catch (error) {
        console.error('Erreur:', error);
        document.getElementById('payment-content').innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Erreur lors du chargement des informations de paiement
            </div>
        `;
    }
}

function displayPaymentDetails(data) {
    const { inscription, current_session, tuitions, total_paid, session_total } = data;
    
    let html = `
        <div class="payment-summary">
            <h6><strong>Élève:</strong> ${inscription.student.firstname} ${inscription.student.lastname}</h6>
            <p><strong>Niveau:</strong> ${inscription.study_level.specification} | <strong>Année:</strong> ${inscription.school_year_id}</p>
            <p><strong>Montant déjà payé:</strong> <span class="text-success">${new Intl.NumberFormat('fr-FR').format(total_paid)} FCFA</span></p>
        </div>

        <div class="session-header">
            Session actuelle: ${current_session.denomination}
            <small class="float-end">Total session: ${new Intl.NumberFormat('fr-FR').format(session_total)} FCFA</small>
        </div>

        <div class="tuitions-list">
    `;

    if (tuitions.length > 0) {
        tuitions.forEach(tuition => {
            html += `
                <div class="tuition-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${tuition.motif}</strong>
                            <br>
                            <small class="text-muted">${tuition.type}</small>
                        </div>
                        <div class="tuition-amount">
                            ${new Intl.NumberFormat('fr-FR').format(tuition.amount)} FCFA
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += `
            </div>
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                Vous devez payer l'intégralité des frais de cette session avant de pouvoir passer à la suivante.
            </div>
        `;

        // Stocker les données pour le paiement
        window.currentPaymentData = {
            inscriptionId: inscription.id,
            sessionId: current_session.id,
            tuitions: tuitions,
            totalAmount: session_total - total_paid
        };

        document.getElementById('proceed-payment').style.display = 'inline-block';
    } else {
        html += `
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                Tous les frais de cette session ont été payés. Vous pouvez passer à la session suivante.
            </div>
        </div>`;
        
        document.getElementById('proceed-payment').style.display = 'none';
    }

    document.getElementById('payment-content').innerHTML = html;
}

document.getElementById('proceed-payment').addEventListener('click', function() {
    if (window.currentPaymentData) {
        initiateKKiaPayPayment(window.currentPaymentData);
    }
});

function initiateKKiaPayPayment(paymentData) {
    // Cette fonction sera implémentée lors de l'intégration KKiaPay
    alert(`Redirection vers KKiaPay pour le paiement de ${new Intl.NumberFormat('fr-FR').format(paymentData.totalAmount)} FCFA`);
    console.log('Données de paiement:', paymentData);
}
</script>
@endsection
