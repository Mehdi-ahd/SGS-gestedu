@extends('layouts.app')

@section('title', 'Gestion des étudiants')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des étudiants</h1>
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Ajouter un étudiant
        </a>
    </div>
    
    @if (session("success"))
        <div class="container alert alert-success">
            {{ session("success") }}
        </div>
    @endif
    <!-- Filtres de recherche -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rechercher des étudiants</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('students.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Nom / Prénom / Email</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="level" class="form-label">Niveau d'étude</label>
                    <select class="form-select" id="level" name="level">
                        <option value="">Tous les niveaux</option>
                        @foreach ($study_levels as $study_level)
                            <option value="{{ $study_level->id }}" {{ request('level') == $study_level->id ? 'selected' : '' }}>
                                {{ $study_level->specification }}
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

    <!-- Liste des étudiants -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des étudiants</h6>
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
            @if ($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="students-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Date et lieu de naissance</th>
                                <th>Sexe</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->lastname }}</td>
                                    <td>{{ $student->firstname }}</td>
                                    <td>{{ $student->birthday ? $student->birthday->format("d/m/Y") : '' }}</td>
                                    <td>{{ $student->sex }}</td>
                                    <td>{{ ($student->email) ? $student->email : "Pas d'email" }}</td>
                                    <td>{{ ($student->phone) ? $student->phone : "Non définie" }}</td>
                                    <td>
                                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->id }}">
                                            <i class="fas fa-trash"></i>
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
                <div class="alert alert-info">Aucun élève inscrit pour l'instant</div>
            @endif 
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach ($students as $student)
<div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $student->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModal{{ $student->id }}Label">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet étudiant ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Gestion du bouton reset pour rediriger vers la page sans paramètres
        $('button[type="reset"]').click(function(e) {
            e.preventDefault();
            window.location.href = "{{ route('students.index') }}";
        });
    });
</script>
@endsection