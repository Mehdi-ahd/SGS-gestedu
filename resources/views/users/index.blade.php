@extends("layouts.app")

@section('styles')
<style>
      .user-card {
        cursor: pointer;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      }

      .user-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
      }

      .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 600;
        color: white;
      }

      .user-avatar.primary { background: linear-gradient(135deg, #177dff, #4dabf7); }
      .user-avatar.success { background: linear-gradient(135deg, #31ce36, #51cf66); }
      .user-avatar.warning { background: linear-gradient(135deg, #ffad46, #ffd43b); }
      .user-avatar.danger { background: linear-gradient(135deg, #f25961, #ff6b6b); }
      .user-avatar.info { background: linear-gradient(135deg, #1572e8, #339af0); }

      .user-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1a2035;
      }

      .user-email {
        color: #6c757d;
        margin-bottom: 1rem;
        font-size: 0.9rem;
      }

      .user-role {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 1rem;
      }

      .role-admin {
        background-color: rgba(23, 125, 255, 0.1);
        color: #177dff;
      }

      .role-moderator {
        background-color: rgba(49, 206, 54, 0.1);
        color: #31ce36;
      }

      .role-user {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
      }

      .status-indicator {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
      }

      .status-active { background-color: #31ce36; }
      .status-inactive { background-color: #f25961; }
      .status-pending { background-color: #ffad46; }

      .stats-card {
        background: linear-gradient(135deg, #177dff, #4dabf7);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
      }

      .stats-card.success {
        background: linear-gradient(135deg, #31ce36, #51cf66);
      }

      .stats-card.warning {
        background: linear-gradient(135deg, #ffad46, #ffd43b);
      }

      .stats-card.danger {
        background: linear-gradient(135deg, #f25961, #ff6b6b);
      }

      .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
      }

      .search-filter-section {
        background: #fff;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      }

      .search-bar {
        position: relative;
      }

      .search-bar input {
        padding-left: 3rem;
        border-radius: 25px;
        border: 1px solid #e3e6f0;
      }

      .search-bar .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
      }

      .filter-btn {
        border-radius: 20px;
        padding: 0.5rem 1.5rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        border: 1px solid #dee2e6;
        background: white;
        color: #6c757d;
        transition: all 0.3s;
      }

      .filter-btn:hover, .filter-btn.active {
        background: #177dff;
        color: white;
        border-color: #177dff;
      }
</style>
@endsection

@section("content")
    <div class="container">
          <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" >
              <div>
                <h3 class="fw-bold mb-3">Gestion des Utilisateurs</h3>
                <h6 class="op-7 mb-2">Administration et gestion des comptes utilisateurs</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Exporter</a>
                <a href="#" class="btn btn-primary btn-round">Ajouter Utilisateur</a>
              </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
              <div class="col-md-3">
                <div class="stats-card">
                  <div class="stats-number">{{ $users->count() }}</div>
                  <div>Total Utilisateurs</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stats-card success">
                  <div class="stats-number"></div>
                  <div>Actifs</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stats-card warning">
                  <div class="stats-number"></div>
                  <div>En Attente</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stats-card danger">
                  <div class="stats-number"></div>
                  <div>Inactifs</div>
                </div>
              </div>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-section">
              <div class="row">
                <div class="col-md-6">
                  <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control" placeholder="Rechercher un utilisateur..." id="user-search">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">Tous</button>
                    <button class="filter-btn" data-filter="active">Actifs</button>
                    <button class="filter-btn" data-filter="pending">En Attente</button>
                    <button class="filter-btn" data-filter="inactive">Inactifs</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Users Grid -->
            <div class="row" id="users-grid">
              @foreach ($users as $user)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-status="active">
                  <div class="card user-card" onclick="window.location.href='{{ route("users.show", $user->id) }}'">
                    <div class="status-indicator status-active"></div>
                      <div class="card-body text-center">
                        <div class="user-avatar primary">JD</div>
                        <div class="user-name">{{$user->getFullName()}}</div>
                        <div class="user-email">{{ $user->email }}</div>
                        <div class="user-role role-admin">{{ $user->role->name }}</div>
                        <small class="text-muted">Connecté il y a 2h</small>
                      </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
@endsection

@section("scripts")
<script>
      // Recherche et filtres
      document.addEventListener('DOMContentLoaded', function() {
        // Recherche
        const searchInput = document.getElementById('user-search');
        if (searchInput) {
          searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const userCards = document.querySelectorAll('.user-card');
            
            userCards.forEach(card => {
              const userName = card.querySelector('.user-name').textContent.toLowerCase();
              const userEmail = card.querySelector('.user-email').textContent.toLowerCase();
              
              if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                card.closest('.col-lg-3').style.display = '';
              } else {
                card.closest('.col-lg-3').style.display = 'none';
              }
            });
          });
        }
        
        // Filtres
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
          btn.addEventListener('click', function() {
            // Retirer active de tous les boutons
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            const userCards = document.querySelectorAll('[data-status]');
            
            userCards.forEach(card => {
              if (filter === 'all' || card.dataset.status === filter) {
                card.style.display = '';
              } else {
                card.style.display = 'none';
              }
            });
          });
        });
      });
</script>

@endsection