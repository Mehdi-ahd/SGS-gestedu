
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>GestEdu - Vérification d'identité</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
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
      background: linear-gradient(135deg, var(--light-color) 0%, #e2e6ea 100%);
      min-height: 100vh;
    }

    .verification-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 2rem 1rem;
    }

    .verification-card {
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.08);
      overflow: hidden;
      border: none;
    }

    .verification-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
      color: white;
      padding: 2.5rem 2rem 2rem;
      text-align: center;
    }

    .logo {
      margin-bottom: 1.5rem;
    }

    .logo-icon {
      font-size: 2.5rem;
      margin-right: 1rem;
    }

    .logo-text {
      font-size: 1.8rem;
      font-weight: 700;
    }

    .verification-header h2 {
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .verification-header p {
      opacity: 0.9;
      margin-bottom: 0;
    }

    /* Indicateur d'étapes */
    .step-indicator {
      padding: 2rem;
      background: #fff;
      border-bottom: 1px solid #eaecf4;
    }

    .step-progress {
      position: relative;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 1rem;
    }

    .step-line {
      position: absolute;
      top: 35px;
      left: 35px;
      right: 35px;
      height: 3px;
      background: #e3e6f0;
      z-index: 1;
    }

    .step-line-progress {
      height: 100%;
      background: linear-gradient(90deg, var(--primary-color), var(--info-color));
      transition: width 0.4s ease;
      border-radius: 1.5px;
    }

    .step {
      position: relative;
      z-index: 2;
      text-align: center;
      flex: 0 0 auto;
    }

    .step-circle {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 0.5rem;
      font-weight: 700;
      font-size: 1.3rem;
      background: #e3e6f0;
      color: #858796;
      transition: all 0.3s ease;
      border: 3px solid #e3e6f0;
    }

    .step.active .step-circle {
      background: var(--primary-color);
      color: white;
      border-color: var(--primary-color);
      transform: scale(1.1);
    }

    .step.completed .step-circle {
      background: var(--success-color);
      color: white;
      border-color: var(--success-color);
    }

    .step.completed .step-circle i {
      font-size: 1.4rem;
    }

    .step-label {
      font-size: 0.9rem;
      font-weight: 600;
      color: #858796;
      max-width: 120px;
      line-height: 1.3;
    }

    .step.active .step-label {
      color: var(--primary-color);
    }

    .step.completed .step-label {
      color: var(--success-color);
    }

    /* Contenu du formulaire */
    .verification-form {
      padding: 2.5rem;
    }

    .step-content {
      display: none;
    }

    .step-content.active {
      display: block;
      animation: fadeInSlide 0.4s ease-out;
    }

    @keyframes fadeInSlide {
      from {
        opacity: 0;
        transform: translateX(20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .step-title {
      color: var(--dark-color);
      font-weight: 700;
      margin-bottom: 1.5rem;
      font-size: 1.4rem;
    }

    .form-label {
      font-weight: 600;
      color: var(--dark-color);
      margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
      border: 2px solid #e3e6f0;
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .error-message {
      color: var(--danger-color);
      font-size: 0.85rem;
      margin-top: 0.25rem;
      display: none;
    }

    .document-fields {
      background: var(--light-color);
      border-radius: 0.75rem;
      padding: 1.5rem;
      margin-top: 1rem;
      border: 2px dashed #d1d3e2;
      transition: all 0.3s ease;
    }

    .document-fields.active {
      border-color: var(--primary-color);
      background: rgba(78, 115, 223, 0.05);
    }

    .file-upload {
      border: 2px dashed #d1d3e2;
      border-radius: 0.75rem;
      padding: 2rem;
      text-align: center;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .file-upload:hover {
      border-color: var(--primary-color);
      background: rgba(78, 115, 223, 0.05);
    }

    .file-upload.dragover {
      border-color: var(--success-color);
      background: rgba(28, 200, 138, 0.1);
    }

    .file-upload-icon {
      font-size: 2.5rem;
      color: var(--info-color);
      margin-bottom: 1rem;
    }

    /* Récapitulatif */
    .summary-section {
      background: linear-gradient(135deg, var(--light-color) 0%, #f1f3f6 100%);
      border-radius: 0.75rem;
      padding: 2rem;
      border: 1px solid #e3e6f0;
    }

    .summary-group {
      background: #fff;
      border-radius: 0.5rem;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      border-left: 4px solid var(--primary-color);
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .summary-group:last-child {
      margin-bottom: 0;
    }

    .summary-group h6 {
      color: var(--primary-color);
      font-weight: 700;
      margin-bottom: 1rem;
      font-size: 1.1rem;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.5rem 0;
      border-bottom: 1px solid #f1f3f6;
    }

    .summary-item:last-child {
      border-bottom: none;
    }

    .summary-label {
      font-weight: 600;
      color: var(--dark-color);
      flex: 0 0 40%;
    }

    .summary-value {
      color: #5a5c69;
      flex: 1;
      text-align: right;
    }

    /* Navigation */
    .form-navigation {
      padding: 2rem;
      background: var(--light-color);
      border-top: 1px solid #e3e6f0;
    }

    .btn {
      padding: 0.75rem 2rem;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
      border: none;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 0.5rem 1rem rgba(78, 115, 223, 0.4);
    }

    .btn-success {
      background: linear-gradient(135deg, var(--success-color) 0%, #17a673 100%);
      border: none;
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 0.5rem 1rem rgba(28, 200, 138, 0.4);
    }

    .btn-outline-secondary {
      border: 2px solid #d1d3e2;
      color: var(--dark-color);
    }

    .btn-outline-secondary:hover {
      background: var(--dark-color);
      border-color: var(--dark-color);
    }

    /* Styles pour intl-tel-input */
    .iti {
      width: 100%;
    }

    .iti__country-list {
      z-index: 9999;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .verification-container {
        padding: 1rem;
      }

      .verification-header {
        padding: 2rem 1rem 1.5rem;
      }

      .verification-form {
        padding: 1.5rem;
      }

      .step-indicator {
        padding: 1rem;
      }

      .step-label {
        font-size: 0.8rem;
        max-width: 80px;
      }

      .step-circle {
        width: 60px;
        height: 60px;
        font-size: 1.1rem;
      }

      .summary-item {
        flex-direction: column;
        align-items: flex-start;
      }

      .summary-value {
        text-align: left;
        margin-top: 0.25rem;
      }
    }
  </style>
</head>

<body>
  <div class="verification-container">
    <div class="verification-card">
      <!-- En-tête -->
      <div class="verification-header">
        <div class="logo">
          <i class="fas fa-graduation-cap logo-icon"></i>
          <span class="logo-text">GestEdu</span>
        </div>
        <h2>Vérification d'identité</h2>
        <p>Veuillez compléter les informations suivantes pour vérifier votre identité</p>
      </div>

      <!-- Indicateur d'étapes -->
      <div class="step-indicator">
        <div class="step-progress">
          <div class="step-line">
            <div class="step-line-progress" id="progressBar"></div>
          </div>
          <div class="step active" data-step="1">
            <div class="step-circle">1</div>
            <div class="step-label">Informations générales</div>
          </div>
          <div class="step" data-step="2">
            <div class="step-circle">2</div>
            <div class="step-label">Contact</div>
          </div>
          <div class="step" data-step="3">
            <div class="step-circle">3</div>
            <div class="step-label">Documents officiels</div>
          </div>
          <div class="step" data-step="4">
            <div class="step-circle">4</div>
            <div class="step-label">Récapitulatif</div>
          </div>
        </div>
      </div>

      <form class="verification-form" id="verificationForm" method="POST" action="/api/parent-verification" enctype="multipart/form-data">
        @csrf
        <!-- Étape 1: Informations générales -->
        <div class="step-content active" id="step1">
          <h3 class="step-title"><i class="fas fa-user me-2"></i>Informations générales</h3>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="lastname" class="form-label">Nom de famille *</label>
              <input type="text" class="form-control" id="lastname" name="lastname" maxlength="30" value="{{ $user->lastname }}" required>
              <div class="error-message" id="lastnameError"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="firstname" class="form-label">Prénom *</label>
              <input type="text" class="form-control" id="firstname" name="firstname" value="{{ $user->firstname }}" maxlength="30" required>
              <div class="error-message" id="firstnameError"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="birthday" class="form-label">Date de naissance *</label>
              <input type="date" class="form-control" id="birthday" name="birthday" required>
              <div class="error-message" id="birthdayError"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="sex" class="form-label">Sexe</label>
              <select class="form-select" id="sex" name="sex">
                <option value="">Sélectionnez votre sexe</option>
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
              </select>
              <div class="error-message" id="sexError"></div>
            </div>
          </div>

          <div class="mb-3">
            <label for="home_address" class="form-label">Adresse de résidence *</label>
            <textarea class="form-control" id="home_address" name="home_address" rows="3" placeholder="Entrez votre adresse complète" maxlength="100" required></textarea>
            <div class="error-message" id="home_addressError"></div>
          </div>
        </div>

        <!-- Étape 2: Informations de contact -->
        <div class="step-content" id="step2">
          <h3 class="step-title"><i class="fas fa-phone me-2"></i>Informations de contact</h3>
          
          <div class="mb-3">
            <label for="phone" class="form-label">Numéro de téléphone principal *</label>
            <input type="tel" class="form-control" id="phone" name="phone" maxlength="12" required>
            <input type="hidden" id="phoneCountry" name="phoneCountry">
            <div class="error-message" id="phoneError"></div>
          </div>

          <div class="mb-3">
            <label for="second_phone" class="form-label">Second numéro de téléphone</label>
            <input type="tel" class="form-control" id="second_phone" name="second_phone" maxlength="12">
            <input type="hidden" id="second_phoneCountry" name="second_phoneCountry">
            <div class="error-message" id="second_phoneError"></div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail *</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="votre.email@exemple.com" value="{{ $user->email }}" maxlength="100" required>
            <div class="error-message" id="emailError"></div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="job" class="form-label">Profession</label>
              <input type="text" class="form-control" id="job" name="job" maxlength="30">
              <div class="error-message" id="jobError"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="work_address" class="form-label">Adresse de travail</label>
              <input type="text" class="form-control" id="work_address" name="work_address" maxlength="30">
              <div class="error-message" id="work_addressError"></div>
            </div>
          </div>
        </div>

        <!-- Étape 3: Informations officielles -->
        <div class="step-content" id="step3">
          <h3 class="step-title"><i class="fas fa-id-card me-2"></i>Documents officiels</h3>
          
          <div class="mb-4">
            <label for="documentType" class="form-label">Type de document d'identité *</label>
            <select class="form-select" id="documentType" name="documentType" required>
              <option value="">Sélectionnez un type de document</option>
              <option value="cip">CIP (Carte d'Identité de Présence)</option>
              <option value="cni">Carte d'Identité Nationale</option>
              <option value="passport">Passeport</option>
            </select>
            <div class="error-message" id="documentTypeError"></div>
          </div>

          <!-- Champs dynamiques selon le type de document -->
          <div class="document-fields" id="documentFields" style="display: none;">
            <!-- Champs pour CIP et CNI -->
            <div id="cipCniFields" style="display: none;">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="npi" class="form-label">Numéro d'Identification Personnel (NPI) *</label>
                  <input type="text" class="form-control" id="npi" name="npi">
                  <div class="error-message" id="npiError"></div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="documentNumber" class="form-label">Numéro de la pièce *</label>
                  <input type="text" class="form-control" id="documentNumber" name="documentNumber">
                  <div class="error-message" id="documentNumberError"></div>
                </div>
              </div>
            </div>

            <!-- Champs pour Passeport -->
            <div id="passportFields" style="display: none;">
              <div class="mb-3">
                <label for="documentNumber" class="form-label">Numéro de passeport *</label>
                <input type="text" class="form-control" id="documentNumber" name="documentNumber">
                <div class="error-message" id="passportNumberError"></div>
              </div>
            </div>

            <!-- Upload de fichier -->
            <div class="mb-3">
              <label class="form-label">Document numérisé *</label>
              <div class="file-upload" id="fileUpload">
                <div class="file-upload-icon">
                  <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <p class="mb-2"><strong>Cliquez pour sélectionner</strong> ou glissez-déposez votre fichier</p>
                <p class="text-muted small mb-0">Formats acceptés: JPG, PNG, PDF (max. 5MB)</p>
                <input type="file" class="d-none" id="documentFile" name="documentFile" accept=".jpg,.jpeg,.png,.pdf">
              </div>
              <div class="error-message" id="documentFileError"></div>
              <div id="filePreview" class="mt-3" style="display: none;">
                <div class="alert alert-success">
                  <i class="fas fa-check-circle me-2"></i>
                  <span id="fileName"></span>
                  <button type="button" class="btn btn-sm btn-outline-danger ms-2" id="removeFile">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Étape 4: Récapitulatif -->
        <div class="step-content" id="step4">
          <h3 class="step-title"><i class="fas fa-check-circle me-2"></i>Récapitulatif</h3>
          <input type="hidden" name="user_id" value="{{$user->id }}">
          <div class="summary-section">
            <div class="summary-group">
              <h6><i class="fas fa-user me-2"></i>Informations personnelles</h6>
              <div class="summary-item">
                <span class="summary-label">Nom complet:</span>
                <span class="summary-value" id="summaryFullName"></span>
              </div>
              <div class="summary-item">
                <span class="summary-label">Date de naissance:</span>
                <span class="summary-value" id="summaryBirthday"></span>
              </div>
              <div class="summary-item">
                <span class="summary-label">Sexe:</span>
                <span class="summary-value" id="summarySex"></span>
              </div>
              <div class="summary-item">
                <span class="summary-label">Adresse:</span>
                <span class="summary-value" id="summaryAddress"></span>
              </div>
            </div>

            <div class="summary-group">
              <h6><i class="fas fa-phone me-2"></i>Informations de contact</h6>
              <div class="summary-item">
                <span class="summary-label">Téléphone principal:</span>
                <span class="summary-value" id="summaryMainPhone"></span>
              </div>
              <div class="summary-item" id="summarySecondPhoneItem" style="display: none;">
                <span class="summary-label">Second téléphone:</span>
                <span class="summary-value" id="summarySecondPhone"></span>
              </div>
              <div class="summary-item">
                <span class="summary-label">Email:</span>
                <span class="summary-value" id="summaryEmail"></span>
              </div>
              <div class="summary-item" id="summaryJobItem" style="display: none;">
                <span class="summary-label">Profession:</span>
                <span class="summary-value" id="summaryJob"></span>
              </div>
              <div class="summary-item" id="summaryWorkAddressItem" style="display: none;">
                <span class="summary-label">Adresse de travail:</span>
                <span class="summary-value" id="summaryWorkAddress"></span>
              </div>
            </div>

            <div class="summary-group">
              <h6><i class="fas fa-id-card me-2"></i>Document d'identité</h6>
              <div class="summary-item">
                <span class="summary-label">Type de document:</span>
                <span class="summary-value" id="summaryDocumentType"></span>
              </div>
              <div class="summary-item" id="summaryNpiItem" style="display: none;">
                <span class="summary-label">NPI:</span>
                <span class="summary-value" id="summaryNpi"></span>
              </div>
              <div class="summary-item" id="summaryDocNumberItem" style="display: none;">
                <span class="summary-label">Numéro de document:</span>
                <span class="summary-value" id="summaryDocNumber"></span>
              </div>
              <div class="summary-item">
                <span class="summary-label">Fichier joint:</span>
                <span class="summary-value" id="summaryFileName"></span>
              </div>
            </div>
          </div>

          <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
            <label class="form-check-label" for="terms">
              J'accepte les <a href="#" class="text-decoration-none">conditions d'utilisation</a> et certifie que toutes les informations fournies sont exactes.
            </label>
            <div class="error-message" id="termsError"></div>
          </div>
        </div>
      </form>

      <!-- Navigation -->
      <div class="form-navigation d-flex justify-content-between">
        <button type="button" class="btn btn-outline-secondary" id="prevBtn" style="display: none;">
          <i class="fas fa-arrow-left me-2"></i>Précédent
        </button>
        <div class="ms-auto">
          <button type="button" class="btn btn-primary" id="nextBtn">
            Suivant<i class="fas fa-arrow-right ms-2"></i>
          </button>
          <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;" form="verificationForm">
            <i class="fas fa-check me-2"></i>Soumettre ma demande
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
  
  <script>
    class VerificationForm {
      constructor() {
        this.currentStep = 1;
        this.totalSteps = 4;
        this.formData = {};
        this.phoneInputs = {};
        
        this.init();
      }

      init() {
        this.bindEvents();
        this.updateProgress();
        this.initPhoneInputs();
      }

      initPhoneInputs() {
        // Initialiser intl-tel-input pour le téléphone principal
        this.phoneInputs.phone = window.intlTelInput(document.querySelector("#phone"), {
          initialCountry: "bj",
          preferredCountries: ["bj", "cm", "fr", "sn", "ci"],
          utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
        });

        // Initialiser intl-tel-input pour le second téléphone
        this.phoneInputs.second_phone = window.intlTelInput(document.querySelector("#second_phone"), {
          initialCountry: "bj",
          preferredCountries: ["bj", "cm", "fr", "sn", "ci"],
          utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
        });

        // Événements pour capturer les codes pays
        document.getElementById('phone').addEventListener('countrychange', () => {
          document.getElementById('phoneCountry').value = this.phoneInputs.phone.getSelectedCountryData().iso2;
        });

        document.getElementById('second_phone').addEventListener('countrychange', () => {
          document.getElementById('second_phoneCountry').value = this.phoneInputs.second_phone.getSelectedCountryData().iso2;
        });
      }

      bindEvents() {
        // Navigation buttons
        document.getElementById('nextBtn').addEventListener('click', () => this.nextStep());
        document.getElementById('prevBtn').addEventListener('click', () => this.prevStep());
        
        // Document type change
        document.getElementById('documentType').addEventListener('change', (e) => this.handleDocumentTypeChange(e));
        
        // File upload
        this.setupFileUpload();
        
        // Form submission
        document.getElementById('verificationForm').addEventListener('submit', (e) => this.handleSubmit(e));

        // Real-time validation
        document.querySelectorAll('input, select, textarea').forEach(field => {
          field.addEventListener('blur', () => this.validateField(field));
          field.addEventListener('input', () => this.clearError(field));
        });
      }

      handleDocumentTypeChange(e) {
        const documentType = e.target.value;
        const documentFields = document.getElementById('documentFields');
        const cipCniFields = document.getElementById('cipCniFields');
        const passportFields = document.getElementById('passportFields');
        
        if (documentType) {
          documentFields.style.display = 'block';
          documentFields.classList.add('active');
          
          if (documentType === 'cip' || documentType === 'cni') {
            cipCniFields.style.display = 'block';
            passportFields.style.display = 'none';
            
            // Make CIP/CNI fields required
            document.getElementById('npi').required = true;
            document.getElementById('documentNumber').required = true;
            document.getElementById('passportNumber').required = false;
          } else if (documentType === 'passport') {
            cipCniFields.style.display = 'none';
            passportFields.style.display = 'block';
            
            // Make passport field required
            document.getElementById('npi').required = false;
            document.getElementById('documentNumber').required = false;
            document.getElementById('passportNumber').required = true;
          }
        } else {
          documentFields.style.display = 'none';
          documentFields.classList.remove('active');
        }
      }

      nextStep() {
        if (this.validateStep(this.currentStep)) {
          this.saveStepData();
          
          if (this.currentStep < this.totalSteps) {
            this.currentStep++;
            this.showStep(this.currentStep);
            this.updateProgress();
            
            if (this.currentStep === this.totalSteps) {
              this.updateSummary();
            }
          }
        }
      }

      prevStep() {
        if (this.currentStep > 1) {
          this.currentStep--;
          this.showStep(this.currentStep);
          this.updateProgress();
        }
      }

      showStep(step) {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(content => {
          content.classList.remove('active');
        });
        
        // Show current step
        document.getElementById(`step${step}`).classList.add('active');
        
        // Update navigation buttons
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        
        prevBtn.style.display = step > 1 ? 'block' : 'none';
        nextBtn.style.display = step < this.totalSteps ? 'block' : 'none';
        submitBtn.style.display = step === this.totalSteps ? 'block' : 'none';
      }

      updateProgress() {
        const progress = ((this.currentStep - 1) / (this.totalSteps - 1)) * 100;
        document.getElementById('progressBar').style.width = `${progress}%`;
        
        // Update step indicators
        document.querySelectorAll('.step').forEach((step, index) => {
          const stepNumber = index + 1;
          const stepElement = step.querySelector('.step-circle');
          
          step.classList.remove('active', 'completed');
          
          if (stepNumber < this.currentStep) {
            step.classList.add('completed');
            stepElement.innerHTML = '<i class="fas fa-check"></i>';
          } else if (stepNumber === this.currentStep) {
            step.classList.add('active');
            stepElement.textContent = stepNumber;
          } else {
            stepElement.textContent = stepNumber;
          }
        });
      }

      saveStepData() {
        const currentStepElement = document.getElementById(`step${this.currentStep}`);
        const inputs = currentStepElement.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
          if (input.type === 'file') {
            if (input.files.length > 0) {
              this.formData[input.name] = input.files[0];
            }
          } else if (input.type === 'checkbox') {
            this.formData[input.name] = input.checked;
          } else {
            this.formData[input.name] = input.value;
          }
        });

        // Sauvegarder les numéros complets avec indicatifs
        if (this.currentStep === 2) {
          if (this.phoneInputs.phone) {
            this.formData.phone = this.phoneInputs.phone.getNumber();
            this.formData.phoneCountry = this.phoneInputs.phone.getSelectedCountryData().iso2;
          }
          if (this.phoneInputs.second_phone && this.phoneInputs.second_phone.getNumber()) {
            this.formData.second_phone = this.phoneInputs.second_phone.getNumber();
            this.formData.second_phoneCountry = this.phoneInputs.second_phone.getSelectedCountryData().iso2;
          }
        }
      }

      validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        
        // Clear previous errors
        this.clearError(field);
        
        // Check if required field is empty
        if (field.required && !value) {
          this.showError(field, 'Ce champ est obligatoire');
          return false;
        }
        
        // Specific validations
        switch (fieldName) {
          case 'email':
            if (value && !this.isValidEmail(value)) {
              this.showError(field, 'Format d\'email invalide');
              return false;
            }
            break;
          case 'npi':
            if (value && !this.isValidNPI(value)) {
              this.showError(field, 'Format NPI invalide');
              return false;
            }
            break;
        }
        
        return true;
      }

      isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
      }

      isValidNPI(npi) {
        // NPI should be 11 digits
        const npiRegex = /^\d{11}$/;
        return npiRegex.test(npi);
      }

      showError(field, message) {
        const errorElement = document.getElementById(field.name + 'Error');
        if (errorElement) {
          errorElement.textContent = message;
          errorElement.style.display = 'block';
        }
        field.classList.add('is-invalid');
      }

      clearError(field) {
        const errorElement = document.getElementById(field.name + 'Error');
        if (errorElement) {
          errorElement.style.display = 'none';
        }
        field.classList.remove('is-invalid');
      }

      validateStep(step) {
        let isValid = true;
        const stepElement = document.getElementById(`step${step}`);
        const requiredFields = stepElement.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
          if (!this.validateField(field)) {
            isValid = false;
          }
        });

        // Special validation for step 3 (document upload)
        if (step === 3) {
          const documentType = document.getElementById('documentType').value;
          const fileInput = document.getElementById('documentFile');
          
          if (documentType && !fileInput.files.length) {
            this.showError(fileInput, 'Veuillez joindre votre document d\'identité');
            isValid = false;
          }
        }

        return isValid;
      }

      setupFileUpload() {
        const fileUpload = document.getElementById('fileUpload');
        const fileInput = document.getElementById('documentFile');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const removeFile = document.getElementById('removeFile');

        fileUpload.addEventListener('click', () => fileInput.click());
        
        fileUpload.addEventListener('dragover', (e) => {
          e.preventDefault();
          fileUpload.classList.add('dragover');
        });
        
        fileUpload.addEventListener('dragleave', () => {
          fileUpload.classList.remove('dragover');
        });
        
        fileUpload.addEventListener('drop', (e) => {
          e.preventDefault();
          fileUpload.classList.remove('dragover');
          
          const files = e.dataTransfer.files;
          if (files.length > 0) {
            this.handleFileSelect(files[0]);
          }
        });
        
        fileInput.addEventListener('change', (e) => {
          if (e.target.files.length > 0) {
            this.handleFileSelect(e.target.files[0]);
          }
        });
        
        removeFile.addEventListener('click', () => {
          fileInput.value = '';
          filePreview.style.display = 'none';
          this.clearError(fileInput);
        });
      }

      handleFileSelect(file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
          this.showError(document.getElementById('documentFile'), 'Format de fichier non supporté');
          return;
        }

        if (file.size > maxSize) {
          this.showError(document.getElementById('documentFile'), 'La taille du fichier ne doit pas dépasser 5MB');
          return;
        }

        document.getElementById('fileName').textContent = file.name;
        document.getElementById('filePreview').style.display = 'block';
        this.clearError(document.getElementById('documentFile'));
      }

      updateSummary() {
        // Personal information
        document.getElementById('summaryFullName').textContent = 
          `${this.formData.firstname || ''} ${this.formData.lastname || ''}`.trim();
        document.getElementById('summaryBirthday').textContent = this.formData.birthday || '';
        document.getElementById('summarySex').textContent = 
          this.formData.sex === 'M' ? 'Masculin' : this.formData.sex === 'F' ? 'Féminin' : '';
        document.getElementById('summaryAddress').textContent = this.formData.home_address || '';
        
        // Contact information
        document.getElementById('summaryMainPhone').textContent = this.formData.phone || '';
        document.getElementById('summaryEmail').textContent = this.formData.email || '';
        
        // Second phone (optional)
        const secondPhoneItem = document.getElementById('summarySecondPhoneItem');
        if (this.formData.second_phone) {
          document.getElementById('summarySecondPhone').textContent = this.formData.second_phone;
          secondPhoneItem.style.display = 'flex';
        } else {
          secondPhoneItem.style.display = 'none';
        }

        // Job information (optional)
        const jobItem = document.getElementById('summaryJobItem');
        if (this.formData.job) {
          document.getElementById('summaryJob').textContent = this.formData.job;
          jobItem.style.display = 'flex';
        } else {
          jobItem.style.display = 'none';
        }

        // Work address (optional)
        const workAddressItem = document.getElementById('summaryWorkAddressItem');
        if (this.formData.work_address) {
          document.getElementById('summaryWorkAddress').textContent = this.formData.work_address;
          workAddressItem.style.display = 'flex';
        } else {
          workAddressItem.style.display = 'none';
        }
        
        // Document information
        const documentTypes = {
          'cip': 'CIP (Carte d\'Identitification de Personnel)',
          'cni': 'Carte d\'Identité Nationale',
          'passport': 'Passeport'
        };
        document.getElementById('summaryDocumentType').textContent = 
          documentTypes[this.formData.documentType] || '';
        
        // Document fields
        const npiItem = document.getElementById('summaryNpiItem');
        const docNumberItem = document.getElementById('summaryDocNumberItem');
        
        if (this.formData.documentType === 'cip' || this.formData.documentType === 'cni') {
          document.getElementById('summaryNpi').textContent = this.formData.npi || '';
          document.getElementById('summaryDocNumber').textContent = this.formData.documentNumber || '';
          npiItem.style.display = 'flex';
          docNumberItem.style.display = 'flex';
        } else if (this.formData.documentType === 'passport') {
          document.getElementById('summaryDocNumber').textContent = this.formData.passportNumber || '';
          npiItem.style.display = 'none';
          docNumberItem.style.display = 'flex';
        } else {
          npiItem.style.display = 'none';
          docNumberItem.style.display = 'none';
        }
        
        // File information
        document.getElementById('summaryFileName').textContent = 
          this.formData.documentFile ? this.formData.documentFile.name : 'Aucun fichier sélectionné';
      }

      handleSubmit(e) {
        e.preventDefault();
        
        if (!this.validateStep(this.currentStep)) {
          return;
        }
        
        this.saveStepData();
        
        // Prepare form data for submission
        const formData = new FormData();
        
        // Add all form fields
        Object.keys(this.formData).forEach(key => {
          if (this.formData[key] !== null && this.formData[key] !== undefined) {
            formData.append(key, this.formData[key]);
          }
        });

        // Submit form
        this.submitForm(formData);
      }

      async submitForm(formData) {
        try {
          
          const response = await fetch('/verification', {
            
            method: 'POST',
            body: formData,
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });

          const responseBody = await response.json(); // Récupérer le corps de la réponse

          console.log("Statut de la réponse:", response.status); // Pour déboguer
          console.log("Données retournées :", responseBody); // Pour déboguer

          if (response.ok) {
            this.showSuccessMessage();
          } else {
            throw new Error('Erreur lors de la soumission: ' + responseBody.message);
          }
        } catch (error) {
          console.error('Erreur:', error);
          alert('Une erreur est survenue lors de la soumission du formulaire. Veuillez réessayer.');
        }
      }

      showSuccessMessage() {
        // Replace form content with success message
        const verificationCard = document.querySelector('.verification-card');
        verificationCard.innerHTML = `
          <div class="text-center p-5">
            <div class="mb-4">
              <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
            </div>
            <h3 class="text-success mb-3">Demande envoyée avec succès !</h3>
            <p class="text-muted mb-4">
              Votre demande de vérification d'identité a été soumise avec succès. 
              Vous recevrez une confirmation par email dans les prochaines minutes.
            </p>
            <div class="alert alert-info">
              <i class="fas fa-info-circle me-2"></i>
              <strong>Prochaines étapes :</strong> Notre équipe examinera votre demande sous 24-48h ouvrables.
            </div>
            <a href="{{ route("dashboard") }}">
              <button class="btn btn-primary" >
                <i class="fas fa-home me-2"></i>Retour à l'accuei
              </button>  
            </a>
          </div>
        `;
      }
    }

    // Initialize the form when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
      new VerificationForm();
    });
  </script>
</body>

</html>
