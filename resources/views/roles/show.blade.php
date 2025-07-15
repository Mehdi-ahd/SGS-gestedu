@extends("layouts.app")

@section("styles")
<style>
      .role-detail-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 20px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
      }

      .role-detail-header.admin {
        background: linear-gradient(135deg, #ff6b6b, #feca57);
      }

      .role-detail-header.moderator {
        background: linear-gradient(135deg, #48cae4, #0077b6);
      }

      .role-detail-header.user {
        background: linear-gradient(135deg, #06d6a0, #118ab2);
      }

      .role-detail-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 600;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
      }

      .user-mini-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
        border-left: 4px solid transparent;
      }

      .user-mini-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      }

      .user-mini-card.active { border-left-color: #31ce36; }
      .user-mini-card.inactive { border-left-color: #f25961; }
      .user-mini-card.pending { border-left-color: #ffad46; }

      .user-mini-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        margin-bottom: 1rem;
      }

      .user-mini-avatar.primary { background: linear-gradient(135deg, #177dff, #4dabf7); }
      .user-mini-avatar.success { background: linear-gradient(135deg, #31ce36, #51cf66); }
      .user-mini-avatar.warning { background: linear-gradient(135deg, #ffad46, #ffd43b); }
      .user-mini-avatar.danger { background: linear-gradient(135deg, #f25961, #ff6b6b); }
      .user-mini-avatar.info { background: linear-gradient(135deg, #1572e8, #339af0); }

      .user-mini-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #2c3e50;
      }

      .user-mini-email {
        font-size: 0.85rem;
        color: #7f8c8d;
        margin-bottom: 0.5rem;
      }

      .user-mini-status {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-weight: 500;
      }

      .status-active {
        background-color: rgba(49, 206, 54, 0.1);
        color: #31ce36;
      }

      .status-inactive {
        background-color: rgba(242, 89, 97, 0.1);
        color: #f25961;
      }

      .status-pending {
        background-color: rgba(255, 173, 70, 0.1);
        color: #ffad46;
      }

      .info-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
      }

      .info-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .info-item:last-child {
        border-bottom: none;
      }

      .info-label {
        font-weight: 600;
        color: #2c3e50;
      }

      .info-value {
        color: #7f8c8d;
      }

      .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
      }

      .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      }

      .stat-icon {
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

      .stat-icon.users { background: linear-gradient(135deg, #667eea, #764ba2); }
      .stat-icon.permissions { background: linear-gradient(135deg, #48cae4, #0077b6); }
      .stat-icon.active { background: linear-gradient(135deg, #06d6a0, #118ab2); }
      .stat-icon.last-used { background: linear-gradient(135deg, #ff6b6b, #feca57); }

      .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
      }

      .stat-label {
        color: #7f8c8d;
        font-size: 0.9rem;
      }

      .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
      }

      .section-title i {
        color: #667eea;
      }

      .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
      }

      .modal-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 20px 20px 0 0;
        border-bottom: none;
      }

      .user-item {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
        border: 2px solid transparent;
      }

      .user-item:hover {
        background: #e9ecef;
        transform: translateY(-2px);
      }

      .user-item.selected {
        background: rgba(102, 126, 234, 0.1);
        border-color: #667eea;
      }

      .user-info {
        flex: 1;
      }

      .user-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #2c3e50;
      }

      .user-current-role {
        font-size: 0.85rem;
        color: #7f8c8d;
      }

      .user-checkbox {
        margin-left: 1rem;
      }

      .user-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
      }

      .users-list-container {
        border: 1px solid #dee2e6;
        border-radius: 15px;
        padding: 1rem;
        background: #fff;
      }

      .form-floating .form-control,
      .form-floating .form-select {
        border-radius: 15px;
      }
</style>
@endsection

@section("content")
    <div class="container">
          <div class="page-inner">
            <div class="row">
              <div class="col-md-8">
                <a href="{{ route("roles.index") }}" class="btn btn-outline-secondary mb-3">
                  <i class="fas fa-arrow-left me-2"></i>Retour aux rôles
                </a>
              </div>
              <div class="col-md-4 text-end">
                <a href="{{ route('roles.editPermission', $role->id) }}" class="btn btn-primary">
  <i class="fas fa-shield-alt me-2"></i>Gérer les Permissions
</a>
              </div>
            </div>

            <div class="role-detail-header user" id="role-detail-header">
              <div class="role-detail-avatar" id="role-avatar">
                <i class="fas fa-user"></i>
              </div>
              <h2 class="mb-2" id="role-name">{{ $role->name }}</h2>
              <p class="mb-1" id="role-description">Accès complet à toutes les fonctionnalités du système</p>
              <span class="badge bg-light text-dark fs-6" id="role-identifier">{{ $role->id }}</span>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
              <div class="stat-card">
                <div class="stat-icon users">
                  <i class="fas fa-users"></i>
                </div>
                <div class="stat-number" id="users-count">{{ $role->users->count() }}</div>
                <div class="stat-label">Utilisateurs</div>
              </div>
              <div class="stat-card">
                <div class="stat-icon permissions">
                  <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-number" id="permissions-count">{{ $role->permissions->count() }}</div>
                <div class="stat-label">Permissions</div>
              </div>
              <div class="stat-card">
                <div class="stat-icon active">
                  <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-number" id="active-users">3</div>
                <div class="stat-label">Actifs</div>
              </div>
              <div class="stat-card">
                <div class="stat-icon last-used">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number" id="last-activity">2h</div>
                <div class="stat-label">Dernière activité</div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="info-card">
                  <h5 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Informations du Rôle
                  </h5>
                  <div class="info-item">
                    <div class="info-label">Nom du rôle</div>
                    <div class="info-value" id="detail-name">{{ $role->name }}</div>
                  </div>
                  <div class="info-item">
                    <div class="info-label">Identifiant</div>
                    <div class="info-value" id="detail-identifier">{{ $role->id }}</div>
                  </div>
                  {{-- <div class="info-item">
                    <div class="info-label">Type</div>
                    <div class="info-value" id="detail-type">Administrateur</div>
                  </div> --}}
                  <div class="info-item">
                    <div class="info-label">Date de création</div>
                    <div class="info-value" id="detail-created">{{ $role->created_at}}</div>
                  </div>
                  <div class="info-item">
                    <div class="info-label">Dernière modification</div>
                    <div class="info-value" id="detail-modified">{{ $role->updated_at }}</div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-card">
                  <h5 class="section-title">
                    <i class="fas fa-chart-bar"></i>
                    Statistiques d'Usage
                  </h5>
                  <div class="info-item">
                    <div class="info-label">Permissions accordées</div>
                    <div class="info-value">{{$role->permissions->count() . "/" . $countPermissions}} (A gerer)</div>
                  </div>
                  <div class="info-item">
                    <div class="info-label">Utilisateurs assignés</div>
                    <div class="info-value">{{ $role->users->count() }} utilisateurs</div>
                  </div>
                  <div class="info-item">
                    <div class="info-label">Taux d'activité</div>
                    <div class="info-value">95%</div>
                  </div>
                  <div class="info-item">
                    <div class="info-label">Dernière connexion</div>
                    <div class="info-value">Il y a 2 heures</div>
                  </div>
                  <div class="info-item">
                    <div class="info-label">Niveau de sécurité</div>
                    <div class="info-value">Maximum</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Users with this role -->
            <div class="info-card">
              <h5 class="section-title">
                <i class="fas fa-users"></i>
                Utilisateurs avec ce Rôle
              </h5>
              <div class="row" id="role-users-list">
                @foreach ($role->users as $user)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="user-mini-card active" onclick="window.location.href='{{ route("users.show", $user->id)}}'">
                            <div class="user-mini-avatar primary">JD</div>
                            <div class="user-mini-name">{{ $user->getFullName() }}</div>
                            <div class="user-mini-email">{{ $user->email }}</div>
                            <span class="user-mini-status status-active">Actif</span>
                        </div>
                    </div>
                @endforeach
              
              <div class="text-center mt-3">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#assignUsersModal">
                  <i class="fas fa-user-plus me-2"></i>Assigner des Utilisateurs
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Assign Users -->
        <div class="modal fade" id="assignUsersModal" tabindex="-1" aria-labelledby="assignUsersModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="assignUsersModalLabel">
                  <i class="fas fa-user-plus me-2"></i>Assigner des Utilisateurs au Rôle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="assignUsersForm" method="POST" action="{{ route("roles.update", $role->id) }}">
                  @csrf
                  @method("PUT")
                  <!-- Filtres de recherche -->
                  <div class="row mb-4">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="searchUsers" placeholder="Rechercher un utilisateur...">
                        <label for="searchUsers">Rechercher un utilisateur...</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <select class="form-select" id="filterByRole">
                            <option value="all">Tous les rôles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <label for="filterByRole">Filtrer par rôle</label>
                      </div>
                    </div>
                  </div>

                  <!-- Liste des utilisateurs -->
                    <div class="users-list-container" style="max-height: 400px; overflow-y: auto;">
                        <div class="row" id="usersList">
                            <!-- Utilisateur 1 -->
                            @foreach ($users as $user)
                                <div class="col-md-6 mb-3" data-user-id="{{ $user->id }}" data-user-name="{{ $user->getFullName() }}" data-user-role="{{ $user->role->name }}">
                                    <div class="user-item">
                                        <div class="user-info">
                                            <div class="user-name">{{ $user->getFullName() }}</div>
                                            <div class="user-current-role">{{ $user->role->name }}</div>
                                        </div>
                                        <div class="user-checkbox">
                                          <input type="checkbox" class="form-check-input" id="user-{{ $user->id }}" name="assigned[{{ $user->id }}]" value="{{ $user->id }}" onchange="toggleUserAssignment(this, 1)">
                                          <label class="form-check-label" for="user-1"></label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="assignUsersForm" class="btn btn-primary">
                  <i class="fas fa-save me-2"></i>Assigner les Utilisateurs
                </button>
              </div>
            </div>
          </div>
        </div>
@endsection

@section("scripts")
<script>
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
      // Header
      const header = document.getElementById('role-detail-header');
      header.className = `role-detail-header ${role.type}`;
      
      document.getElementById('role-avatar').innerHTML = `<i class="${role.icon}"></i>`;
      document.getElementById('role-name').textContent = role.name;
      document.getElementById('role-description').textContent = role.description;
      document.getElementById('role-identifier').textContent = role.identifier;
      
      // Stats
      document.getElementById('users-count').textContent = role.userCount;
      document.getElementById('permissions-count').textContent = role.permissionCount;
      document.getElementById('active-users').textContent = role.activeUsers;
      document.getElementById('last-activity').textContent = role.lastActivity;
      
      // Details
      document.getElementById('detail-name').textContent = role.name;
      document.getElementById('detail-identifier').textContent = role.identifier;
      document.getElementById('detail-type').textContent = role.type.charAt(0).toUpperCase() + role.type.slice(1);
      document.getElementById('detail-created').textContent = role.created;
      document.getElementById('detail-modified').textContent = role.modified;
    }
  }

  function goToRolePermissions(roleId) {
    const url = `{{ route('roles.editPermission', ':id') }}`.replace(':id', roleId);
    window.location.href = url;
  }

  document.addEventListener('DOMContentLoaded', function() {
    loadRoleData();
    initializeAssignUsersModal();
  });

  function toggleUserAssignment(checkbox, userId) {
    const userItem = checkbox.closest('.user-item');
    const form = document.getElementById('assignUsersForm');
    
    if (checkbox.checked) {
      // Ajouter la classe selected
      userItem.classList.add('selected');
      
      // Créer le champ caché
      const hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = `assign[${userId}]`;
      hiddenInput.value = userId;
      hiddenInput.id = `assign-user-${userId}`;
      form.appendChild(hiddenInput);
    } else {
      // Retirer la classe selected
      userItem.classList.remove('selected');
      
      // Supprimer le champ caché
      const hiddenInput = document.getElementById(`assign-user-${userId}`);
      if (hiddenInput) {
        hiddenInput.remove();
      }
    }
  }

  function initializeAssignUsersModal() {
    // Recherche d'utilisateurs
    const searchInput = document.getElementById('searchUsers');
    if (searchInput) {
      searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const userItems = document.querySelectorAll('[data-user-name]');
        
        userItems.forEach(item => {
          const userName = item.dataset.userName;
          if (userName.includes(searchTerm)) {
            item.style.display = '';
          } else {
            item.style.display = 'none';
          }
        });
      });
    }

    // Filtre par rôle
    const roleFilter = document.getElementById('filterByRole');
    if (roleFilter) {
      roleFilter.addEventListener('change', function() {
        const selectedRole = this.value;
        const userItems = document.querySelectorAll('[data-user-role]');
        
        userItems.forEach(item => {
          const userRole = item.dataset.userRole;
          if (selectedRole === 'all' || userRole === selectedRole) {
            item.style.display = '';
          } else {
            item.style.display = 'none';
          }
        });
      });
    }

    // Gestion de la soumission du formulaire
    const assignForm = document.getElementById('assignUsersForm');
    if (assignForm) {
      assignForm.addEventListener('submit', function(event) {
        // Le formulaire sera soumis naturellement au backend Laravel
      });
    }

    // Réinitialiser le formulaire à la fermeture de la modal
    const modal = document.getElementById('assignUsersModal');
    if (modal) {
      modal.addEventListener('hidden.bs.modal', function() {
        // Décocher toutes les checkboxes
        const checkboxes = modal.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
          checkbox.checked = false;
          checkbox.closest('.user-item').classList.remove('selected');
        });
        
        // Supprimer tous les champs cachés
        const hiddenInputs = assignForm.querySelectorAll('input[type="hidden"]');
        hiddenInputs.forEach(input => input.remove());
        
        // Réinitialiser les filtres
        document.getElementById('searchUsers').value = '';
        document.getElementById('filterByRole').value = 'all';
        
        // Réafficher tous les utilisateurs
        const userItems = document.querySelectorAll('[data-user-name]');
        userItems.forEach(item => item.style.display = '');
      });
    }
  }
</script>
@endsection