@extends('layouts.parent')

@section('title', 'Détails académiques - ' . $child->firstname . ' - ' . $year)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h1 class="h3 mb-2 mb-md-0 text-gray-800">
                <i class="fas fa-graduation-cap me-2"></i>
                {{ $child->getFullName() }}
            </h1>
            <p class="text-muted mb-0">Détails académiques - Année {{ $year }}</p>
        </div>
        
        <div class="d-flex flex-column flex-sm-row gap-2">
            <a href="{{ route('parent.child.details', $child->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour aux détails
            </a>
        </div>
    </div>

    <!-- Informations générales du cursus -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle me-2"></i>
                Informations générales - Année {{ $year }}
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label text-muted">Niveau d'étude</label>
                    <p class="h6">{{ $inscription->study_level->specification ?? 'N/A' }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label text-muted">Classe/Groupe</label>
                    <p class="h6">{{ $inscription->group->id ?? 'N/A' }}</p>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label text-muted">Moyenne générale</label>
                    @if($inscription->final_average)
                        <p class="h6">
                            <span class="badge {{ $inscription->final_average >= 10 ? 'bg-success' : 'bg-danger' }} fs-6">
                                {{ number_format($inscription->final_average, 2) }}/20
                            </span>
                        </p>
                    @else
                        <p class="h6 text-muted">En cours</p>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label text-muted">Verdict</label>
                    @if($inscription->verdict)
                        @if($inscription->verdict == 'passe')
                            <p class="h6">
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check me-1"></i>Admis
                                </span>
                            </p>
                        @elseif($inscription->verdict == 'redouble')
                            <p class="h6">
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-redo me-1"></i>Redouble
                                </span>
                            </p>
                        @elseif($inscription->verdict == 'exclu')
                            <p class="h6">
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times me-1"></i>Exclu
                                </span>
                            </p>
                        @endif
                    @else
                        <p class="h6 text-muted">En cours</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Détails par trimestre -->
    <div class="row">
        @for($trimester = 1; $trimester <= 3; $trimester++)
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-gradient-primary text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ $trimester }}{{ $trimester == 1 ? 'er' : 'ème' }} Trimestre
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $trimesterData = $trimesterDetails[$trimester] ?? null;
                        @endphp
                        
                        @if($trimesterData && $trimesterData['subjects']->count() > 0)
                            <!-- Moyenne générale du trimestre -->
                            <div class="text-center mb-3">
                                <h5 class="text-primary mb-1">Moyenne générale</h5>
                                <span class="badge {{ $trimesterData['average'] >= 10 ? 'bg-success' : 'bg-danger' }} fs-6">
                                    {{ number_format($trimesterData['average'], 2) }}/20
                                </span>
                            </div>

                            <hr>

                            <!-- Notes par matière -->
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Matière</th>
                                            <th class="text-center">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trimesterData['subjects'] as $subject => $note)
                                            <tr>
                                                <td>
                                                    <small class="fw-bold">{{ $subject }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $note >= 10 ? 'bg-success' : 'bg-warning' }} badge-sm">
                                                        {{ number_format($note, 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Rang et observations -->
                            @if(isset($trimesterData['rank']))
                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-trophy me-1"></i>
                                        Rang: {{ $trimesterData['rank'] }}/{{ $trimesterData['total_students'] ?? 'N/A' }}
                                    </small>
                                </div>
                            @endif

                            @if(isset($trimesterData['observation']))
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <strong>Observation:</strong> {{ $trimesterData['observation'] }}
                                    </small>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-clock fa-2x text-gray-300 mb-2"></i>
                                <p class="text-muted small mb-0">
                                    @if($trimester == 1)
                                        Premier trimestre
                                    @elseif($trimester == 2)
                                        Deuxième trimestre
                                    @else
                                        Troisième trimestre
                                    @endif
                                    <br>
                                    Pas encore de données
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!-- Graphique de progression (optionnel) -->
    {{-- @if($trimesterDetails && count($trimesterDetails) > 1)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-line me-2"></i>
                Évolution des notes
            </h6>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height: 300px;">
                <canvas id="progressChart"></canvas>
            </div>
        </div>
    </div>
    @endif --}}

    <!-- Informations supplémentaires -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-check me-2"></i>
                        Assiduité
                    </h6>
                </div>
                <div class="card-body">
                    @if(isset($attendance))
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="text-success h4">{{ $attendance['present'] ?? 0 }}</div>
                                <div class="small text-muted">Présent</div>
                            </div>
                            <div class="col-4">
                                <div class="text-warning h4">{{ $attendance['late'] ?? 0 }}</div>
                                <div class="small text-muted">Retards</div>
                            </div>
                            <div class="col-4">
                                <div class="text-danger h4">{{ $attendance['absent'] ?? 0 }}</div>
                                <div class="small text-muted">Absences</div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted text-center">Données d'assiduité non disponibles</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comment me-2"></i>
                        Observations générales
                    </h6>
                </div>
                <div class="card-body">
                    @if($inscription->general_observation)
                        <p class="text-muted">{{ $inscription->general_observation }}</p>
                    @else
                        <p class="text-muted text-center">Aucune observation générale</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- @if($trimesterDetails && count($trimesterDetails) > 1)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique de progression
        const ctx = document.getElementById('progressChart').getContext('2d');
        
        const trimesterLabels = [];
        const averageData = [];
        
        @foreach($trimesterDetails as $trim => $data)
            trimesterLabels.push('T{{ $trim }}');
            averageData.push({{ $data['average'] ?? 0 }});
        @endforeach
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trimesterLabels,
                datasets: [{
                    label: 'Moyenne générale',
                    data: averageData,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Moyenne de passage (10)',
                    data: Array(trimesterLabels.length).fill(10),
                    borderColor: '#e74a3b',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20,
                        ticks: {
                            stepSize: 2
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    });
</script>
@endif --}}
@endsection
