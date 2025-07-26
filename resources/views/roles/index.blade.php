@extends("layouts.app")

@section("styles")
<style>
      .role-card {
        cursor: pointer;
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #fff;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        position: relative;
      }

      .role-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
      }

      .role-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #667eea, #764ba2);
      }

      .role-card.admin::before {
        background: linear-gradient(90deg, #ff6b6b, #feca57);
      }

      .role-card.moderator::before {
        background: linear-gradient(90deg, #48cae4, #0077b6);
      }

      .role-card.user::before {
        background: linear-gradient(90deg, #06d6a0, #118ab2);
      }

      .role-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 2rem auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        background: linear-gradient(135deg, #667eea, #764ba2);
      }

      .role-icon.admin {
        background: linear-gradient(135deg, #ff6b6b, #feca57);
      }

      .role-icon.moderator {
        background: linear-gradient(135deg, #48cae4, #0077b6);
      }

      .role-icon.user {
        background: linear-gradient(135deg, #06d6a0, #118ab2);
      }

      .role-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #2c3e50;
      }

      .role-description {
        color: #7f8c8d;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        line-height: 1.5;
      }

      .role-stats {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 15px;
        margin-bottom: 1rem;
      }

      .stat-item {
        text-align: center;
      }

      .stat-number {
        font-weight: 700;
        font-size: 1.2rem;
        color: #2c3e50;
      }

      .stat-label {
        font-size: 0.8rem;
        color: #7f8c8d;
        margin-top: 0.25rem;
      }

      .role-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
      }

      .create-role-section {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 20px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
      }

      .create-role-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/><circle cx="20" cy="20" r="1" fill="white" opacity="0.1"/><circle cx="80" cy="30" r="1.5" fill="white" opacity="0.1"/></svg>');
        animation: float 20s linear infinite;
      }

      @keyframes float {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }

      .stats-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
      }

      .overview-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-left: 4px solid #667eea;
      }

      .overview-card.total { border-left-color: #667eea; }
      .overview-card.admin { border-left-color: #ff6b6b; }
      .overview-card.moderator { border-left-color: #48cae4; }
      .overview-card.user { border-left-color: #06d6a0; }

      .overview-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
      }

      .overview-label {
        color: #7f8c8d;
        font-size: 0.9rem;
      }

      .search-filter-section {
        background: #fff;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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

      .form-floating .form-control {
        border-radius: 15px;
      }
</style>
@endsection

@section("content")
    <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Gestion des Rôles</h3>
                <h6 class="op-7 mb-2">Administration et gestion des rôles utilisateur</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Exporter</a>
                <button class="btn btn-success btn-round me-2" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                  <i class="fas fa-key me-2"></i>Créer une Permission
                </button>
                <button class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                  <i class="fas fa-plus me-2"></i>Créer un Rôle
                </button>
              </div>
            </div>

            <!-- Statistics Overview -->
            <div class="stats-overview">
              <div class="overview-card total">
                <div class="overview-number">{{ $roles->count() }}</div>
                <div class="overview-label">Total Rôles</div>
              </div>
              <div class="overview-card admin">
                <div class="overview-number">{{ $roles->count() }}</div>
                <div class="overview-label">Rôles Admin</div>
              </div>
              <div class="overview-card moderator">
                <div class="overview-number">3</div>
                <div class="overview-label">Rôles Modérateur</div>
              </div>
              <div class="overview-card user">
                <div class="overview-number">3</div>
                <div class="overview-label">Rôles Utilisateur</div>
              </div>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-section">
              <div class="row">
                <div class="col-md-8">
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                      <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-0" placeholder="Rechercher un rôle..." id="role-search">
                  </div>
                </div>
                <div class="col-md-4">
                  <select class="form-select" id="role-filter">
                    <option value="all">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="moderator">Modérateur</option>
                    <option value="user">Utilisateur</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Roles Grid -->
            <div class="row" id="roles-grid">
                @foreach ($roles as $role)
                    <div class="col-lg-4 col-md-6 mb-4" data-role-type="{{ $role->id }}">
                        <div class="card role-card user" onclick="window.location.href='{{ route("roles.show", $role->id)}} ' ">
                            <div class="card-body text-center">
                                <div class="role-icon moderator">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="role-name">{{ $role->name }}</div>
                                <div class="role-description">Accès complet à toutes les fonctionnalités du système</div>
                                <div class="role-stats">
                                    <div class="stat-item">
                                        <div class="stat-number">{{ $role->users->count() }}</div>
                                        <div class="stat-label">Utilisateurs</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">{{ $role->permissions->count() }}</div>
                                        <div class="stat-label">Permissions</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">{{ $countPermissions != 0 ? ($role->permissions->count()/$countPermissions)*100 : 0}}%</div>
                                        <div class="stat-label">Accès</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
          </div>
        </div>

        <!-- Modal Create Role -->
        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">
                  <i class="fas fa-plus me-2"></i>Créer un Nouveau Rôle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="createRoleForm" method="POST" action="{{ route("roles.store")}}">
                    @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="roleName" name="name" placeholder="Nom du rôle" required>
                        <label for="roleName">Nom du Rôle *</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="roleIdentifier" name="id" placeholder="Identifiant" required>
                        <label for="roleIdentifier">Identifiant (slug) *</label>
                      </div>
                    </div>
                  </div>

                  <div class="form-floating mb-3">
                    <textarea class="form-control" id="roleDescription" name="roleDescription" style="height: 100px" placeholder="Description du rôle" ></textarea>
                    <label for="roleDescription">Description *</label>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Type de Rôle</label>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="roleType" id="adminType" value="admin" >
                          <label class="form-check-label" for="adminType">
                            <i class="fas fa-crown text-warning me-2"></i>Administrateur
                          </label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="roleType" id="moderatorType" value="moderator" >
                          <label class="form-check-label" for="moderatorType">
                            <i class="fas fa-shield-alt text-info me-2"></i>Modérateur
                          </label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="roleType" id="userType" value="user" checked >
                          <label class="form-check-label" for="userType">
                            <i class="fas fa-user text-success me-2"></i>Utilisateur
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Modal Footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-save me-2"></i>Créer le Rôle
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Create Permission -->
        <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createPermissionModalLabel">
                  <i class="fas fa-key me-2"></i>Créer une Nouvelle Permission
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="createPermissionForm" method="POST" action="">
                    @csrf
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="permissionName" name="name" placeholder="Nom de la permission" required>
                    <label for="permissionName">Nom de la Permission *</label>
                  </div>

                  <div class="form-floating mb-3">
                    <textarea class="form-control" id="permissionDescription" name="description" style="height: 100px" placeholder="Description de la permission"></textarea>
                    <label for="permissionDescription">Description</label>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Assigner par défaut aux rôles</label>
                    @foreach ($roles as $role)
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="roles[]" id="role{{ $role->id }}" value="{{ $role->id }}">
                      <label class="form-check-label" for="role{{ $role->id }}">
                        {{ $role->name }}
                      </label>
                    </div>
                    @endforeach
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                      <i class="fas fa-save me-2"></i>Créer la Permission
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
@endsection

@section("scripts")
    <script>
      // Recherche et filtres
      document.addEventListener('DOMContentLoaded', function() {
        // Recherche
        const searchInput = document.getElementById('role-search');
        if (searchInput) {
          searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const roleCards = document.querySelectorAll('.role-card');
            
            roleCards.forEach(card => {
              const roleName = card.querySelector('.role-name').textContent.toLowerCase();
              const roleDesc = card.querySelector('.role-description').textContent.toLowerCase();
              
              if (roleName.includes(searchTerm) || roleDesc.includes(searchTerm)) {
                card.closest('.col-lg-4').style.display = '';
              } else {
                card.closest('.col-lg-4').style.display = 'none';
              }
            });
          });
        }
        
        // Filtres
        const filterSelect = document.getElementById('role-filter');
        if (filterSelect) {
          filterSelect.addEventListener('change', function() {
            const filter = this.value;
            const roleContainers = document.querySelectorAll('[data-role-type]');
            
            roleContainers.forEach(container => {
              if (filter === 'all' || container.dataset.roleType === filter) {
                container.style.display = '';
              } else {
                container.style.display = 'none';
              }
            });
          });
        }

        // Gestion du formulaire de création de rôle
        const createForm = document.getElementById('createRoleForm');
        if (createForm) {
          createForm.addEventListener('submit', function(event) {
            // Le formulaire sera soumis naturellement au backend Laravel
            // Pas besoin d'empêcher la soumission si tous les champs requis sont remplis
          });
        }
      });
    </script>
@endsection