@extends("layouts.app")

@section("styles")
    <style>
      .user-detail-header {
        background: linear-gradient(135deg, #177dff, #4dabf7);
        color: white;
        border-radius: 15px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        text-align: center;
      }

      .user-detail-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 600;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
      }

      .info-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
      }

      .info-item:last-child {
        border-bottom: none;
      }

      .info-label {
        font-weight: 600;
        color: #1a2035;
        margin-bottom: 0.5rem;
      }

      .info-value {
        color: #6c757d;
      }

      .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
      }

      .status-actif {
        background-color: rgba(49, 206, 54, 0.1);
        color: #31ce36;
      }

      .status-inactif {
        background-color: rgba(242, 89, 97, 0.1);
        color: #f25961;
      }

      .status-enattente {
        background-color: rgba(255, 173, 70, 0.1);
        color: #ffad46;
      }
    </style>
@endsection

@section("content")
<div class="container">
          <div class="page-inner">
            <div class="row">
              <div class="col-md-8">
                <a href="{{ route("users.index") }}" class="btn btn-outline-secondary mb-3">
                  <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
              </div>
              <div class="col-md-4 text-end">
                <button class="btn btn-primary" onclick="goToPermissions()">
                  <i class="fas fa-shield-alt me-2"></i>Gérer les Permissions
                </button>
              </div>
            </div>

            <div class="user-detail-header" id="user-detail-header">
              <div class="user-detail-avatar" id="user-avatar">JD</div>
              <h2 class="mb-2" id="user-name">{{ $user->getFullName() }}</h2>
              <p class="mb-1" id="user-email">{{ $user->email }}</p>
              <span class="badge bg-light text-dark fs-6" id="user-role">{{ $user->role->name }}</span>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Informations Personnelles</h5>
                  </div>
                  <div class="card-body" id="user-personal-info">
                    <div class="info-item">
                      <div class="info-label">Nom complet</div>
                      <div class="info-value" id="full-name">{{ $user->getFullName() }}</div>
                    </div>
                    <div class="info-item">
                      <div class="info-label">Email</div>
                      <div class="info-value" id="email">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                      <div class="info-label">Téléphone</div>
                      <div class="info-value" id="phone">(229) {{ $user->phone }}</div>
                      @if ($user->second_phone)
                        <div class="info-value" id="phone">(229) {{ $user->second_phone }}</div>
                      @endif
                      
                    </div>
                    <div class="info-item">
                      <div class="info-label">Date de naissance </div>
                      <div class="info-value" id="department">{{ ($user->birthday) ? $user->birthday->format("d/m/Y") : " " }}</div>
                    </div>
                    <div class="info-item">
                      <div class="info-label">Département</div>
                      <div class="info-value" id="department">Direction Générale</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Informations Système</h5>
                  </div>
                  <div class="card-body" id="user-system-info">
                    <div class="info-item">
                      <div class="info-label">Statut</div>
                      <div class="info-value">
                        <span class="status-badge status-actif" id="status">Actif</span>
                      </div>
                    </div>
                    <div class="info-item">
                      <div class="info-label">Rôle</div>
                      <div class="info-value" id="role">{{ $user->role->name }}</div>
                    </div>
                    <div class="info-item">
                      <div class="info-label">Date de création</div>
                      <div class="info-value" id="date-created">{{ $user->get_date() }}</div>
                    </div>
                    <div class="info-item">
                      <div class="info-label">Dernière connexion</div>
                      <div class="info-value" id="last-login">Il y a 2 heures</div>
                    </div>
                    <div class="info-item">
                      <div class="info-label">Nombre de connexions</div>
                      <div class="info-value" id="login-count">847</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Activité Récente</h5>
                  </div>
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <div class="bg-success rounded-circle p-2 me-3">
                        <i class="fas fa-sign-in-alt text-white"></i>
                      </div>
                      <div>
                        <div class="fw-bold">Connexion réussie</div>
                        <small class="text-muted">Il y a 2 heures</small>
                      </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                      <div class="bg-info rounded-circle p-2 me-3">
                        <i class="fas fa-user-edit text-white"></i>
                      </div>
                      <div>
                        <div class="fw-bold">Profil mis à jour</div>
                        <small class="text-muted">Il y a 1 jour</small>
                      </div>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="bg-warning rounded-circle p-2 me-3">
                        <i class="fas fa-shield-alt text-white"></i>
                      </div>
                      <div>
                        <div class="fw-bold">Permissions modifiées</div>
                        <small class="text-muted">Il y a 3 jours</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection

@section("scripts")
<script>
  // Données utilisateurs simulées
  
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
      document.getElementById('user-avatar').textContent = user.avatar;
      document.getElementById('user-name').textContent = user.name;
      document.getElementById('user-email').textContent = user.email;
      document.getElementById('user-role').textContent = user.role;
      
      document.getElementById('full-name').textContent = user.name;
      document.getElementById('email').textContent = user.email;
      document.getElementById('phone').textContent = user.phone;
      document.getElementById('department').textContent = user.department;
      
      document.getElementById('status').textContent = user.status;
      document.getElementById('role').textContent = user.role;
      document.getElementById('date-created').textContent = user.dateCreated;
      document.getElementById('last-login').textContent = user.lastLogin;
      document.getElementById('login-count').textContent = user.loginCount;
    }
  }

  function goToPermissions() {
    const userId = getUrlParameter('id') || '1';
    window.location.href = `{{ route("users.editPermission", $user->id)}}`;
  }

  document.addEventListener('DOMContentLoaded', loadUserData);
</script>
@endsection