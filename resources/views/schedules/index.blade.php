@extends('layouts.app')

@section('title', 'Class Schedule')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Class Schedule</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Class Schedule</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-outline-primary me-2" id="printSchedule">
            <i class="fas fa-print me-1"></i> Print
        </button>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
            <i class="fas fa-plus me-1"></i> Add Schedule
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <label for="classFilter" class="form-label">Class</label>
                <select class="form-select" id="classFilter">
                    <option value="all">All Classes</option>
                    <option value="1" selected>10th Grade - Section A</option>
                    <option value="2">10th Grade - Section B</option>
                    <option value="3">11th Grade - Section A</option>
                    <option value="4">11th Grade - Section B</option>
                    <option value="5">12th Grade - Section A</option>
                    <option value="6">12th Grade - Section B</option>
                </select>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <label for="teacherFilter" class="form-label">Teacher</label>
                <select class="form-select" id="teacherFilter">
                    <option value="all">All Teachers</option>
                    <option value="1">John Davis (Mathematics)</option>
                    <option value="2">Sarah Johnson (English)</option>
                    <option value="3">Robert Brown (Physics)</option>
                    <option value="4">Emily Wilson (Chemistry)</option>
                    <option value="5">Michael Thomas (History)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="dayFilter" class="form-label">Day</label>
                <select class="form-select" id="dayFilter">
                    <option value="all">All Days</option>
                    <option value="monday" selected>Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                </select>
            </div>
        </div>

        <div class="schedule-container">
            <h5 class="mb-3">10th Grade - Section A | Monday</h5>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="15%">Time</th>
                            <th width="20%">Subject</th>
                            <th width="20%">Teacher</th>
                            <th width="15%">Room</th>
                            <th width="30%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>08:00 - 09:30</td>
                            <td>Mathematics</td>
                            <td>John Davis</td>
                            <td>Room 101</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteScheduleModal">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a href="{{ route('attendance.create') }}?class=1&subject=1&date=2025-05-19&period=1" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-clipboard-check"></i> Attendance
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>09:45 - 11:15</td>
                            <td>English</td>
                            <td>Sarah Johnson</td>
                            <td>Room 102</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteScheduleModal">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a href="{{ route('attendance.create') }}?class=1&subject=2&date=2025-05-19&period=2" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-clipboard-check"></i> Attendance
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>11:30 - 13:00</td>
                            <td>Physics</td>
                            <td>Robert Brown</td>
                            <td>Lab 201</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteScheduleModal">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a href="{{ route('attendance.create') }}?class=1&subject=3&date=2025-05-19&period=3" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-clipboard-check"></i> Attendance
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>13:45 - 15:15</td>
                            <td>Chemistry</td>
                            <td>Emily Wilson</td>
                            <td>Lab 202</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteScheduleModal">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a href="{{ route('attendance.create') }}?class=1&subject=4&date=2025-05-19&period=4" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-clipboard-check"></i> Attendance
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>15:30 - 17:00</td>
                            <td>History</td>
                            <td>Michael Thomas</td>
                            <td>Room 105</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteScheduleModal">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a href="{{ route('attendance.create') }}?class=1&subject=6&date=2025-05-19&period=5" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-clipboard-check"></i> Attendance
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                <h5>Week Schedule Overview</h5>
                <ul class="nav nav-tabs" id="scheduleTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="monday-tab" data-bs-toggle="tab" data-bs-target="#monday" type="button" role="tab" aria-controls="monday" aria-selected="true">Monday</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tuesday-tab" data-bs-toggle="tab" data-bs-target="#tuesday" type="button" role="tab" aria-controls="tuesday" aria-selected="false">Tuesday</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="wednesday-tab" data-bs-toggle="tab" data-bs-target="#wednesday" type="button" role="tab" aria-controls="wednesday" aria-selected="false">Wednesday</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="thursday-tab" data-bs-toggle="tab" data-bs-target="#thursday" type="button" role="tab" aria-controls="thursday" aria-selected="false">Thursday</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="friday-tab" data-bs-toggle="tab" data-bs-target="#friday" type="button" role="tab" aria-controls="friday" aria-selected="false">Friday</button>
                    </li>
                </ul>
                <div class="tab-content pt-3" id="scheduleTabContent">
                    <div class="tab-pane fade show active" id="monday" role="tabpanel" aria-labelledby="monday-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Time</th>
                                        <th>10th Grade - A</th>
                                        <th>10th Grade - B</th>
                                        <th>11th Grade - A</th>
                                        <th>11th Grade - B</th>
                                        <th>12th Grade - A</th>
                                        <th>12th Grade - B</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>08:00 - 09:30</td>
                                        <td class="bg-light">Mathematics<br><small>John Davis</small></td>
                                        <td>English<br><small>Sarah Johnson</small></td>
                                        <td>Physics<br><small>Robert Brown</small></td>
                                        <td>Chemistry<br><small>Emily Wilson</small></td>
                                        <td>Biology<br><small>Jennifer Lee</small></td>
                                        <td>History<br><small>Michael Thomas</small></td>
                                    </tr>
                                    <tr>
                                        <td>09:45 - 11:15</td>
                                        <td>English<br><small>Sarah Johnson</small></td>
                                        <td class="bg-light">Mathematics<br><small>John Davis</small></td>
                                        <td>Chemistry<br><small>Emily Wilson</small></td>
                                        <td>Physics<br><small>Robert Brown</small></td>
                                        <td>History<br><small>Michael Thomas</small></td>
                                        <td>Biology<br><small>Jennifer Lee</small></td>
                                    </tr>
                                    <tr>
                                        <td>11:30 - 13:00</td>
                                        <td>Physics<br><small>Robert Brown</small></td>
                                        <td>Chemistry<br><small>Emily Wilson</small></td>
                                        <td class="bg-light">Mathematics<br><small>John Davis</small></td>
                                        <td>English<br><small>Sarah Johnson</small></td>
                                        <td>Computer Science<br><small>David Wilson</small></td>
                                        <td>Geography<br><small>Amanda Clark</small></td>
                                    </tr>
                                    <tr>
                                        <td>13:45 - 15:15</td>
                                        <td>Chemistry<br><small>Emily Wilson</small></td>
                                        <td>Physics<br><small>Robert Brown</small></td>
                                        <td>English<br><small>Sarah Johnson</small></td>
                                        <td class="bg-light">Mathematics<br><small>John Davis</small></td>
                                        <td>Geography<br><small>Amanda Clark</small></td>
                                        <td>Computer Science<br><small>David Wilson</small></td>
                                    </tr>
                                    <tr>
                                        <td>15:30 - 17:00</td>
                                        <td>History<br><small>Michael Thomas</small></td>
                                        <td>Biology<br><small>Jennifer Lee</small></td>
                                        <td>Geography<br><small>Amanda Clark</small></td>
                                        <td>Computer Science<br><small>David Wilson</small></td>
                                        <td class="bg-light">Mathematics<br><small>John Davis</small></td>
                                        <td>English<br><small>Sarah Johnson</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tuesday" role="tabpanel" aria-labelledby="tuesday-tab">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Change the day filter to Tuesday to see detailed schedule information.
                        </div>
                    </div>
                    <div class="tab-pane fade" id="wednesday" role="tabpanel" aria-labelledby="wednesday-tab">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Change the day filter to Wednesday to see detailed schedule information.
                        </div>
                    </div>
                    <div class="tab-pane fade" id="thursday" role="tabpanel" aria-labelledby="thursday-tab">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Change the day filter to Thursday to see detailed schedule information.
                        </div>
                    </div>
                    <div class="tab-pane fade" id="friday" role="tabpanel" aria-labelledby="friday-tab">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Change the day filter to Friday to see detailed schedule information.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addScheduleModalLabel">Add Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addScheduleForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="add_class_id" class="form-label">Class <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_class_id" name="class_id" required>
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
                            <label for="add_subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_subject_id" name="subject_id" required>
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
                            <label for="add_teacher_id" class="form-label">Teacher <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_teacher_id" name="teacher_id" required>
                                <option value="" selected disabled>Select Teacher</option>
                                <option value="1">John Davis (Mathematics)</option>
                                <option value="2">Sarah Johnson (English)</option>
                                <option value="3">Robert Brown (Physics)</option>
                                <option value="4">Emily Wilson (Chemistry)</option>
                                <option value="5">Michael Thomas (History)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="add_room" class="form-label">Room <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_room" name="room" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="add_day" class="form-label">Day <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_day" name="day" required>
                                <option value="" selected disabled>Select Day</option>
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="add_period" class="form-label">Period <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_period" name="period" required>
                                <option value="" selected disabled>Select Period</option>
                                <option value="1">1st Period (08:00 - 09:30)</option>
                                <option value="2">2nd Period (09:45 - 11:15)</option>
                                <option value="3">3rd Period (11:30 - 13:00)</option>
                                <option value="4">4th Period (13:45 - 15:15)</option>
                                <option value="5">5th Period (15:30 - 17:00)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="add_notes" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveScheduleBtn">Save Schedule</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Schedule Modal -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Edit Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editScheduleForm">
                    <input type="hidden" id="edit_schedule_id" name="schedule_id" value="1">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_class_id" class="form-label">Class <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_class_id" name="class_id" required>
                                <option value="1" selected>10th Grade - Section A</option>
                                <option value="2">10th Grade - Section B</option>
                                <option value="3">11th Grade - Section A</option>
                                <option value="4">11th Grade - Section B</option>
                                <option value="5">12th Grade - Section A</option>
                                <option value="6">12th Grade - Section B</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_subject_id" name="subject_id" required>
                                <option value="1" selected>Mathematics</option>
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
                            <label for="edit_teacher_id" class="form-label">Teacher <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_teacher_id" name="teacher_id" required>
                                <option value="1" selected>John Davis (Mathematics)</option>
                                <option value="2">Sarah Johnson (English)</option>
                                <option value="3">Robert Brown (Physics)</option>
                                <option value="4">Emily Wilson (Chemistry)</option>
                                <option value="5">Michael Thomas (History)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_room" class="form-label">Room <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_room" name="room" value="Room 101" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_day" class="form-label">Day <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_day" name="day" required>
                                <option value="monday" selected>Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_period" class="form-label">Period <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_period" name="period" required>
                                <option value="1" selected>1st Period (08:00 - 09:30)</option>
                                <option value="2">2nd Period (09:45 - 11:15)</option>
                                <option value="3">3rd Period (11:30 - 13:00)</option>
                                <option value="4">4th Period (13:45 - 15:15)</option>
                                <option value="5">5th Period (15:30 - 17:00)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateScheduleBtn">Update Schedule</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Schedule Modal -->
