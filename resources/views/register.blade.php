@extends('layouts.auth')

@section('title', 'Créer un compte')
@section('subtitle', 'Inscrivez-vous pour accéder à GestEdu')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="mb-3">
        <label for="name" class="form-label">Nom complet</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nom et prénom" required autofocus>
        </div>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="votre@email.com" required>
        </div>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 caractères" required>
            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retapez votre mot de passe" required>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="role" class="form-label">Type de compte</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="" selected disabled>Sélectionnez votre rôle</option>
                <option value="student">Étudiant</option>
                <option value="teacher">Enseignant</option>
                <option value="parent">Parent</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3 form-check">
        <input type="checkbox" name="terms" id="terms" class="form-check-input @error('terms') is-invalid @enderror" required>
        <label for="terms" class="form-check-label">J'accepte les <a href="#" class="text-decoration-none">conditions d'utilisation</a> et la <a href="#" class="text-decoration-none">politique de confidentialité</a></label>
        @error('terms')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i> Créer mon compte
        </button>
    </div>
    
    <div class="text-center">
        <p class="mb-0">
            Vous avez déjà un compte ? 
            <a href="{{ route('login') }}" class="text-decoration-none">Connectez-vous</a>
        </p>
    </div>
</form>
@endsection

@section('scripts')
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection