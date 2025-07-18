@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Student Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">Student Details</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex">
        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary me-2">
            <i class="fas fa-edit me-1"></i> Editer
        </a>
        <button class="btn btn-outline-primary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> Imprimer
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-lg mx-auto mb-3">
                    <img src="{{ Storage::url($student_documents->where("document_type", "Photo d'identité")->first()->document_path)  ?? asset('assets/img/default.webp') }}" alt="Photo de l'élève" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <h4 class="card-title">{{ $student->getFullName() }} </h4>
                <p class="text-muted mb-1">ID: {{ $student->id }}</p>
                <p class="text-muted mb-3">Sa classe: {{ $student->inscriptions()->where("school_year_id", date("Y") . "-" . date("Y")+1)->first()->study_level->specification }}</p>
                
                <div class="d-flex justify-content-center mb-3">
                    <a href="#" class="btn btn-sm btn-outline-primary me-2">
                        <i class="fas fa-envelope me-1"></i> Message
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-id-card me-1"></i> ID Card
                    </a>
                </div>
                
                <div class="list-group list-group-flush text-start">
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Date de naissance:</span>
                        <span>{{ $student->birthday->format("d/m/Y")}}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Genre:</span>
                        <span>{{$student->sex}}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Email:</span>
                        <span>{{ ($student->email) ? $student->email : "Aucun mail"}}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">N° de téléphone:</span>
                        <span>{{ ($student->phone) ? $student->phone : "Non définie" }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Date d'admission:</span>
                        <span>{{ $student->created_at->format("d/m/Y") }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Informations sur les parents</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <span>MS</span>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ ($father) ? $father->getFullName() : "Aucune père enregistrée"}}</h6>
                        <span class="text-muted">Information du père</span>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Email:</span>
                        <span>{{ ($father) ? $father->email : "Indisponible" }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">N° de téléphone:</span>
                        <span>{{ ($father) ? $father->phone : "Indisponible" }}</span>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <span>AS</span>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ ($mother) ? $mother->getFullName() : "Aucune mère enregistrée"}}</h6>
                        <span class="text-muted">Information de la mère</span>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Email:</span>
                        <span>{{ ($mother) ? $mother->email : "Indisponible" }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">N° de téléphone:</span>
                        <span>{{ ($mother) ? $mother->phone : "Indisponible" }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-0">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active link-dark" id="academic-tab" data-bs-toggle="tab" href="#academic" role="tab" aria-controls="academic" aria-selected="true">
                            <i class="fas fa-graduation-cap me-1"></i> Données académiques
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-dark" id="attendance-tab" data-bs-toggle="tab" href="#attendance" role="tab" aria-controls="attendance" aria-selected="false">
                            <i class="fas fa-clipboard-check me-1"></i> Présence
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-dark" id="examinations-tab" data-bs-toggle="tab" href="#examinations" role="tab" aria-controls="examinations" aria-selected="false">
                            <i class="fas fa-file-alt me-1"></i> Compositions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-dark" id="fees-tab" data-bs-toggle="tab" href="#fees" role="tab" aria-controls="fees" aria-selected="false">
                            <i class="fas fa-money-bill-wave me-1"></i> Frais de Scolarité
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-dark" id="documents-tab" data-bs-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">
                            <i class="fas fa-file me-1"></i> Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-dark" id="cursus-tab" data-bs-toggle="tab" href="#cursus" role="tab" aria-controls="cursus" aria-selected="false">
                            <i class="fas fa-file me-1"></i> Cursus
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                        <h5 class="mb-3">Emploi du temps</h5>
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="table-light">
                                    <tr>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Room</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Monday</td>
                                        <td>08:00 - 09:30</td>
                                        <td>Mathematics</td>
                                        <td>John Davis</td>
                                        <td>Room 101</td>
                                    </tr>
                                    <tr>
                                        <td>Monday</td>
                                        <td>09:45 - 11:15</td>
                                        <td>English</td>
                                        <td>Sarah Johnson</td>
                                        <td>Room 102</td>
                                    </tr>
                                    <tr>
                                        <td>Monday</td>
                                        <td>11:30 - 13:00</td>
                                        <td>Physics</td>
                                        <td>Robert Brown</td>
                                        <td>Room 103</td>
                                    </tr>
                                    <tr>
                                        <td>Tuesday</td>
                                        <td>08:00 - 09:30</td>
                                        <td>Chemistry</td>
                                        <td>Emily Wilson</td>
                                        <td>Lab 201</td>
                                    </tr>
                                    <tr>
                                        <td>Tuesday</td>
                                        <td>09:45 - 11:15</td>
                                        <td>History</td>
                                        <td>Michael Thomas</td>
                                        <td>Room 105</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <h5 class="mt-4 mb-3">Matières</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-0">Mathematics</h6>
                                                <small class="text-muted">John Davis</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-success">90%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-0">English</h6>
                                                <small class="text-muted">Sarah Johnson</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-success">85%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-0">Physics</h6>
                                                <small class="text-muted">Robert Brown</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-warning">75%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-0">Chemistry</h6>
                                                <small class="text-muted">Emily Wilson</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-success">88%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-0">History</h6>
                                                <small class="text-muted">Michael Thomas</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-success">92%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Paiement des frais </h5>
                            <div>
                                <select class="form-select form-select-sm" id="attendanceMonth">
                                    <option value="5">May 2025</option>
                                    <option value="4">April 2025</option>
                                    <option value="3">March 2025</option>
                                    <option value="2">February 2025</option>
                                    <option value="1">January 2025</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h3 class="mb-0 text-success">92%</h3>
                                                <p class="text-muted mb-0">Attendance Rate</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h3 class="mb-0">22</h3>
                                                <p class="text-muted mb-0">Present Days</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h3 class="mb-0 text-danger">2</h3>
                                                <p class="text-muted mb-0">Absent Days</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h3 class="mb-0 text-warning">0</h3>
                                                <p class="text-muted mb-0">Late Days</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover border">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Subject</th>
                                                <th>Teacher</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>May 19, 2025</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>Mathematics</td>
                                                <td>John Davis</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>May 18, 2025</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>English</td>
                                                <td>Sarah Johnson</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>May 17, 2025</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>Physics</td>
                                                <td>Robert Brown</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>May 16, 2025</td>
                                                <td><span class="badge bg-danger">Absent</span></td>
                                                <td>Chemistry</td>
                                                <td>Emily Wilson</td>
                                                <td>Sick leave</td>
                                            </tr>
                                            <tr>
                                                <td>May 15, 2025</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>History</td>
                                                <td>Michael Thomas</td>
                                                <td>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="examinations" role="tabpanel" aria-labelledby="examinations-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Examination Results</h5>
                            <div>
                                <select class="form-select form-select-sm" id="examPeriod">
                                    <option value="1">First Term 2025</option>
                                    <option value="2">Second Term 2024</option>
                                    <option value="3">Final Term 2024</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <h6 class="mb-0">First Term Examination</h6>
                                        <small class="text-muted">May 2025</small>
                                    </div>
                                    <div>
                                        <h6 class="text-success mb-0">Grade: A</h6>
                                        <small class="text-muted">Average: 87%</small>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover border">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Subject</th>
                                                <th>Marks Obtained</th>
                                                <th>Max Marks</th>
                                                <th>Percentage</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Mathematics</td>
                                                <td>90</td>
                                                <td>100</td>
                                                <td>90%</td>
                                                <td><span class="badge bg-success">A</span></td>
                                            </tr>
                                            <tr>
                                                <td>English</td>
                                                <td>85</td>
                                                <td>100</td>
                                                <td>85%</td>
                                                <td><span class="badge bg-success">B+</span></td>
                                            </tr>
                                            <tr>
                                                <td>Physics</td>
                                                <td>75</td>
                                                <td>100</td>
                                                <td>75%</td>
                                                <td><span class="badge bg-warning">B</span></td>
                                            </tr>
                                            <tr>
                                                <td>Chemistry</td>
                                                <td>88</td>
                                                <td>100</td>
                                                <td>88%</td>
                                                <td><span class="badge bg-success">B+</span></td>
                                            </tr>
                                            <tr>
                                                <td>History</td>
                                                <td>92</td>
                                                <td>100</td>
                                                <td>92%</td>
                                                <td><span class="badge bg-success">A</span></td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th>Total</th>
                                                <th>430</th>
                                                <th>500</th>
                                                <th>86%</th>
                                                <th><span class="badge bg-success">A</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="mb-3">Upcoming Examinations</h5>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Mathematics Mid-Term</h6>
                                    <small>3 days</small>
                                </div>
                                <p class="mb-1">May 22, 2025, 10:00 AM</p>
                                <small class="text-muted">Room 101 - Duration: 2 hours</small>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">English Essay</h6>
                                    <small>1 week</small>
                                </div>
                                <p class="mb-1">May 26, 2025, 9:00 AM</p>
                                <small class="text-muted">Room 102 - Duration: 1.5 hours</small>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Physics Practical</h6>
                                    <small>2 weeks</small>
                                </div>
                                <p class="mb-1">June 3, 2025, 9:00 AM</p>
                                <small class="text-muted">Lab 201 - Duration: 3 hours</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="fees" role="tabpanel" aria-labelledby="fees-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Fee Information</h5>
                            <div>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-invoice-dollar me-1"></i> Fee Statement
                                </a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Fee Summary</h6>
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between px-0">
                                                <span>Total Fee</span>
                                                <span>$5,000.00</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between px-0">
                                                <span>Amount Paid</span>
                                                <span class="text-success">$3,750.00</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between px-0">
                                                <span>Balance Due</span>
                                                <span class="text-danger">$1,250.00</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between px-0">
                                                <span>Status</span>
                                                <span class="badge bg-warning">Partially Paid</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Next Payment</h6>
                                        <div class="d-flex justify-content-between mb-3">
                                            <div>
                                                <h4 class="mb-0">$1,250.00</h4>
                                                <small class="text-muted">Due Date: June 15, 2025</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-danger">Due in 27 days</span>
                                            </div>
                                        </div>
                                        <button class="btn btn-success w-100">
                                            <i class="fas fa-credit-card me-1"></i> Make Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="mb-3">Payment History</h5>
                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Receipt No.</th>
                                        <th>Fee Type</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>May 15, 2025</td>
                                        <td>RCP-2025-001</td>
                                        <td>Tuition Fee</td>
                                        <td>$1,250.00</td>
                                        <td>Credit Card</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td>Feb 15, 2025</td>
                                        <td>RCP-2025-002</td>
                                        <td>Tuition Fee</td>
                                        <td>$1,250.00</td>
                                        <td>Bank Transfer</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td>Nov 15, 2024</td>
                                        <td>RCP-2024-123</td>
                                        <td>Tuition Fee</td>
                                        <td>$1,250.00</td>
                                        <td>Bank Transfer</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td>Aug 15, 2024</td>
                                        <td>RCP-2024-089</td>
                                        <td>Tuition Fee</td>
                                        <td>$1,250.00</td>
                                        <td>Credit Card</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    {{-- Section des documents de l'élève --}}
                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Student Documents</h5>
                            <div>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                                    <i class="fas fa-upload me-1"></i> Upload Document
                                </button>
                            </div>
                        </div>
                        @foreach ($student_documents as $student_document)
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        
                                            <div>
                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                                <span>{{ $student_document->document_type }}</span>
                                            </div>
                                        
                                        <div>
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-1">Ajouté le {{ $student_document->created_at->format("d/m/Y") . " à " .$student_document->created_at->format('H:i:s')}}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Section du cursus scolaire de l'eleve --}}
                    <div class="tab-pane fade" id="cursus" role="tabpanel" aria-labelledby="cursus-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Cursus académique</h5>
                            <div>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                                    <i class="fas fa-upload me-1"></i> Upload Document
                                </button>
                            </div>
                        </div>
                        
                        <div class="list-group">
                            @foreach ($cursi as $cursus)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <span>{{ $cursus->study_level->specification }}</span>
                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-1">Année scolaire: {{ $cursus->school_year_id }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Document Modal -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadDocumentModalLabel">Upload Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="documentType" class="form-label">Document Type</label>
                        <select class="form-select" id="documentType" required>
                            <option value="" selected disabled>Select Document Type</option>
                            <option value="birth_certificate">Birth Certificate</option>
                            <option value="medical_records">Medical Records</option>
                            <option value="previous_school_records">Previous School Records</option>
                            <option value="passport_photo">Passport Photo</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="documentName" class="form-label">Document Name</label>
                        <input type="text" class="form-control" id="documentName" required>
                    </div>
                    <div class="mb-3">
                        <label for="documentFile" class="form-label">Select File</label>
                        <input type="file" class="form-control" id="documentFile" required>
                        <div class="form-text">Max file size: 5MB. Supported formats: PDF, JPG, PNG</div>
                    </div>
                    <div class="mb-3">
                        <label for="documentDescription" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="documentDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</div>
@endsection