<div class="modal fade" id="deleteScheduleModal" tabindex="-1" aria-labelledby="deleteScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteScheduleModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this schedule entry?</p>
                <p><strong>Class:</strong> 10th Grade - Section A</p>
                <p><strong>Subject:</strong> Mathematics</p>
                <p><strong>Teacher:</strong> John Davis</p>
                <p><strong>Day/Time:</strong> Monday, 08:00 - 09:30</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Schedule</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle filter changes
        $('#classFilter, #teacherFilter, #dayFilter').change(function() {
            // In a real application, this would fetch the filtered schedule data
            // For this demo, we'll just show an alert
            const classFilter = $('#classFilter').val();
            const teacherFilter = $('#teacherFilter').val();
            const dayFilter = $('#dayFilter').val();
            
            console.log(`Filtering schedules - Class: ${classFilter}, Teacher: ${teacherFilter}, Day: ${dayFilter}`);
            
            // You would normally make an AJAX request here to get the filtered data
            // and then update the schedule display
        });
        
        // Handle save schedule
        $('#saveScheduleBtn').click(function() {
            // Validate form
            const form = document.getElementById('addScheduleForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // In a real application, you would submit the form data via AJAX
            // For this demo, we'll just show a success message and close the modal
            alert('Schedule added successfully!');
            $('#addScheduleModal').modal('hide');
        });
        
        // Handle update schedule
        $('#updateScheduleBtn').click(function() {
            // Validate form
            const form = document.getElementById('editScheduleForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // In a real application, you would submit the form data via AJAX
            // For this demo, we'll just show a success message and close the modal
            alert('Schedule updated successfully!');
            $('#editScheduleModal').modal('hide');
        });
        
        // Handle delete schedule
        $('#confirmDeleteBtn').click(function() {
            // In a real application, you would send a delete request via AJAX
            // For this demo, we'll just show a success message and close the modal
            alert('Schedule deleted successfully!');
            $('#deleteScheduleModal').modal('hide');
        });
        
        // Handle print button
        $('#printSchedule').click(function() {
            window.print();
        });
        
        // Conflict detection when adding/editing schedule
        $('#add_class_id, #add_day, #add_period, #edit_class_id, #edit_day, #edit_period').change(function() {
            // In a real application, this would check for schedule conflicts
            // For this demo, we'll just log the values
            console.log('Checking for schedule conflicts...');
        });
    });
</script>
@endsection

@section('styles')
<style>
    @media print {
        .modal,
        .btn,
        .form-select,
        .nav-tabs {
            display: none !important;
        }
        
        .table {
            border-collapse: collapse !important;
        }
        
        .table td,
        .table th {
            background-color: #fff !important;
        }
        
        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6 !important;
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>
@endsection
@endsection