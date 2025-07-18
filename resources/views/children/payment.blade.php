
@extends('layouts.parent')

@section('title', 'Paiement des frais scolaires')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="h3 mb-2 mb-md-0 text-gray-800">
            <i class="fas fa-credit-card me-2"></i>
            Paiement des frais scolaires
        </h1>
        
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentSelectionModal">
                <i class="fas fa-plus me-2"></i>
                Nouveau paiement
            </button>
            <a href="{{ route('parent.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour
            </a>
        </div>
    </div>

    <!-- Formulaire de paiement (caché par défaut) -->
    <div id="paymentFormContainer" style="display: none;">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user-graduate me-2"></i>
                            Informations de l'élève
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="paymentForm" method="POST" action="{{ route('parent.payment.store') }}">
                            @csrf
                            <input type="hidden" id="enrollment_id" name="enrollment_id">
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nom complet</label>
                                    <input type="text" id="student_name" class="form-control" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Niveau d'étude</label>
                                    <input type="text" id="study_level" class="form-control" disabled>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Année scolaire</label>
                                    <input type="text" id="school_year" class="form-control" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Statut inscription</label>
                                    <input type="text" id="enrollment_status" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            Détails du paiement
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="payment_type" class="form-label">Motif de paiement <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_type') is-invalid @enderror" id="payment_type" name="payment_type" required>
                                    <option value="" selected disabled>Sélectionner le motif</option>
                                    <option value="frais_inscription">Frais d'inscription</option>
                                    <option value="frais_scolarite">Frais de scolarité</option>
                                    <option value="frais_examen">Frais d'examen</option>
                                    <option value="frais_transport">Frais de transport</option>
                                    <option value="frais_cantine">Frais de cantine</option>
                                    <option value="frais_equipement">Frais d'équipement</option>
                                    <option value="autres">Autres</option>
                                </select>
                                @error('payment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Montant à payer <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" min="0" step="0.01" required>
                                    <span class="input-group-text">FCFA</span>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="payment_method" class="form-label">Moyen de paiement <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                    <option value="" selected disabled>Sélectionner le moyen</option>
                                    <option value="especes">Espèces</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="virement_bancaire">Virement bancaire</option>
                                    <option value="cheque">Chèque</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="payment_date" class="form-label">Date de paiement <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reference" class="form-label">Référence de paiement</label>
                            <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" placeholder="Numéro de transaction, de chèque, etc.">
                            @error('reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (optionnel)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Informations supplémentaires..."></textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="hidePaymentForm()">
                                <i class="fas fa-times me-2"></i>
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-credit-card me-2"></i>
                                Effectuer le paiement
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
                            Informations importantes
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Vérifiez les informations avant validation
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Conservez le reçu de paiement
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Le paiement sera validé par l'administration
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Un reçu vous sera envoyé par email
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de sélection d'élève -->
<div class="modal fade" id="studentSelectionModal" tabindex="-1" aria-labelledby="studentSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentSelectionModalLabel">
                    <i class="fas fa-user-graduate me-2"></i>
                    Sélectionner un élève
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="studentsLoader" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2">Chargement de vos enfants...</p>
                </div>
                <div id="studentsContainer" style="display: none;">
                    <div class="row" id="studentsList">
                        <!-- Les élèves seront chargés ici via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('studentSelectionModal');
    
    modal.addEventListener('show.bs.modal', function() {
        loadStudents();
    });
    
    function loadStudents() {
        fetch(`/parent/api/students/{{ Auth::id() }}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('studentsLoader').style.display = 'none';
                document.getElementById('studentsContainer').style.display = 'block';
                
                const container = document.getElementById('studentsList');
                container.innerHTML = '';
                
                if (data.students.length === 0) {
                    container.innerHTML = `
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Aucun élève inscrit trouvé.
                            </div>
                        </div>
                    `;
                    return;
                }
                
                data.students.forEach(enrollment => {
                    const studentCard = `
                        <div class="col-md-6 mb-3">
                            <div class="card student-card h-100" style="cursor: pointer;" onclick="selectStudent(${enrollment.id}, '${enrollment.student.firstname} ${enrollment.student.lastname}', '${enrollment.study_level.specification}', '${enrollment.school_year}', '${enrollment.status}')">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-title mb-1">${enrollment.student.firstname} ${enrollment.student.lastname}</h6>
                                            <p class="card-text text-muted mb-1">
                                                <small><i class="fas fa-graduation-cap me-1"></i>${enrollment.study_level.specification}</small>
                                            </p>
                                            <p class="card-text text-muted mb-0">
                                                <small><i class="fas fa-calendar me-1"></i>${enrollment.school_year}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    container.innerHTML += studentCard;
                });
            })
            .catch(error => {
                document.getElementById('studentsLoader').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Erreur lors du chargement des élèves.
                    </div>
                `;
            });
    }
    
    window.selectStudent = function(enrollmentId, studentName, studyLevel, schoolYear, status) {
        // Remplir les champs du formulaire
        document.getElementById('enrollment_id').value = enrollmentId;
        document.getElementById('student_name').value = studentName;
        document.getElementById('study_level').value = studyLevel;
        document.getElementById('school_year').value = schoolYear;
        document.getElementById('enrollment_status').value = status;
        
        // Fermer la modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('studentSelectionModal'));
        modal.hide();
        
        // Afficher le formulaire de paiement
        document.getElementById('paymentFormContainer').style.display = 'block';
        
        // Faire défiler vers le formulaire
        document.getElementById('paymentFormContainer').scrollIntoView({ behavior: 'smooth' });
    };
    
    window.hidePaymentForm = function() {
        document.getElementById('paymentFormContainer').style.display = 'none';
        document.getElementById('paymentForm').reset();
    };
    
    // Style hover pour les cartes d'élèves
    document.addEventListener('mouseover', function(e) {
        if (e.target.closest('.student-card')) {
            e.target.closest('.student-card').style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            e.target.closest('.student-card').style.transform = 'translateY(-2px)';
        }
    });
    
    document.addEventListener('mouseout', function(e) {
        if (e.target.closest('.student-card')) {
            e.target.closest('.student-card').style.boxShadow = '';
            e.target.closest('.student-card').style.transform = '';
        }
    });
});
</script>
@endsection
