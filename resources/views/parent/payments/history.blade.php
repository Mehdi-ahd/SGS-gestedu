
@extends('layouts.parent')

@section('title', 'Historique des Paiements')

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
        background: linear-gradient(135deg, var(--success-color), #17a673);
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
        background-color: rgba(28, 200, 138, 0.1);
        color: var(--success-color);
    }

    .no-payments {
        text-align: center;
        color: var(--dark-color);
        padding: 3rem;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .summary-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        text-align: center;
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: white;
    }

    .summary-icon.total {
        background: linear-gradient(135deg, var(--primary-color), var(--info-color));
    }

    .summary-icon.count {
        background: linear-gradient(135deg, var(--success-color), #17a673);
    }

    .summary-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .summary-label {
        color: #6c757d;
        font-size: 0.9rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Historique des Paiements</h1>
        <div>
            <a href="{{ route('parent.payments.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Retour aux paiements
            </a>
            <button class="btn btn-success" onclick="exportHistory()">
                <i class="fas fa-file-excel me-2"></i>Exporter
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-icon total">
                <i class="fas fa-coins"></i>
            </div>
            <div class="summary-value">{{ number_format($payments->sum('amount'), 0, ',', ' ') }} FCFA</div>
            <div class="summary-label">Total payé</div>
        </div>
        <div class="summary-card">
            <div class="summary-icon count">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="summary-value">{{ $payments->total() }}</div>
            <div class="summary-label">Nombre de paiements</div>
        </div>
    </div>

    @if($payments->count() > 0)
        <!-- Payments List -->
        @foreach($payments as $payment)
        <div class="payment-card">
            <div class="card">
                <div class="payment-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $payment->enrollment->student->first_name }} {{ $payment->enrollment->student->last_name }}</h6>
                            <small>{{ $payment->enrollment->studyLevel->specification }} - {{ $payment->enrollment->school_year }}</small>
                        </div>
                        <div class="text-end">
                            <div class="h5 mb-0">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</div>
                            <small>{{ $payment->tuition->fee_type }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="payment-details">
                        <div class="detail-item">
                            <i class="fas fa-book detail-icon"></i>
                            <div>
                                <div class="detail-label">Type de frais</div>
                                <div class="detail-value">{{ $payment->tuition->fee_type }}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar detail-icon"></i>
                            <div>
                                <div class="detail-label">Trimestre</div>
                                <div class="detail-value">{{ $payment->tuition->yearSession->session_name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-credit-card detail-icon"></i>
                            <div>
                                <div class="detail-label">Méthode</div>
                                <div class="detail-value">{{ $payment->payment_method === 'online' ? 'KKiaPay' : ucfirst($payment->payment_method) }}</div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-day detail-icon"></i>
                            <div>
                                <div class="detail-label">Date de paiement</div>
                                <div class="detail-value">{{ $payment->paid_at->format('d/m/Y à H:i') }}</div>
                            </div>
                        </div>
                        @if($payment->transaction_id)
                        <div class="detail-item">
                            <i class="fas fa-hashtag detail-icon"></i>
                            <div>
                                <div class="detail-label">Numéro de transaction</div>
                                <div class="detail-value">{{ $payment->transaction_id }}</div>
                            </div>
                        </div>
                        @endif
                        @if($payment->notes)
                        <div class="detail-item">
                            <i class="fas fa-sticky-note detail-icon"></i>
                            <div>
                                <div class="detail-label">Notes</div>
                                <div class="detail-value">{{ $payment->notes }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="status-badge">
                            <i class="fas fa-check-circle me-1"></i>Payé
                        </span>
                        <small class="text-muted">
                            Enregistré le {{ $payment->created_at->format('d/m/Y à H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $payments->links() }}
        </div>
    @else
        <div class="no-payments">
            <i class="fas fa-receipt fa-3x mb-3 text-muted"></i>
            <h5>Aucun paiement effectué</h5>
            <p class="text-muted">Vous n'avez encore effectué aucun paiement.</p>
            <a href="{{ route('parent.payments.index') }}" class="btn btn-primary">
                <i class="fas fa-credit-card me-2"></i>Effectuer un paiement
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function exportHistory() {
    // TODO: Implémenter l'export de l'historique
    alert('Fonctionnalité d\'export en cours de développement');
}
</script>
@endsection
