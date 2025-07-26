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

    .fees-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .fee-card {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }

    .fee-amount {
        font-size: 1.25rem;
        font-weight: bold;
        color: #FFD700;
    }

    .btn-pay {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
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

    .no-children {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .payment-status {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-paid {
        background: #d4edda;
        color: #155724;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-available {
        background: #cce5ff;
        color: #004085;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-credit-card me-2"></i>Paiements des frais scolaires
        </h1>
        <a href="{{ route('parent.payments.history') }}" class="btn btn-outline-primary">
            <i class="fas fa-history me-1"></i>Historique
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            @if($inscriptions->count() > 0)
                @foreach($inscriptions as $inscription)
                <div class="child-card">
                    <div class="child-header">
                        <div class="child-info">
                            <div class="child-avatar">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div>
                                <h4 class="mb-1">{{ $inscription->student->firstname }} {{ $inscription->student->lastname }}</h4>
                                <p class="mb-0 opacity-75">
                                    {{ $inscription->study_level->specification }} - {{ $inscription->school_year_id }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="fees-grid" id="fees-{{ $inscription->id }}">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-children">
                    <i class="fas fa-user-graduate fa-3x mb-3 text-muted"></i>
                    <h5>Aucune inscription trouvée</h5>
                    <p class="text-muted">Aucun enfant inscrit pour l'année scolaire en cours.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de paiement -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-credit-card me-2"></i>Confirmer le paiement
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="payment-details">
                    <!-- Les détails du paiement seront chargés ici -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" id="confirm-payment">
                    <i class="fas fa-lock me-1"></i>Payer maintenant
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Charger les frais pour chaque inscription
    @foreach($inscriptions as $inscription)
        loadFeesForInscription({{ $inscription->id }});
    @endforeach
});

async function loadFeesForInscription(inscriptionId) {
    try {
        const response = await fetch(`/parent/payments/fees/${inscriptionId}`);
        const data = await response.json();

        if (data.success) {
            displayFees(inscriptionId, data.fees);
        } else {
            document.getElementById(`fees-${inscriptionId}`).innerHTML = 
                '<div class="text-center text-danger">Erreur lors du chargement des frais</div>';
        }
    } catch (error) {
        console.error('Erreur:', error);
        document.getElementById(`fees-${inscriptionId}`).innerHTML = 
            '<div class="text-center text-danger">Erreur lors du chargement des frais</div>';
    }
}

function displayFees(inscriptionId, fees) {
    const container = document.getElementById(`fees-${inscriptionId}`);

    if (fees.length === 0) {
        container.innerHTML = '<div class="text-center opacity-75">Aucun frais à payer pour le moment</div>';
        return;
    }

    let html = '';
    fees.forEach(fee => {
        html += `
            <div class="fee-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1">${fee.motif}</h6>
                        <small class="opacity-75">${fee.type}</small>
                    </div>
                    <span class="payment-status status-available">Disponible</span>
                </div>
                <div class="fee-amount mb-3">${new Intl.NumberFormat('fr-FR').format(fee.amount)} FCFA</div>
                <button class="btn btn-pay w-100" onclick="initiatePayment(${inscriptionId}, ${fee.tuition_id}, ${fee.amount}, '${fee.motif}')">
                    <i class="fas fa-credit-card me-1"></i>Payer
                </button>
            </div>
        `;
    });

    container.innerHTML = html;
}

function initiatePayment(inscriptionId, tuitionId, amount, motif) {
    // Afficher les détails du paiement dans la modal
    document.getElementById('payment-details').innerHTML = `
        <div class="mb-3">
            <strong>Frais à payer:</strong> ${motif}
        </div>
        <div class="mb-3">
            <strong>Montant:</strong> <span class="text-success fs-5">${new Intl.NumberFormat('fr-FR').format(amount)} FCFA</span>
        </div>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Vous allez être redirigé vers la plateforme de paiement sécurisée KKiaPay.
        </div>
    `;

    // Stocker les données de paiement
    window.currentPayment = {
        inscriptionId: inscriptionId,
        tuitionId: tuitionId,
        amount: amount,
        motif: motif
    };

    // Afficher la modal
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

document.getElementById('confirm-payment').addEventListener('click', async function() {
    if (!window.currentPayment) return;

    const button = this;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Traitement...';
    button.disabled = true;

    try {
        const response = await fetch('/parent/payments/initiate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                inscription_id: window.currentPayment.inscriptionId,
                tuition_id: window.currentPayment.tuitionId,
                amount: window.currentPayment.amount
            })
        });

        const data = await response.json();

        if (data.success) {
            // Rediriger vers KKiaPay (à implémenter)
            alert('Redirection vers KKiaPay...');
            // window.location.href = data.payment_url;
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'initiation du paiement');
    } finally {
        button.innerHTML = originalText;
        button.disabled = false;
        bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
    }
});
</script>
@endsection