@extends('layouts.app')

@section('title', 'Gestion des parents')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des parents</h1>
        <a href="{{ route('parents.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Ajouter un parent
        </a>
    </div>

    <!-- Filtres de recherche -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rechercher des parents</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('parents.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Nom / Prénom / Email</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="children" class="form-label">Élève</label>
                    <select class="form-select" id="children" name="children">
                        <option value="">Tous les élèves</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->full_name}}</option>
                        @endforeach
                        
                        <option value="2">Dubois Marie</option>
                        <option value="3">Martin Lucas</option>
                        <option value="4">Bernard Emma</option>
                        <option value="5">Petit Hugo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="classroom" class="form-label">Classe</label>
                    <select class="form-select" id="classroom" name="classroom">
                        <option value="">Toutes les classes</option>
                        @foreach ($study_levels as $study_level)
                            <option value="{{ $study_level->id }}">{{ $study_level->specification}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Statut</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tous</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
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

    <!-- Liste des parents -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des parents</h6>
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
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="parents-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Enfants</th>
                            <th>Relation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($parents as $parent)
                            <tr>
                                <td>{{ $parent->id }}</td>
                                <td>{{ $parent->lastname }}</td>
                                <td>{{ $parent->firstname }}</td>
                                <td>{{ $parent->email }}</td>
                                <td>{{ $parent->phone }}</td>
                                <td>
                                    @if (!$parent->students->isEmpty())
                                        @foreach ($parent->students as $parent->student)
                                            <span class="badge bg-info">{{ $parent->student->full_name }} ({{ $parent->student->firstname }})</span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-info">Aucun enfant inscrit</span>
                                    @endif
                                    
                                </td>
                                <td>{{ ($parent->sex === "M") ? "Père" : "Mère" }}</td>
                                <td>
                                    <a href="{{ route('parents.show', $parent->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('parents.destroy', $parent->id) }}" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal1">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@for ($i = 1; $i <= 5; $i++)
<div class="modal fade" id="deleteModal{{ $i }}" tabindex="-1" aria-labelledby="deleteModal{{ $i }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModal{{ $i }}Label">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce parent ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('parents.destroy', $i) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endfor
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // DataTable initialization (if you want to use DataTables)
        // $('#parents-table').DataTable();
    });
</script>
@endsection