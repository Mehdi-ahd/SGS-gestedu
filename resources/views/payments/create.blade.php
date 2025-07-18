@extends('layouts.app')

@section('title', 'Créer un type de frais')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Créer un type de frais</h1>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="">Types de frais</a></li>
                <li class="breadcrumb-item active" aria-current="page">Créer</li>
            </ol>
        </nav>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-money-bill-wave me-2"></i>
                        Informations du type de frais
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route("payments.store")}}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="study_level_id" class="form-label">Niveau d'étude <span class="text-danger">*</span></label>
                                <select class="form-select @error('study_level_id') is-invalid @enderror" id="study_level_id" name="study_level_id" required>
                                    <option value="" selected disabled>Sélectionner un niveau</option>
                                    @foreach ($study_levels as $study_level)
                                        <option value="{{ $study_level->id }}" {{ old('study_level_id') == $study_level->id ? 'selected' : '' }}>
                                            {{ $study_level->specification }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('study_level_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="year_session_id" class="form-label">Trimestre concerné <span class="text-danger">*</span></label>
                                <select class="form-select @error('year_session_id') is-invalid @enderror" id="year_session_id" name="year_session_id" required>
                                    <option value="" selected disabled>Sélectionner une session de l'année</option>
                                    @foreach ($year_sessions as $year_session)
                                        <option value="{{ $year_session->id }}" {{ old('year_session_id') == $year_session->id ? 'selected' : '' }}>
                                            {{ $year_session->denomination }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('year_session_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="fee_name" class="form-label">Motif du paiement <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fee_name') is-invalid @enderror" id="fee_name" name="fee_name" value="{{ old('fee_name') }}" placeholder="Ex: Frais de scolarité, Frais d'inscription..." required>
                                @error('fee_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="fee_type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('fee_type') is-invalid @enderror" id="fee_type" name="fee_type" required>
                                    <option value="" selected disabled>Sélectionner</option>
                                    <option value="frais_inscription" {{ old('fee_type') == 'frais_inscription' ? 'selected' : '' }}>Frais d'inscription</option>
                                    <option value="frais_reinscription" {{ old('fee_type') == 'frais_reinscription' ? 'selected' : '' }}>Frais de réinscription</option>
                                    <option value="frais_scolarite" {{ old('fee_type') == 'frais_scolarite' ? 'selected' : '' }}>Frais de scolarité</option>
                                    <option value="frais_examen" {{ old('fee_type') == 'frais_examen' ? 'selected' : '' }}>Frais d'examen</option>
                                    <option value="frais_transport" {{ old('fee_type') == 'frais_transport' ? 'selected' : '' }}>Frais de transport</option>
                                    <option value="frais_cantine" {{ old('fee_type') == 'frais_cantine' ? 'selected' : '' }}>Frais de cantine</option>
                                    <option value="frais_equipement" {{ old('fee_type') == 'frais_equipement' ? 'selected' : '' }}>Frais d'équipement</option>
                                    <option value="autres" {{ old('fee_type') == 'autres' ? 'selected' : '' }}>Autres</option>
                                </select>
                                @error('fee_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Montant <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" min="0" step="0.01" required>
                                    <span class="input-group-text">FCFA</span>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label">Date limite de paiement <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="payment_frequency" class="form-label">Fréquence de paiement <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_frequency') is-invalid @enderror" id="payment_frequency" name="payment_frequency" required>
                                    <option value="" selected disabled>Sélectionner</option>
                                    <option value="unique" {{ old('payment_frequency') == 'unique' ? 'selected' : '' }}>Paiement unique</option>
                                    <option value="mensuel" {{ old('payment_frequency') == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                                    <option value="trimestriel" {{ old('payment_frequency') == 'trimestriel' ? 'selected' : '' }}>Trimestriel</option>
                                    <option value="semestriel" {{ old('payment_frequency') == 'semestriel' ? 'selected' : '' }}>Semestriel</option>
                                    <option value="annuel" {{ old('payment_frequency') == 'annuel' ? 'selected' : '' }}>Annuel</option>
                                </select>
                                @error('payment_frequency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="is_mandatory" class="form-label">Obligatoire</label>
                                <select class="form-select @error('is_mandatory') is-invalid @enderror" id="is_mandatory" name="is_mandatory">
                                    <option value="oui" {{ old('is_mandatory', 'oui') == 'oui' ? 'selected' : '' }}>Oui</option>
                                    <option value="non" {{ old('is_mandatory') == 'non' ? 'selected' : '' }}>Non</option>
                                </select>
                                @error('is_mandatory')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Description détaillée du frais...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Activer ce type de frais
                            </label>
                        </div> --}}
                        
                        <div class="d-flex justify-content-between">
                            <a href="" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>
                                Créer le type de frais
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Guide de création
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Niveau d'étude :</strong> Sélectionnez le niveau concerné
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Motif :</strong> Motif à renseigner lors du paiement
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Montant :</strong> Montant exact en FCFA
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Date limite :</strong> Date limite pour le paiement
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Fréquence :</strong> À quelle fréquence ce frais doit être payé
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Attention
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <i class="fas fa-exclamation-circle text-warning me-2"></i>
                        Une fois créé, ce type de frais sera visible par tous les parents du niveau sélectionné.
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-exclamation-circle text-warning me-2"></i>
                        Vérifiez bien les informations avant de valider.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-génération du nom du frais basé sur le type sélectionné
    const feeTypeSelect = document.getElementById('fee_type');
    const feeNameInput = document.getElementById('fee_name');
    
    feeTypeSelect.addEventListener('change', function() {
        if (!feeNameInput.value) {
            const typeNames = {
                'frais_inscription': 'Frais d\'inscription',
                'frais_scolarite': 'Frais de scolarité',
                'frais_examen': 'Frais d\'examen',
                'frais_transport': 'Frais de transport',
                'frais_cantine': 'Frais de cantine',
                'frais_equipement': 'Frais d\'équipement',
                'autres': 'Autres frais'
            };
            
            feeNameInput.value = typeNames[this.value] || '';
        }
    });
    
    // Validation du montant
    const amountInput = document.getElementById('amount');
    amountInput.addEventListener('input', function() {
        if (this.value < 0) {
            this.value = 0;
        }
    });
    
    // Validation de la date limite
    const dueDateInput = document.getElementById('due_date');
    const today = new Date().toISOString().split('T')[0];
    dueDateInput.min = today;
});
</script>
@endsection
