@extends('layouts.app')

@section('title', 'Take Attendance')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Take Attendance</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Faire la présence</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-outline-primary me-2" id="printAttendance">
            <i class="fas fa-print me-1"></i> Imprimer
        </button>
        <button type="submit" form="attendanceForm" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Sauvegarder la liste 
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="class" class="form-label">Niveaux d'études</label>
                <select class="form-select" id="class" name="study_level_id">
                    @foreach ($studyLevels as $studyLevel)
                        <option value="{{ $studyLevel->id }}" >{{ $studyLevel->specification}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="subject" class="form-label">Subject</label>
                <select class="form-select" id="subject" name="subject">
                    <option value="1" selected>Mathematics</option>
                    <option value="2">English</option>
                    <option value="3">Physics</option>
                    <option value="4">Chemistry</option>
                    <option value="5">Biology</option>
                </select>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label for="period" class="form-label">Period</label>
                <select class="form-select" id="period" name="period">
                    <option value="1" selected>1st Period (8:00 - 9:30)</option>
                    <option value="2">2nd Period (9:45 - 11:15)</option>
                    <option value="3">3rd Period (11:30 - 13:00)</option>
                    <option value="4">4th Period (13:45 - 15:15)</option>
                    <option value="5">5th Period (15:30 - 17:00)</option>
                </select>
            </div>
        </div>

        <div class="alert alert-info">
            <div class="d-flex">
                <div class="me-2">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <strong>Class Information:</strong>
                    <p class="mb-0">10th Grade - Section A | Mathematics | Teacher: John Davis | Total Students: 30</p>
                </div>
            </div>
        </div>

        <form id="attendanceForm" action="#" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Roll No.</th>
                            <th width="30%">Student Name</th>
                            <th width="15%">Status</th>
                            <th width="40%">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>STD-001</td>
                            <td>John Doe</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="attendance[1]" id="present_1" value="present" checked>
                                    <label class="btn btn-outline-success" for="present_1">Present</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[1]" id="absent_1" value="absent">
                                    <label class="btn btn-outline-danger" for="absent_1">Absent</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[1]" id="late_1" value="late">
                                    <label class="btn btn-outline-warning" for="late_1">Late</label>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="remarks[1]" placeholder="Enter remarks (optional)">
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>STD-002</td>
                            <td>Jane Smith</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="attendance[2]" id="present_2" value="present" checked>
                                    <label class="btn btn-outline-success" for="present_2">Present</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[2]" id="absent_2" value="absent">
                                    <label class="btn btn-outline-danger" for="absent_2">Absent</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[2]" id="late_2" value="late">
                                    <label class="btn btn-outline-warning" for="late_2">Late</label>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="remarks[2]" placeholder="Enter remarks (optional)">
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>STD-003</td>
                            <td>Michael Brown</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="attendance[3]" id="present_3" value="present" checked>
                                    <label class="btn btn-outline-success" for="present_3">Present</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[3]" id="absent_3" value="absent">
                                    <label class="btn btn-outline-danger" for="absent_3">Absent</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[3]" id="late_3" value="late">
                                    <label class="btn btn-outline-warning" for="late_3">Late</label>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="remarks[3]" placeholder="Enter remarks (optional)">
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>STD-004</td>
                            <td>Emily Johnson</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="attendance[4]" id="present_4" value="present" checked>
                                    <label class="btn btn-outline-success" for="present_4">Present</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[4]" id="absent_4" value="absent">
                                    <label class="btn btn-outline-danger" for="absent_4">Absent</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[4]" id="late_4" value="late">
                                    <label class="btn btn-outline-warning" for="late_4">Late</label>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="remarks[4]" placeholder="Enter remarks (optional)">
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>STD-005</td>
                            <td>Robert Wilson</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="attendance[5]" id="present_5" value="present" checked>
                                    <label class="btn btn-outline-success" for="present_5">Present</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[5]" id="absent_5" value="absent">
                                    <label class="btn btn-outline-danger" for="absent_5">Absent</label>
                                    
                                    <input type="radio" class="btn-check" name="attendance[5]" id="late_5" value="late">
                                    <label class="btn btn-outline-warning" for="late_5">Late</label>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="remarks[5]" placeholder="Enter remarks (optional)">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Attendance Summary</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Students:</span>
                                <span>30</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Present:</span>
                                <span class="text-success" id="presentCount">30</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Absent:</span>
                                <span class="text-danger" id="absentCount">0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Late:</span>
                                <span class="text-warning" id="lateCount">0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Attendance Rate:</span>
                                <span class="text-primary" id="attendanceRate">100%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Additional Notes</h6>
                            <textarea class="form-control" rows="4" name="additional_notes" placeholder="Enter any additional notes about this session (optional)"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="reset" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-undo me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Attendance
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Update attendance summary
        function updateAttendanceSummary() {
            const totalStudents = 30;
            const presentCount = $('input[value="present"]:checked').length;
            const absentCount = $('input[value="absent"]:checked').length;
            const lateCount = $('input[value="late"]:checked').length;
            const attendanceRate = Math.round((presentCount + lateCount) / totalStudents * 100);
            
            $('#presentCount').text(presentCount);
            $('#absentCount').text(absentCount);
            $('#lateCount').text(lateCount);
            $('#attendanceRate').text(attendanceRate + '%');
        }
        
        // Listen for changes to attendance status
        $('input[name^="attendance"]').change(function() {
            updateAttendanceSummary();
        });
        
        // Handle class change
        $('#class, #subject, #date, #period').change(function() {
            // In a real application, this would fetch the student list for the selected class
            // For this demo, we'll just show an alert
            alert('In a real application, this would fetch the student list for the selected class, subject, date, and period.');
        });
        
        // Handle print button
        $('#printAttendance').click(function() {
            window.print();
        });
        
        // Handle form submission
        $('#attendanceForm').submit(function(e) {
            e.preventDefault();
            alert('Attendance saved successfully!');
        });
    });
</script>
@endsection

@section('styles')
<style>
    @media print {
        .btn-group, input[type="text"], button, .form-select, .form-control {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
        
        .btn-check:checked + .btn-outline-success {
            background-color: #d1e7dd !important;
            color: #0f5132 !important;
            border-color: #0f5132 !important;
        }
        
        .btn-check:checked + .btn-outline-danger {
            background-color: #f8d7da !important;
            color: #842029 !important;
            border-color: #842029 !important;
        }
        
        .btn-check:checked + .btn-outline-warning {
            background-color: #fff3cd !important;
            color: #664d03 !important;
            border-color: #664d03 !important;
        }
    }
</style>
@endsection
@endsection