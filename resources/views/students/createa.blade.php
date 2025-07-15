@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
<div class="page-header">
    <h1>Add New Student</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Student</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Student Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('students.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname') }}" required>
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="birthday" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
                            @error('birthday')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sex" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select @error('sex') is-invalid @enderror" id="sex" name="sex" required>
                                <option value="" selected disabled>Select Gender</option>
                                <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Male</option>
                                <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('sex')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Home Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Academic Information</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="class_id" class="form-label">Class/Grade <span class="text-danger">*</span></label>
                                        <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id" required>
                                            <option value="" selected disabled>Select Class</option>
                                            @foreach ($study_levels as $study_level)
                                                <option value="{{$study_level->id}}" {{ old('class_id') == '$study_level->id' ? 'selected' : '' }}>{{$study_level->specification}}</option>
                                            
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="roll_number" class="form-label">Roll Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('roll_number') is-invalid @enderror" id="roll_number" name="roll_number" value="{{ old('roll_number') }}" required>
                                        @error('roll_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="join_date" class="form-label">Admission Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date" value="{{ old('join_date', date('Y-m-d')) }}" required>
                                    @error('join_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Parent/Guardian Information</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="linkExistingParent" name="link_existing_parent">
                                    <label class="form-check-label" for="linkExistingParent">
                                        Link to Existing Parent/Guardian
                                    </label>
                                </div>
                                
                                <div id="existingParentSection" style="display: none;">
                                    <div class="mb-3">
                                        <label for="parent_id" class="form-label">Select Parent <span class="text-danger">*</span></label>
                                        <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                            <option value="" selected disabled>Select Parent</option>
                                            @foreach ($parents as $parent)
                                                <option value="{{$parent->id}}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{$parent->lastname }} {{$parent->firstname}}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div id="newParentSection">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="parent_firstname" class="form-label">Parent First Name</label>
                                            <input type="text" class="form-control @error('parent_firstname') is-invalid @enderror" id="parent_firstname" name="parent_firstname" value="{{ old('parent_firstname') }}">
                                            @error('parent_firstname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="parent_lastname" class="form-label">Parent Last Name</label>
                                            <input type="text" class="form-control @error('parent_lastname') is-invalid @enderror" id="parent_lastname" name="parent_lastname" value="{{ old('parent_lastname') }}">
                                            @error('parent_lastname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="parent_relationship" class="form-label">Relationship</label>
                                            <select class="form-select @error('parent_relationship') is-invalid @enderror" id="parent_relationship" name="parent_relationship">
                                                <option value="" selected disabled>Select Relationship</option>
                                                <option value="father" {{ old('parent_relationship') == 'father' ? 'selected' : '' }}>Father</option>
                                                <option value="mother" {{ old('parent_relationship') == 'mother' ? 'selected' : '' }}>Mother</option>
                                                <option value="guardian" {{ old('parent_relationship') == 'guardian' ? 'selected' : '' }}>Guardian</option>
                                            </select>
                                            @error('parent_relationship')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="parent_phone" class="form-label">Parent Phone Number</label>
                                            <input type="tel" class="form-control @error('parent_phone') is-invalid @enderror" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}">
                                            @error('parent_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="parent_email" class="form-label">Parent Email</label>
                                        <input type="email" class="form-control @error('parent_email') is-invalid @enderror" id="parent_email" name="parent_email" value="{{ old('parent_email') }}">
                                        @error('parent_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Account Information</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="createAccount" name="create_account" checked>
                                    <label class="form-check-label" for="createAccount">
                                        Create User Account
                                    </label>
                                    <div class="form-text">A user account will be created for the student using the provided email address.</div>
                                </div>
                                
                                <div id="passwordFields">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-toggle="#password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="form-text">Leave blank to generate a random password</div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-toggle="#password_confirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('students.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Register Student</button>
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
                <div class="mb-4">
                    <img src="https://pixabay.com/get/g3fe1fa0db2615ac2017450c67d3adda676c494ce8612efdb660cf6090526c15e980d577892321287a6d43f0d73f65ea34c7183179bce2533816a555c630aa527_1280.jpg" class="img-fluid rounded" alt="Students studying">
                </div>
                <h6>Registration Instructions</h6>
                <p>Fill in all the required fields marked with <span class="text-danger">*</span> to register a new student.</p>
                
                <h6 class="mt-3">Parent/Guardian Information</h6>
                <p>You can either link the student to an existing parent/guardian in the system or create a new one. If creating a new parent, you will need to provide their basic contact information.</p>
                
                <h6 class="mt-3">User Account</h6>
                <p>A user account will be automatically created for the student using the provided email address. A welcome email with login instructions will be sent to their email.</p>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle existing/new parent sections
        $('#linkExistingParent').change(function() {
            if(this.checked) {
                $('#existingParentSection').show();
                $('#newParentSection').hide();
            } else {
                $('#existingParentSection').hide();
                $('#newParentSection').show();
            }
        });
        
        // Toggle password visibility
        $('.toggle-password').click(function() {
            const target = $($(this).data('toggle'));
            const type = target.attr('type') === 'password' ? 'text' : 'password';
            target.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });
        
        // Toggle account creation fields
        $('#createAccount').change(function() {
            if(this.checked) {
                $('#passwordFields').show();
            } else {
                $('#passwordFields').hide();
            }
        });
    });
</script>
@endsection
@endsection