@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Student Registration Form</h4>
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

        <form id="admissionForm" action="{{ route('admissions.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            {{-- STEP 1: Personal Details --}}
            <div class="form-step active card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 1: Personal Details</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control capitalize @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" >
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">First Name is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control capitalize @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control capitalize @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" >
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Last Name is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" >
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Gender is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" required max="{{ date('Y-m-d') }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Date of Birth is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-select @error('blood_group') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                        @error('blood_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nationality <span class="text-danger">*</span></label>
                        <input type="text" name="nationality" class="form-control capitalize @error('nationality') is-invalid @enderror" value="{{ old('nationality', 'Indian') }}" >
                        @error('nationality')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Nationality is required.</div>
                        @enderror
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 2: Contact & Address --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 2: Contact & Address</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Mobile No <span class="text-danger">*</span></label>
                        <input type="text" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" value="{{ old('mobile_no') }}" pattern="^[0-9]{10}$" >
                        @error('mobile_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alternate Mobile</label>
                        <input type="text" name="alt_mobile_no" class="form-control @error('alt_mobile_no') is-invalid @enderror" value="{{ old('alt_mobile_no') }}" pattern="^[0-9]{10}$">
                        @error('alt_mobile_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address_line1" class="form-control @error('address_line1') is-invalid @enderror" value="{{ old('address_line1') }}" >
                        @error('address_line1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Address is required.</div>
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
                        <label class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control capitalize @error('city') is-invalid @enderror" value="{{ old('city') }}" >
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">City is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control capitalize @error('state') is-invalid @enderror" value="{{ old('state') }}" >
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">State is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pincode <span class="text-danger">*</span></label>
                        <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode') }}" pattern="^[0-9]{6}$" >
                        @error('pincode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Enter a valid 6-digit pincode.</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control capitalize @error('country') is-invalid @enderror" value="{{ old('country', 'India') }}" >
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Country is required.</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 3: Parents & Guardian --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 3: Parents & Guardian Info</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Father's Name <span class="text-danger">*</span></label>
                        <input type="text" name="father_name" class="form-control capitalize @error('father_name') is-invalid @enderror" value="{{ old('father_name') }}" >
                        @error('father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Father's Name is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Occupation</label>
                        <input type="text" name="father_occupation" class="form-control capitalize @error('father_occupation') is-invalid @enderror" value="{{ old('father_occupation') }}">
                        @error('father_occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact <span class="text-danger">*</span></label>
                        <input type="text" name="father_contact" class="form-control @error('father_contact') is-invalid @enderror" value="{{ old('father_contact') }}" pattern="^[0-9]{10}$" >
                        @error('father_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Father's contact is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mother's Name <span class="text-danger">*</span></label>
                        <input type="text" name="mother_name" class="form-control capitalize @error('mother_name') is-invalid @enderror" value="{{ old('mother_name') }}" >
                        @error('mother_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Mother's Name is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Occupation</label>
                        <input type="text" name="mother_occupation" class="form-control capitalize @error('mother_occupation') is-invalid @enderror" value="{{ old('mother_occupation') }}">
                        @error('mother_occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact</label>
                        <input type="text" name="mother_contact" class="form-control @error('mother_contact') is-invalid @enderror" value="{{ old('mother_contact') }}" pattern="^[0-9]{10}$">
                        @error('mother_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Guardian Name</label>
                        <input type="text" name="guardian_name" class="form-control capitalize @error('guardian_name') is-invalid @enderror" value="{{ old('guardian_name') }}">
                        @error('guardian_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Relation</label>
                        <input type="text" name="guardian_relation" class="form-control capitalize @error('guardian_relation') is-invalid @enderror" value="{{ old('guardian_relation') }}">
                        @error('guardian_relation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact</label>
                        <input type="text" name="guardian_contact" class="form-control @error('guardian_contact') is-invalid @enderror" value="{{ old('guardian_contact') }}" pattern="^[0-9]{10}$">
                        @error('guardian_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 4: Admission & Fees --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 4: Admission Details</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Admission No <span class="text-danger">*</span></label>
                        <input type="text" name="admission_no" class="form-control @error('admission_no') is-invalid @enderror" value="{{ old('admission_no') }}" >
                        @error('admission_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Admission No is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Admission Date <span class="text-danger">*</span></label>
                        <input type="date" name="admission_date" class="form-control @error('admission_date') is-invalid @enderror" value="{{ old('admission_date', date('Y-m-d')) }}" required max="{{ date('Y-m-d') }}">
                        @error('admission_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Admission Date is required.</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Academic Year <span class="text-danger">*</span></label>
                        <input type="text" name="academic_year" class="form-control capitalize @error('academic_year') is-invalid @enderror" value="{{ old('academic_year', date('Y') . '-' . (date('Y') + 1)) }}" >
                        @error('academic_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Academic Year is required.</div>
                        @enderror
                    </div>

                   <div class="col-md-3">
                        <label class="form-label">Class <span class="text-danger">*</span></label>
                        <select name="class" class="form-control @error('class') is-invalid @enderror" >
                            <option value="">Select Class</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('class') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a class.</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Section</label>
                        <input type="text" name="section" class="form-control capitalize @error('section') is-invalid @enderror" value="{{ old('section') }}">
                        @error('section')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Roll No</label>
                        <input type="text" name="roll_no" class="form-control @error('roll_no') is-invalid @enderror" value="{{ old('roll_no') }}">
                        @error('roll_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Admission Fee</label>
                        <input type="number" name="admission_fee" class="form-control @error('admission_fee') is-invalid @enderror" value="{{ old('admission_fee') }}" min="0" step="0.01">
                        @error('admission_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tuition Fee</label>
                        <input type="number" name="tuition_fee" class="form-control @error('tuition_fee') is-invalid @enderror" value="{{ old('tuition_fee') }}" min="0" step="0.01">
                        @error('tuition_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode" class="form-select @error('payment_mode') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Card" {{ old('payment_mode') == 'Card' ? 'selected' : '' }}>Card</option>
                            <option value="UPI" {{ old('payment_mode') == 'UPI' ? 'selected' : '' }}>UPI</option>
                            <option value="Bank Transfer" {{ old('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @error('payment_mode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Transaction ID</label>
                        <input type="text" name="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" value="{{ old('transaction_id') }}">
                        @error('transaction_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fee Receipt</label>
                        <input type="file" name="fee_receipt" class="form-control @error('fee_receipt') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @error('fee_receipt')
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
                <h5 class="mb-3">Step 5: Documents & Confirmation</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Student Photo</label>
                        <input type="file" name="student_photo" class="form-control @error('student_photo') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                        @error('student_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max size: 2MB, Format: JPG, PNG</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Birth Certificate</label>
                        <input type="file" name="birth_certificate" class="form-control @error('birth_certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @error('birth_certificate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max size: 5MB</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ID Proof</label>
                        <input type="file" name="id_proof" class="form-control @error('id_proof') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @error('id_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max size: 5MB</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marksheet</label>
                        <input type="file" name="marksheet" class="form-control @error('marksheet') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @error('marksheet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max size: 5MB</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Caste Certificate</label>
                        <input type="file" name="caste_certificate" class="form-control @error('caste_certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @error('caste_certificate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max size: 5MB</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Transfer Certificate</label>
                        <input type="file" name="transfer_certificate" class="form-control @error('transfer_certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @error('transfer_certificate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max size: 5MB</small>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" >
                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="submit" class="btn btn-success">Submit Admission <i class="bi bi-check-circle"></i></button>
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
        });
        
        return valid;
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
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

    // Form submission validation
    document.getElementById('admissionForm').addEventListener('submit', function(e) {
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
});
</script>

<style>
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
@endsection