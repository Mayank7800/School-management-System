@extends('layouts.app')

@section('title', 'Add New Staff')

@section('content')
<style>
    input.form-control, select.form-select, textarea.form-control {
        text-transform: capitalize;
    }
    .invalid-feedback {
        display: none;
        color: red;
        font-size: 0.875rem;
    }
    .form-step { display: none; transition: all 0.3s ease; }
    .form-step.active { display: block; }
    .progress { height: 30px; font-weight: 500; font-size: 14px; }
    .card { border-radius: 12px; }
    .btn { min-width: 130px; }
    .is-invalid { border-color: #dc3545 !important; }
    .invalid-feedback { display: block; }
    .capitalize { text-transform: capitalize; }
    .text-danger { color: #dc3545; }
    .form-label { font-weight: 500; }
</style>

<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Staff Registration Form</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="progress mb-4">
            <div id="formProgress" class="progress-bar bg-success" role="progressbar" style="width:20%">Step 1 of 5</div>
        </div>

        <form id="staffForm" action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            {{-- STEP 1: Personal Information --}}
            <div class="form-step active card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 1: Personal Information</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control capitalize @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required maxlength="50">
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">First Name is required.</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control capitalize @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') }}" maxlength="50">
                        @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control capitalize @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required maxlength="50">
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Last Name is required.</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" max="{{ date('Y-m-d') }}">
                        @error('dob')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Blood Group</label>
                        <input type="text" name="blood_group" class="form-control @error('blood_group') is-invalid @enderror" value="{{ old('blood_group') }}">
                        @error('blood_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Marital Status</label>
                        <select name="marital_status" class="form-select @error('marital_status') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                        </select>
                        @error('marital_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nationality</label>
                        <input type="text" name="nationality" class="form-control capitalize @error('nationality') is-invalid @enderror" value="{{ old('nationality', 'Indian') }}">
                        @error('nationality')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Aadhaar Number</label>
                        <input type="text" name="aadhaar_number" class="form-control @error('aadhaar_number') is-invalid @enderror" value="{{ old('aadhaar_number') }}" maxlength="12" pattern="^[0-9]{12}$">
                        @error('aadhaar_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Enter a valid 12-digit Aadhaar number.</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">PAN Number</label>
                        <input type="text" name="pan_number" class="form-control @error('pan_number') is-invalid @enderror" value="{{ ('pan_number') }}" maxlength="10" pattern="^[A-Z]{5}[0-9]{4}[A-Z]{1}$">
                        @error('pan_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Enter a valid PAN number(ABCDE1234A).</div>
                        @enderror
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 2: Contact Information --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 2: Contact Information</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Mobile <span class="text-danger">*</span></label>
                        <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" maxlength="10" pattern="^[0-9]{10}$" required>
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Alternate Mobile</label>
                        <input type="text" name="alternate_mobile" class="form-control @error('alternate_mobile') is-invalid @enderror" value="{{ old('alternate_mobile') }}" maxlength="10" pattern="^[0-9]{10}$">
                        @error('alternate_mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Enter a valid email address.</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Address Line 1</label>
                        <input type="text" name="address_line1" class="form-control @error('address_line1') is-invalid @enderror" value="{{ old('address_line1') }}">
                        @error('address_line1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" name="address_line2" class="form-control @error('address_line2') is-invalid @enderror" value="{{ old('address_line2') }}">
                        @error('address_line2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control capitalize @error('city') is-invalid @enderror" value="{{ old('city') }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control capitalize @error('state') is-invalid @enderror" value="{{ old('state') }}">
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode') }}" maxlength="6" pattern="^[0-9]{6}$">
                        @error('pincode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Enter a valid 6-digit pincode.</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control capitalize @error('country') is-invalid @enderror" value="{{ old('country', 'India') }}">
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 3: Employment Details --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 3: Employment Details</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Staff ID <span class="text-danger">*</span></label>
                        <input type="text" name="staff_id" class="form-control @error('staff_id') is-invalid @enderror" value="{{ old('staff_id') }}" required>
                        @error('staff_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Staff ID is required.</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Joining Date</label>
                        <input type="date" name="joining_date" class="form-control @error('joining_date') is-invalid @enderror" value="{{ old('joining_date') }}" max="{{ date('Y-m-d') }}">
                        @error('joining_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Department</label>
                        <input type="text" name="department" class="form-control capitalize @error('department') is-invalid @enderror" value="{{ old('department') }}">
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control capitalize @error('designation') is-invalid @enderror" value="{{ old('designation') }}">
                        @error('designation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="qualification" class="form-control capitalize @error('qualification') is-invalid @enderror" value="{{ old('qualification') }}">
                        @error('qualification')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Experience (Years)</label>
                        <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" value="{{ old('experience') }}" min="0">
                        @error('experience')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control capitalize @error('specialization') is-invalid @enderror" value="{{ old('specialization') }}">
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Employment Type</label>
                        <select name="employment_type" class="form-select @error('employment_type') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Permanent" {{ old('employment_type') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="Temporary" {{ old('employment_type') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                            <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                        @error('employment_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Shift Timing</label>
                        <input type="text" name="shift_timing" class="form-control @error('shift_timing') is-invalid @enderror" value="{{ old('shift_timing') }}">
                        @error('shift_timing')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Reporting To</label>
                        <input type="text" name="reporting_to" class="form-control capitalize @error('reporting_to') is-invalid @enderror" value="{{ old('reporting_to') }}">
                        @error('reporting_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 4: Salary & Bank Details --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 4: Salary & Bank Details</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Basic Salary</label>
                        <input type="number" name="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror" value="{{ old('basic_salary') }}" min="0" step="0.01">
                        @error('basic_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Allowances</label>
                        <input type="number" name="allowances" class="form-control @error('allowances') is-invalid @enderror" value="{{ old('allowances') }}" min="0" step="0.01">
                        @error('allowances')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Deductions</label>
                        <input type="number" name="deductions" class="form-control @error('deductions') is-invalid @enderror" value="{{ old('deductions') }}" min="0" step="0.01">
                        @error('deductions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Net Salary</label>
                        <input type="number" name="net_salary" class="form-control @error('net_salary') is-invalid @enderror" value="{{ old('net_salary') }}" min="0" step="0.01">
                        @error('net_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode" class="form-select @error('payment_mode') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Bank" {{ old('payment_mode') == 'Bank' ? 'selected' : '' }}>Bank</option>
                            <option value="UPI" {{ old('payment_mode') == 'UPI' ? 'selected' : '' }}>UPI</option>
                        </select>
                        @error('payment_mode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control capitalize @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}">
                        @error('bank_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" value="{{ old('account_number') }}">
                        @error('account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">IFSC Code</label>
                        <input type="text" name="ifsc_code" class="form-control @error('ifsc_code') is-invalid @enderror" value="{{ old('ifsc_code') }}">
                        @error('ifsc_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 5: Documents & Final --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 5: Documents & System Access</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, JPEG</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Aadhaar File</label>
                        <input type="file" name="aadhaar_file" class="form-control @error('aadhaar_file') is-invalid @enderror" accept=".pdf,image/*">
                        @error('aadhaar_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: PDF, JPG, PNG</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">PAN File</label>
                        <input type="file" name="pan_file" class="form-control @error('pan_file') is-invalid @enderror" accept=".pdf,image/*">
                        @error('pan_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: PDF, JPG, PNG</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="Teacher" {{ old('role') == 'Teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Accountant" {{ old('role') == 'Accountant' ? 'selected' : '' }}>Accountant</option>
                            <option value="Librarian" {{ old('role') == 'Librarian' ? 'selected' : '' }}>Librarian</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="submit" class="btn btn-success">Submit Staff Registration <i class="bi bi-check-circle"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- JS for Step Navigation, Validation & Progress --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.form-step');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    const progress = document.getElementById('formProgress');
    let currentStep = 0;

    function showStep(index) {
        steps.forEach((step, i) => step.classList.toggle('active', i === index));
        progress.style.width = ((index + 1) / steps.length * 100) + '%';
        progress.innerText = `Step ${index + 1} of ${steps.length}`;
        
        // Scroll to top of form when changing steps
        document.querySelector('.form-step.active').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function validateStep(step) {
        const inputs = step.querySelectorAll('input, select, textarea');
        let valid = true;
        
        inputs.forEach(input => {
            // Reset validation state
            input.classList.remove('is-invalid');
            
            // Required field validation
            if (input.hasAttribute('required') && !input.value.trim()) {
                input.classList.add('is-invalid');
                valid = false;
            }
            // Pattern validation (only if field has value)
            else if (input.pattern && input.value.trim() !== '' && !new RegExp(input.pattern).test(input.value.trim())) {
                input.classList.add('is-invalid');
                valid = false;
            }
            // Email validation
            else if (input.type === 'email' && input.value.trim() !== '' && !isValidEmail(input.value)) {
                input.classList.add('is-invalid');
                valid = false;
            }
            // Date validation (not in future)
            else if (input.type === 'date' && input.value && new Date(input.value) > new Date()) {
                input.classList.add('is-invalid');
                valid = false;
            }
            // Number validation (min value)
            else if (input.type === 'number' && input.hasAttribute('min') && input.value && parseFloat(input.value) < parseFloat(input.getAttribute('min'))) {
                input.classList.add('is-invalid');
                valid = false;
            }
            // File validation (size and type)
            else if (input.type === 'file' && input.files.length > 0) {
                const file = input.files[0];
                const acceptTypes = input.getAttribute('accept');
                
                // Check file type
                if (acceptTypes && !isFileTypeValid(file, acceptTypes)) {
                    input.classList.add('is-invalid');
                    valid = false;
                }
                
                // Check file size (max 5MB for documents, 2MB for images)
                const maxSize = input.name === 'photo' ? 2 * 1024 * 1024 : 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    input.classList.add('is-invalid');
                    valid = false;
                }
            }
        });
        
        return valid;
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isFileTypeValid(file, acceptTypes) {
        const acceptedTypes = acceptTypes.split(',').map(type => type.trim());
        return acceptedTypes.some(type => {
            if (type === '.pdf') return file.type === 'application/pdf';
            if (type === 'image/*') return file.type.startsWith('image/');
            if (type.startsWith('.')) return file.name.toLowerCase().endsWith(type);
            return file.type === type;
        });
    }

    function calculateNetSalary() {
        const basicSalary = parseFloat(document.querySelector('[name="basic_salary"]').value) || 0;
        const allowances = parseFloat(document.querySelector('[name="allowances"]').value) || 0;
        const deductions = parseFloat(document.querySelector('[name="deductions"]').value) || 0;
        const netSalary = basicSalary + allowances - deductions;
        
        document.querySelector('[name="net_salary"]').value = netSalary > 0 ? netSalary.toFixed(2) : '';
    }

    // Auto-generate username from first and last name
    function generateUsername() {
        const firstName = document.querySelector('[name="first_name"]').value.trim().toLowerCase();
        const lastName = document.querySelector('[name="last_name"]').value.trim().toLowerCase();
        
        if (firstName && lastName) {
            const username = (firstName + '.' + lastName).replace(/\s+/g, '.');
            document.querySelector('[name="username"]').value = username;
        }
    }

    // Auto-generate staff ID
    function generateStaffId() {
        const firstName = document.querySelector('[name="first_name"]').value.trim();
        const lastName = document.querySelector('[name="last_name"]').value.trim();
        
        if (firstName && lastName && !document.querySelector('[name="staff_id"]').value) {
            const initials = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
            const timestamp = Date.now().toString().slice(-4);
            document.querySelector('[name="staff_id"]').value = `STF${initials}${timestamp}`;
        }
    }

    nextBtns.forEach(btn => btn.addEventListener('click', () => {
        if (validateStep(steps[currentStep])) {
            if (currentStep < steps.length - 1) currentStep++;
            showStep(currentStep);
        } else {
            // Scroll to first invalid field
            const firstInvalid = steps[currentStep].querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    }));

    prevBtns.forEach(btn => btn.addEventListener('click', () => {
        if (currentStep > 0) currentStep--;
        showStep(currentStep);
    }));

    // Real-time validation
    document.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else if (this.pattern && this.value.trim() !== '' && !new RegExp(this.pattern).test(this.value.trim())) {
                this.classList.add('is-invalid');
            } else if (this.type === 'email' && this.value.trim() !== '' && !isValidEmail(this.value)) {
                this.classList.add('is-invalid');
            } else if (this.type === 'date' && this.value && new Date(this.value) > new Date()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Capitalize first letter of every word
    document.querySelectorAll('.capitalize').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value
                .toLowerCase()
                .replace(/\b\w/g, char => char.toUpperCase());
        });
    });

    // Auto-calculate net salary
    document.querySelector('[name="basic_salary"]').addEventListener('input', calculateNetSalary);
    document.querySelector('[name="allowances"]').addEventListener('input', calculateNetSalary);
    document.querySelector('[name="deductions"]').addEventListener('input', calculateNetSalary);

    // Auto-generate username when name fields are filled
    document.querySelector('[name="first_name"]').addEventListener('blur', generateUsername);
    document.querySelector('[name="last_name"]').addEventListener('blur', generateUsername);

    // Auto-generate staff ID
    document.querySelector('[name="first_name"]').addEventListener('blur', generateStaffId);
    document.querySelector('[name="last_name"]').addEventListener('blur', generateStaffId);

    // Uppercase for PAN number
    document.querySelector('[name="pan_number"]').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // File size and type validation feedback
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                const acceptTypes = this.getAttribute('accept');
                const maxSize = this.name === 'photo' ? 2 * 1024 * 1024 : 5 * 1024 * 1024;
                
                let error = '';
                
                if (acceptTypes && !isFileTypeValid(file, acceptTypes)) {
                    error = 'Invalid file type. Please select a valid file.';
                } else if (file.size > maxSize) {
                    const maxSizeMB = maxSize / (1024 * 1024);
                    error = `File size too large. Maximum size is ${maxSizeMB}MB.`;
                }
                
                if (error) {
                    this.classList.add('is-invalid');
                    // Update error message
                    let errorElement = this.nextElementSibling;
                    while (errorElement && !errorElement.classList.contains('invalid-feedback')) {
                        errorElement = errorElement.nextElementSibling;
                    }
                    if (errorElement) {
                        errorElement.textContent = error;
                    }
                } else {
                    this.classList.remove('is-invalid');
                }
            }
        });
    });

    // Form submission validation
    document.getElementById('staffForm').addEventListener('submit', function(e) {
        let allValid = true;
        
        steps.forEach(step => {
            if (!validateStep(step)) {
                allValid = false;
            }
        });
        
        if (!allValid) {
            e.preventDefault();
            // Go to first step with errors
            for (let i = 0; i < steps.length; i++) {
                if (!validateStep(steps[i])) {
                    currentStep = i;
                    showStep(currentStep);
                    break;
                }
            }
            alert('Please fix all validation errors before submitting the form.');
        }
    });

    // Initialize
    calculateNetSalary();
});
</script>
@endsection
