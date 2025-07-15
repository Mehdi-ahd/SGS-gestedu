@extends('layouts.app')

@section('title', 'Create Examination')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Create Examination</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Examinations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Examination</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Examination Details</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Examination Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Examination Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" selected disabled>Select Type</option>
                                <option value="Mid-Term">Mid-Term</option>
                                <option value="Final-Term">Final-Term</option>
                                <option value="Quiz">Quiz</option>
                                <option value="Assignment">Assignment</option>
                                <option value="Project">Project</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                            <select class="form-select" id="class_id" name="class_id" required>
                                <option value="" selected disabled>Select Class</option>
                                <option value="1">10th Grade - Section A</option>
                                <option value="2">10th Grade - Section B</option>
                                <option value="3">11th Grade - Section A</option>
                                <option value="4">11th Grade - Section B</option>
                                <option value="5">12th Grade - Section A</option>
                                <option value="6">12th Grade - Section B</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                            <select class="form-select" id="subject_id" name="subject_id" required>
                                <option value="" selected disabled>Select Subject</option>
                                <option value="1">Mathematics</option>
                                <option value="2">English</option>
                                <option value="3">Physics</option>
                                <option value="4">Chemistry</option>
                                <option value="5">Biology</option>
                                <option value="6">History</option>
                                <option value="7">Geography</option>
                                <option value="8">Computer Science</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="exam_date" class="form-label">Examination Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="exam_date" name="exam_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="session_id" class="form-label">Academic Session <span class="text-danger">*</span></label>
                            <select class="form-select" id="session_id" name="session_id" required>
                                <option value="" selected disabled>Select Session</option>
                                <option value="1">2024-2025</option>
                                <option value="2">2023-2024</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="total_marks" class="form-label">Total Marks <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="total_marks" name="total_marks" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="passing_marks" class="form-label">Passing Marks <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="passing_marks" name="passing_marks" min="1" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="exam_instructions" class="form-label">Instructions</label>
                        <textarea class="form-control" id="exam_instructions" name="exam_instructions" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="exam_file" class="form-label">Examination File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="exam_file" name="exam_file" required>
                        <div class="form-text">Upload the examination paper (PDF format, max 5MB)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label d-block">Publish Results</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="publish_results" id="publish_results_yes" value="1">
                            <label class="form-check-label" for="publish_results_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="publish_results" id="publish_results_no" value="0" checked>
                            <label class="form-check-label" for="publish_results_no">No</label>
                        </div>
                        <div class="form-text">If yes, results will be visible to students and parents once grades are entered.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="#" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Examination</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Guide</h5>
            </div>
            <div class="card-body">
                <h6>Instructions</h6>
                <p>Fill in all the required fields marked with <span class="text-danger">*</span> to create a new examination.</p>
                
                <h6 class="mt-3">Tips</h6>
                <ul>
                    <li>Make sure to upload the examination paper in PDF format.</li>
                    <li>Set appropriate total and passing marks as per school policy.</li>
                    <li>Include clear instructions for students.</li>
                    <li>You can choose to publish results immediately or later.</li>
                </ul>
                
                <h6 class="mt-3">Next Steps</h6>
                <p>After creating the examination, you will be able to:</p>
                <ul>
                    <li>View and manage the examination details</li>
                    <li>Enter student grades</li>
                    <li>Generate reports</li>
                    <li>Publish results to students and parents</li>
                </ul>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Need help? Please contact the IT department at <a href="mailto:it@gestedu.com">it@gestedu.com</a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Dynamic subject loading based on class selection
        $('#class_id').change(function() {
            const classId = $(this).val();
            if (classId) {
                // In a real application, this would load subjects for the selected class
                console.log(`Loading subjects for class ID: ${classId}`);
            }
        });
        
        // Validate passing marks are less than total marks
        $('#passing_marks, #total_marks').change(function() {
            const totalMarks = parseInt($('#total_marks').val()) || 0;
            const passingMarks = parseInt($('#passing_marks').val()) || 0;
            
            if (passingMarks > totalMarks) {
                alert('Passing marks cannot be greater than total marks');
                $('#passing_marks').val('');
            }
        });
        
        // Validate end time is after start time
        $('#end_time, #start_time').change(function() {
            const startTime = $('#start_time').val();
            const endTime = $('#end_time').val();
            
            if (startTime && endTime && startTime >= endTime) {
                alert('End time must be after start time');
                $('#end_time').val('');
            }
        });
    });
</script>
@endsection
@endsection