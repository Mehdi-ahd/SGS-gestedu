
@extends('layouts.app')

@section('title', 'Gestion des invitations')

@section("header_elements")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des invitations</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invitationModal">
            <i class="fas fa-link me-1"></i>Générer un lien d'invitation
        </button>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tokens d'invitation actifs</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tokensTable">
                            <thead>
                                <tr>
                                    <th>Token</th>
                                    <th>Rôle</th>
                                    <th>Date d'expiration</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tokens ?? [] as $token)
                                <tr>
                                    <td>
                                        <code>{{ Str::limit($token->token, 20) }}...</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $token->role->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ $token->validity_period->format('d/m/Y à H:i') }}</td>
                                    <td>
                                        @if($token->isValid())
                                            <span class="badge bg-success">Valide</span>
                                        @else
                                            <span class="badge bg-danger">Expiré</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('{{ route('register.with.token', ['token' => $token->token]) }}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteToken('{{ $token->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun token d'invitation actif</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de génération d'invitation -->
<div class="modal fade" id="invitationModal" tabindex="-1" aria-labelledby="invitationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invitationModalLabel">Générer un lien d'invitation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="invitationForm">
                    @csrf
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Rôle à attribuer</label>
                        <select class="form-select" id="role_id" name="role_id" required>
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email du destinataire</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="form-text">L'invitation sera envoyée à cette adresse email</div>
                    </div>
                </form>
                
                <!-- Zone d'affichage du résultat -->
                <div id="invitationResult" class="mt-3" style="display: none;">
                    <div class="alert alert-success">
                        <h6>Lien d'invitation généré avec succès !</h6>
                        <div class="input-group mt-2">
                            <input type="text" class="form-control" id="generatedLink" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(document.getElementById('generatedLink').value)">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <small class="text-muted" id="expirationInfo"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="generateInvitation()">
                    <i class="fas fa-cog fa-spin" id="loadingSpinner" style="display: none;"></i>
                    Générer le lien
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
async function generateInvitation() {
    const form = document.getElementById('invitationForm');
    const formData = new FormData(form);
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resultDiv = document.getElementById('invitationResult');
    
    // Afficher le spinner
    loadingSpinner.style.display = 'inline-block';
    
    try {
        const response = await fetch('{{ route("admin.generate-invitation-token") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Afficher le résultat
            document.getElementById('generatedLink').value = data.invitation_link;
            document.getElementById('expirationInfo').textContent = `Expire le ${data.expires_at}`;
            resultDiv.style.display = 'block';
            
            // Réinitialiser le formulaire
            form.reset();
            
            // Recharger la page après 2 secondes pour mettre à jour la liste
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            alert('Erreur : ' + data.message);
        }
    } catch (error) {
        alert('Erreur lors de la génération du lien');
        console.error('Error:', error);
    } finally {
        // Masquer le spinner
        loadingSpinner.style.display = 'none';
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Afficher un toast ou message de succès
        const toast = document.createElement('div');
        toast.className = 'alert alert-success position-fixed';
        toast.style.top = '20px';
        toast.style.right = '20px';
        toast.style.zIndex = '9999';
        toast.innerHTML = '<i class="fas fa-check me-2"></i>Lien copié dans le presse-papiers !';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
}

function deleteToken(tokenId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce token ?')) {
        // TODO: Implémenter la suppression du token
        alert('Fonctionnalité de suppression à implémenter');
    }
}
</script>
@endsection
