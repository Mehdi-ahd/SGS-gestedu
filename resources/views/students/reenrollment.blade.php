@extends('layouts.app')

@section('title', 'Réinscription des anciens élèves')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Réinscription des anciens élèves</h1>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Élèves</a></li>
                <li class="breadcrumb-item active" aria-current="page">Réinscription</li>
            </ol>
        </nav>
    </div>

    <!-- Filtres de recherche -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rechercher des élèves</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('students.reenrollment') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Nom / Prénom / Email</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="level" class="form-label">Niveau d'étude</label>
                    <select class="form-select" id="level" name="level">
                        <option value="">Tous les niveaux</option>
                        @foreach ($study_levels as $study_level)
                            <option value="{{$study_level->id}}" {{ request('level') == $study_level->id ? 'selected' : '' }}>
                                {{$study_level->specification}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sex" class="form-label">Sexe</label>
                    <select class="form-select" id="sex" name="sex">
                        <option value="">Tous</option>
                        <option value="M" {{ request('sex') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ request('sex') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i> Rechercher
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-sync-alt me-2"></i> Réinitialiser
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des élèves -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des anciens élèves</h6>
            <div>
                <button class="btn btn-sm btn-outline-primary me-2">
                    <i class="fas fa-file-csv me-1"></i> Exporter CSV
                </button>
                <button class="btn btn-sm btn-outline-success me-2">
                    <i class="fas fa-file-excel me-1"></i> Exporter Excel
                </button>
                <button class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-file-pdf me-1"></i> Exporter PDF
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session("error"))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="students-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>
                                    <a href="{{ route('students.reenrollment', array_merge(request()->except(['sort_by', 'sort_order']), ['sort_by' => 'lastname', 'sort_order' => (request('sort_by') == 'lastname' && request('sort_order') == 'asc') ? 'desc' : 'asc'])) }}" class="text-primary">
                                        Nom
                                        @if(request('sort_by') == 'lastname')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fas fa-sort text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('students.reenrollment', array_merge(request()->except(['sort_by', 'sort_order']), ['sort_by' => 'firstname', 'sort_order' => (request('sort_by') == 'firstname' && request('sort_order') == 'asc') ? 'desc' : 'asc'])) }}" class="text-primary">
                                        Prénom
                                        @if(request('sort_by') == 'firstname')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fas fa-sort text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('students.reenrollment', array_merge(request()->except(['sort_by', 'sort_order']), ['sort_by' => 'birthday', 'sort_order' => (request('sort_by') == 'birthday' && request('sort_order') == 'asc') ? 'desc' : 'asc'])) }}" class="text-primary">
                                        Date de naissance
                                        @if(request('sort_by') == 'birthday')
                                            <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fas fa-sort text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Sexe</th>
                                <th>Niveau actuel</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->lastname }}</td>
                                    <td>{{ $student->firstname }}</td>
                                    <td>{{ $student->birthday->format("d/m/Y") }}</td>
                                    <td>{{ $student->sex }}</td>
                                    <td>{{ $student->inscriptions()->where("school_year_id", date("Y") . "-" . date("Y")+1)->first()->study_level->specification ?? 'Non défini' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#reenrollModal{{ $student->id }}">
                                            <i class="fas fa-user-graduate"></i> Réinscrire
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <!-- Bouton Précédent -->
                        @if ($students->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $students->appends(request()->except('page'))->previousPageUrl() }}" tabindex="-1">Précédent</a>
                            </li>
                        @endif
                        
                        <!-- Numéros de pages -->
                        @for ($i = 1; $i <= $students->lastPage(); $i++)
                            @if ($i <= 3 || $i >= $students->lastPage() - 2 || abs($i - $students->currentPage()) < 2)
                                <li class="page-item {{ $students->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $students->appends(request()->except('page'))->url($i) }}">{{ $i }}</a>
                                </li>
                            @elseif (abs($i - $students->currentPage()) == 2)
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">...</a>
                                </li>
                            @endif
                        @endfor
                        
                        <!-- Bouton Suivant -->
                        @if ($students->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $students->appends(request()->except('page'))->nextPageUrl() }}">Suivant</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-disabled="true">Suivant</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            @else
                <div class="alert alert-info">
                    Aucun élève trouvé pour ces critères de recherche.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modals de réinscription pour chaque élève -->
@foreach ($students as $student)
<div class="modal fade" id="reenrollModal{{ $student->id }}" tabindex="-1" aria-labelledby="reenrollModal{{ $student->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reenrollModal{{ $student->id }}Label">Réinscription de {{ $student->firstname }} {{ $student->lastname }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('students.processReenrollment', $student->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="study_level_id" class="form-label">Niveau d'étude</label>
                            <select class="form-select" id="study_level_id" name="study_level_id" required>
                                <option value="">Sélectionner un niveau</option>
                                @foreach ($study_levels as $study_level)
                                    <option value="{{ $study_level->id }}" {{ $student->study_level_id == $study_level->id ? 'selected' : '' }}>
                                        {{ $study_level->specification }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="registration_date" class="form-label">Date de réinscription</label>
                            <input type="date" class="form-control" id="registration_date" name="registration_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="hidden" name="school_year_id" value="{{ date("Y") . "-" . (date("Y")+1)}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Réinscrire</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // JavaScript pour la gestion dynamique des classes en fonction du niveau d'étude
        $('select[name="study_level_id"]').change(function() {
            const studyLevelId = $(this).val();
            if (studyLevelId) {
                // Charger dynamiquement les classes correspondant au niveau sélectionné
                $.ajax({
                    url: '/api/classrooms-by-level/' + studyLevelId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let options = '<option value="">Sélectionner une classe</option>';
                        if (data.length > 0) {
                            data.forEach(function(classroom) {
                                options += '<option value="' + classroom.id + '">' + classroom.name + '</option>';
                            });
                        }
                        $('select[name="classroom_id"]').html(options);
                    },
                    error: function() {
                        console.error('Erreur lors du chargement des classes');
                    }
                });
            } else {
                $('select[name="classroom_id"]').html('<option value="">Sélectionner une classe</option>');
            }
        });
        
        // Initialiser DataTable pour une meilleure expérience utilisateur
        $('#students-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
            },
            "pageLength": 10,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthChange": false,
            "searching": false // La recherche est déjà gérée par notre formulaire personnalisé
        });
    });
</script>
@endsection