@extends('layouts.app')

@section('title', 'Gestion des enseignants')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des enseignants</h1>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Ajouter un enseignant
        </a>
    </div>

    <!-- Filtres de recherche -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rechercher des enseignants</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('teachers.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Nom / Prénom / Email</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="subject" class="form-label">Matière</label>
                    <select class="form-select" id="subject" name="subject">
                        <option value="">Toutes les matières</option>
                        <option value="1">Mathématiques</option>
                        <option value="2">Français</option>
                        <option value="3">Histoire-Géographie</option>
                        <option value="4">Sciences</option>
                        <option value="5">Anglais</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="experience" class="form-label">Expérience</label>
                    <select class="form-select" id="experience" name="experience">
                        <option value="">Tous</option>
                        <option value="1-3">1-3 ans</option>
                        <option value="4-7">4-7 ans</option>
                        <option value="8-12">8-12 ans</option>
                        <option value="13+">13+ ans</option>
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

    <!-- Liste des enseignants -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des enseignants</h6>
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
            @if (!$teachers->isEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="teachers-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Matières enseignées</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Qualifications</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->id }}</td>
                                    <td>{{ $teacher->lastname }}</td>
                                    <td>{{ $teacher->firstname }}</td>
                                    <td>Mathématiques, Physique</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>Doctorat en Mathématiques</td>
                                    <td>
                                        <a href="{{ route('teachers.show', $teacher->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal1">
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
            @else
                <div class="d-flex justify-content-center">
                    <div class="alert alert-info">
                        Aucun professeur enregistré
                    </div>
                </div>
            @endif
            
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
                Êtes-vous sûr de vouloir supprimer cet enseignant ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('teachers.destroy', $i) }}" method="POST" style="display: inline-block;">
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
        // $('#teachers-table').DataTable();
    });
</script>
@endsection