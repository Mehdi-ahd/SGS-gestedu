@extends("layouts.app")

@section("styles")
<style>
      .permissions-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-top: 2rem;
      }

      .permissions-section {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        position: relative;
      }

      .permissions-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
      }

      .permissions-section.granted::before {
        background: linear-gradient(90deg, #06d6a0, #118ab2);
      }

      .permissions-section.available::before {
        background: linear-gradient(90deg, #ffad46, #ffd43b);
      }

      .permissions-section h5 {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
        display: flex;
        align-items: center;
        gap: 0.75rem;
      }

      .permission-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: #f8f9fa;
        border-radius: 15px;
        transition: all 0.3s;
        border-left: 4px solid transparent;
      }

      .permission-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
      }

      .permission-item.granted {
        background: rgba(6, 214, 160, 0.1);
        border-left-color: #06d6a0;
      }

      .permission-item.available {
        background: rgba(255, 173, 70, 0.1);
        border-left-color: #ffad46;
      }

      .permission-info {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 1rem;
      }

      .permission-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
      }

      .permission-icon.users { background: linear-gradient(135deg, #667eea, #764ba2); }
      .permission-icon.reports { background: linear-gradient(135deg, #48cae4, #0077b6); }
      .permission-icon.settings { background: linear-gradient(135deg, #ff6b6b, #feca57); }
      .permission-icon.roles { background: linear-gradient(135deg, #06d6a0, #118ab2); }
      .permission-icon.audit { background: linear-gradient(135deg, #a8edea, #fed6e3); }
      .permission-icon.backup { background: linear-gradient(135deg, #ffecd2, #fcb69f); }
      .permission-icon.notifications { background: linear-gradient(135deg, #667eea, #764ba2); }

      .permission-content {
        flex: 1;
      }

      .permission-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #2c3e50;
        font-size: 1.1rem;
      }

      .permission-desc {
        font-size: 0.85rem;
        color: #7f8c8d;
        line-height: 1.4;
      }

      .permission-toggle {
        min-width: 120px;
        text-align: right;
      }

      .permission-actions {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
        display: flex;
        gap: 1rem;
      }

      .role-header-mini {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
      }

      .role-header-mini.admin {
        background: linear-gradient(135deg, #ff6b6b, #feca57);
      }

      .role-header-mini.moderator {
        background: linear-gradient(135deg, #48cae4, #0077b6);
      }

      .role-header-mini.user {
        background: linear-gradient(135deg, #06d6a0, #118ab2);
      }

      .role-mini-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
      }

      .role-mini-info h4 {
        margin-bottom: 0.25rem;
        font-weight: 700;
      }

      .role-mini-info p {
        margin-bottom: 0;
        opacity: 0.9;
      }

      .permission-category {
        margin-bottom: 2rem;
      }

      .category-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 15px;
        margin-bottom: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
      }

      .btn-floating {
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      }

      .btn-floating:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
      }

      @media (max-width: 768px) {
        .permissions-container {
          grid-template-columns: 1fr;
        }
        
        .permission-actions {
          position: relative;
          bottom: auto;
          right: auto;
          flex-direction: column;
          margin-top: 2rem;
        }
      }
</style>
@endsection

@section("content")
<div class="container">
          <div class="page-inner">
            <div class="row mb-3">
              <div class="col-md-8">
                <a href="{{ route("roles.show", $role->id)}}">
                  <button class="btn btn-outline-secondary" >
                    <i class="fas fa-arrow-left me-2"></i>Retour au profil
                  </button>
                </a>
              </div>
            </div>

            <div class="role-header-mini user" id="permissions-role-header">
              <div class="role-mini-avatar" id="permissions-role-avatar">
                <i class="fas fa-user"></i>
              </div>
              <div class="role-mini-info">
                <h4 id="permissions-role-name">{{ $role->name }}</h4>
                <p id="permissions-role-desc">Gestion des permissions pour ce rôle</p>
              </div>
            </div>

            <form id="role-permissions-form" method="POST" action="{{ route("roles.updatePermission")}}">
                @csrf
              <div class="permissions-container">
                <div class="permissions-section granted">
                  <h5 class="text-success">
                    <i class="fas fa-check-circle"></i>
                    Permissions Accordées
                  </h5>
                  <input type="hidden" name="role_id" value="{{ $role->id }}">
                    <div id="granted-permissions">
                        @foreach ($permissionsGranted as $permissionGranted)
                            <div class="permission-item granted" data-permission-id="{{$permissionGranted->id}}">
                            <div class="permission-info">
                                <div class="permission-content">
                                <div class="permission-name">{{ $permissionGranted->name }}</div>
                                <div class="permission-desc"></div>
                                </div>
                            </div>
                            <div class="permission-toggle">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="revokePermission(this)">
                                <i class="fas fa-times"></i> Retirer
                                </button>
                            </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="permissions-section available">
                  <h5 class="text-warning">
                    <i class="fas fa-clock"></i>
                    Permissions Disponibles
                  </h5>
                  <div id="available-permissions">
                    @foreach ($permissionsDenied as $permissionDenied)
                        <div class="permission-item available" data-permission-id="{{$permissionDenied->id}}">
                            <div class="permission-info">
                                
                                <div class="permission-content">
                                <div class="permission-name">{{ $permissionDenied->name }}</div>
                                <div class="permission-desc"></div>
                                </div>
                            </div>
                            <div class="permission-toggle">
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="grantPermission(this)">
                                <i class="fas fa-plus"></i> Accorder
                                </button>
                            </div>
                            </div>
                    @endforeach
                  </div>
                </div>
              </div>

              <div class="permission-actions">
                <button type="button" class="btn btn-secondary btn-floating" onclick="history.back()">
                  <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="submit" class="btn btn-primary btn-floating" id="apply-changes-btn" style="display: none;">
                  <i class="fas fa-save me-2"></i>Appliquer les Modifications
                </button>
              </div>
            </form>
          </div>
        </div>
@endsection

@section("scripts")
<script>
      
      let hasChanges = false;

      function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
      }

      function loadRoleData() {
        const roleId = getUrlParameter('id') || '1';
        const role = rolesData[roleId];
        
        if (role) {
          const header = document.getElementById('permissions-role-header');
          header.className = `role-header-mini ${role.type}`;
          
          document.getElementById('permissions-role-avatar').innerHTML = `<i class="${role.icon}"></i>`;
          document.getElementById('permissions-role-name').textContent = role.name;
          document.getElementById('permissions-role-desc').textContent = role.description;
        }
      }

      function grantPermission(button) {
        const permissionItem = button.closest('.permission-item');
        const grantedSection = document.getElementById('granted-permissions');
        const permissionId = permissionItem.dataset.permissionId;
        
        // Changer l'apparence de l'item
        permissionItem.className = 'permission-item granted';
        
        // Changer le bouton
        button.className = 'btn btn-sm btn-outline-danger';
        button.innerHTML = '<i class="fas fa-times"></i> Retirer';
        button.setAttribute('onclick', 'revokePermission(this)');
        
        // Ajouter l'input hidden pour le formulaire
        const permissionName = permissionItem.querySelector('.permission-name').textContent.toLowerCase().replace(/\s+/g, '_');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = `granted[${permissionId}]`;
        hiddenInput.value = permissionId;
        button.parentNode.appendChild(hiddenInput);
        
        // Déplacer vers les permissions accordées
        grantedSection.appendChild(permissionItem);
        
        hasChanges = true;
        updateApplyButton();
      }

      function revokePermission(button) {
        const permissionItem = button.closest('.permission-item');
        const availableSection = document.getElementById('available-permissions');
        const permissionId = permissionItem.dataset.permissionId;
        
        // Changer l'apparence de l'item
        permissionItem.className = 'permission-item available';
        
        // Changer le bouton
        button.className = 'btn btn-sm btn-outline-success';
        button.innerHTML = '<i class="fas fa-plus"></i> Accorder';
        button.setAttribute('onclick', 'grantPermission(this)');
        
        // Supprimer l'input hidden
        const hiddenInput = button.parentNode.querySelector('input[type="hidden"]');
        if (hiddenInput) {
          hiddenInput.remove();
        }
        
        // Ajouter l'input hidden pour denied
        const permissionName = permissionItem.querySelector('.permission-name').textContent.toLowerCase().replace(/\s+/g, '_');
        const deniedInput = document.createElement('input');
        deniedInput.type = 'hidden';
        deniedInput.name = `denied[${permissionId}]`;
        deniedInput.value = permissionId;
        button.parentNode.appendChild(deniedInput);
        
        // Déplacer vers les permissions disponibles
        availableSection.appendChild(permissionItem);
        
        hasChanges = true;
        updateApplyButton();
      }

      function updateApplyButton() {
        let applyButton = document.getElementById('apply-changes-btn');
        if (!applyButton) {
          // Créer le bouton s'il n'existe pas
          const actionDiv = document.querySelector('.permission-actions');
          applyButton = document.createElement('button');
          applyButton.id = 'apply-changes-btn';
          applyButton.type = 'submit';
          applyButton.className = 'btn btn-primary btn-floating';
          applyButton.innerHTML = '<i class="fas fa-save me-2"></i>Appliquer les Modifications';
          actionDiv.insertBefore(applyButton, actionDiv.firstChild);
        }
        
        // Afficher ou masquer le bouton selon s'il y a des changements
        if (hasChanges) {
          applyButton.style.display = 'inline-block';
        } else {
          applyButton.style.display = 'none';
        }
      }

      function handleFormSubmit(event) {
        if (!hasChanges) {
          event.preventDefault();
          return;
        }
        
        // Le formulaire sera soumis naturellement au backend Laravel
        // Pas besoin d'empêcher la soumission
      }

      document.addEventListener('DOMContentLoaded', function() {
        loadRoleData();
        updateApplyButton(); // Masquer le bouton au début
        
        // Ajouter l'événement de soumission du formulaire
        const form = document.getElementById('role-permissions-form');
        if (form) {
          form.addEventListener('submit', handleFormSubmit);
        }
      });
    </script>
@endsection