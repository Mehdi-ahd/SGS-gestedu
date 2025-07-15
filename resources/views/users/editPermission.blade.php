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
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      }

      .permissions-section h5 {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
      }

      .permission-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        margin-bottom: 0.5rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s;
      }

      .permission-item:hover {
        background: #e9ecef;
      }

      .permission-info {
        flex: 1;
      }

      .permission-name {
        font-weight: 500;
        margin-bottom: 0.25rem;
      }

      .permission-desc {
        font-size: 0.85rem;
        color: #6c757d;
      }

      .permission-toggle {
        min-width: 80px;
        text-align: right;
      }

      .permission-actions {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
      }

      .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
      }

      .user-avatar.primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
      }

      .user-avatar.success {
        background: linear-gradient(135deg, #f093fb, #f5576c);
      }

      .user-avatar.info {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
      }

      .user-avatar.warning {
        background: linear-gradient(135deg, #43e97b, #38f9d7);
      }

      @media (max-width: 768px) {
        .permissions-container {
          grid-template-columns: 1fr;
        }
      }
    </style>

@endsection

@section("content")
<div class="container">
          <div class="page-inner">
            <div class="row mb-3">
              <div class="col-md-8">
                <a href="{{ route("users.show", $user->id)}}">
                  <button class="btn btn-outline-secondary" >
                    <i class="fas fa-arrow-left me-2"></i>Retour au profil
                  </button>
                </a>
              </div>
            </div>
            @if (session("success"))
              <div class="alert alert-success">
                {{ session("success") }}
              </div>
            @endif
            <div class="card mb-4">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="user-avatar primary me-3" id="permissions-user-avatar">JD</div>
                  <div>
                    <h4 class="mb-0" id="permissions-user-name">{{ $user->getFullName() }}</h4>
                    <p class="text-muted mb-0" id="permissions-user-role">{{ $user->role->name }}</p>
                  </div>
                </div>
              </div>
            </div>

            <form id="permissions-form" method="POST" action="{{ route("users.updatePermission")}}">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <div class="permissions-container">
                <div class="permissions-section">
                  <h5 class="text-success">
                    <i class="fas fa-check-circle me-2"></i>
                    Permissions Accordées
                  </h5>
                  <div id="granted-permissions">
                    @foreach ($userPermissions as $userPermission)
                      <div class="permission-item" data-permission-id="{{ $userPermission->id }}">
                        <div class="permission-info">
                          <input type="hidden" name="deny[{{$userPermission->id}}]">
                          <div class="permission-name">{{ $userPermission->name }}</div>
                          <div class="permission-desc">{{ ($userPermission->description) ? $userPermission->description : "Aucune description"}}</div>
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

                <div class="permissions-section">
                  <h5 class="text-warning">
                    <i class="fas fa-clock me-2"></i>
                    Permissions Disponibles
                  </h5>
                  <div id="available-permissions">
                    @if ($missingPermissions)
                      @foreach ($missingPermissions as $permission)
                        <div class="permission-item" data-permission-id="{{$permission->id}}">
                          <div class="permission-info">
                            <div class="permission-name">{{ $permission->name }}</div>
                            <div class="permission-desc">{{ ($permission->description) ? $permission->description : "Aucune description disponible"}}</div>
                          </div>
                          <div class="permission-toggle">
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="grantPermission(this)">
                              <i class="fas fa-plus"></i> Accorder
                            </button>
                          </div>
                        </div>
                      @endforeach
                    @else
                        <div class="alert alert-info">
                          Aucune permission non accordée
                        </div>
                    @endif
                  </div>
                </div>
              </div>

              <div class="permission-actions">
                <a href="{{ route("users.show", $user->id)}}">
                  <button type="button" class="btn btn-secondary me-2" onclick="history.back()">
                    <i class="fas fa-times me-2"></i>Annuler
                  </button>
                </a>
                
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

  function loadUserData() {
    const userId = getUrlParameter('id') || '1';
    const user = usersData[userId];
    
    if (user) {
      document.getElementById('permissions-user-avatar').textContent = user.avatar;
      document.getElementById('permissions-user-avatar').className = `user-avatar ${user.avatarClass} me-3`;
      document.getElementById('permissions-user-name').textContent = user.name;
      document.getElementById('permissions-user-role').textContent = user.role;
    }
  }

  function grantPermission(button) {
    const permissionItem = button.closest('.permission-item');
    const grantedSection = document.getElementById('granted-permissions');
    const permissionId = permissionItem.dataset.permissionId; // Récupérer l'ID

    // Changer le bouton en "Retirer"
    button.className = 'btn btn-sm btn-outline-danger';
    button.innerHTML = '<i class="fas fa-times"></i> Retirer';
    button.setAttribute('onclick', 'revokePermission(this)');

    // Déplacer vers les permissions accordées
    grantedSection.appendChild(permissionItem);

    // Créer un input caché pour la permission accordée
    const inputHidden = document.createElement('input');
    inputHidden.type = 'hidden';
    inputHidden.name = `granted[${permissionId}]`; // Nom sous forme "granted[id]"
    inputHidden.value = permissionId; // ID de la permission comme value

    // Ajouter l'input au formulaire
    permissionItem.appendChild(inputHidden); // Mettre l'input dans la div de la permission
    hasChanges = true;
    updateApplyButton();
}

function revokePermission(button) {
    const permissionItem = button.closest('.permission-item');
    const availableSection = document.getElementById('available-permissions');
    const permissionId = permissionItem.dataset.permissionId; // Récupérer l'ID

    // Changer le bouton en "Accorder"
    button.className = 'btn btn-sm btn-outline-success';
    button.innerHTML = '<i class="fas fa-plus"></i> Accorder';
    button.setAttribute('onclick', 'grantPermission(this)');

    // Déplacer vers les permissions disponibles
    availableSection.appendChild(permissionItem);

    // Retirer l'input caché pour la permission accordée si elle existe
    const grantedInputs = document.querySelectorAll('input[name^="granted"]');
    grantedInputs.forEach(input => {
        if (input.name === `granted[${permissionId}]`) {
            input.remove(); // Retirer le champ caché du formulaire
        }
    });

    // Créer un input caché pour la permission révoquée uniquement ici
    const inputHidden = document.createElement('input');
    inputHidden.type = 'hidden';
    inputHidden.name = `denied[${permissionId}]`; // Nom sous forme "denied[id]"
    inputHidden.value = permissionId; // ID de la permission comme value
    
    // Ajouter l'input dans la div de permission
    permissionItem.appendChild(inputHidden); // Mettre l'input dans la div de la permission

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
      applyButton.className = 'btn btn-primary';
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

  function collectFormData() {
    const grantedPermissions = [];
    const availablePermissions = [];
    
    // Collecter les permissions accordées
    document.querySelectorAll('#granted-permissions .permission-item').forEach(item => {
      const name = item.querySelector('.permission-name').textContent;
      grantedPermissions.push(name);
    });
    
    // Collecter les permissions disponibles
    document.querySelectorAll('#available-permissions .permission-item').forEach(item => {
      const name = item.querySelector('.permission-name').textContent;
      availablePermissions.push(name);
    });
    
    return {
      granted: grantedPermissions,
      available: availablePermissions,
      userId: getUrlParameter('id') || '1'
    };
  }

  function handleFormSubmit(event) {
    if (!hasChanges) {
      event.preventDefault();
      return;
    }
    
    // Le formulaire sera soumis naturellement au backend
    // Pas besoin d'empêcher la soumission
  }

  document.addEventListener('DOMContentLoaded', function() {
    loadUserData();
    updateApplyButton(); // Masquer le bouton au début
    
    // Ajouter l'événement de soumission du formulaire
    const form = document.getElementById('permissions-form');
    if (form) {
      form.addEventListener('submit', handleFormSubmit);
    }
  });
</script>

@endsection