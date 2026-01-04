@extends('layouts.app')

@section('title', 'Assign Fees to Student')
@section('page_title', 'Assign Fees')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Assign Fees to Student</h5>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="progress mb-4">
            <div id="formProgress" class="progress-bar bg-success" role="progressbar" style="width:33%">Step 1 of 3</div>
        </div>

        <form id="studentFeeForm" action="{{ route('student-fees.store') }}" method="POST" novalidate>
            @csrf

            {{-- STEP 1: Class & Student Selection --}}
            <div class="form-step active card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 1: Select Class & Student</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Class <span class="text-danger">*</span></label>
                        <select name="class_id" class="form-select @error('class_id') is-invalid @enderror" required id="classSelect">
                            <option value="">-- Select Class --</option>
                            @foreach($courses as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a class.</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Student <span class="text-danger">*</span></label>
                        <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required id="studentSelect">
                            <option value="">-- Select Student --</option>
                            @if(old('student_id'))
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->first_name }} {{ $student->last_name }} ({{ $student->admission_no }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a student.</div>
                        @enderror
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 2: Fee Selection & Amount Details --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 2: Fee Selection & Amount Details</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Fee Structure <span class="text-danger">*</span></label>
                        <select name="fee_structure_id" class="form-select @error('fee_structure_id') is-invalid @enderror" required id="feeStructureSelect">
                            <option value="">-- Select Fee Structure --</option>
                            @if(old('fee_structure_id'))
                                @foreach($structures as $structure)
                                    <option value="{{ $structure->id }}" {{ old('fee_structure_id') == $structure->id ? 'selected' : '' }} data-amount="{{ $structure->amount }}">
                                        {{ $structure->fee_type }} - ₹{{ number_format($structure->amount, 2) }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('fee_structure_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a fee structure.</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Total Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="total_amount" step="0.01" min="0" class="form-control @error('total_amount') is-invalid @enderror" value="{{ old('total_amount') }}" required readonly id="total_amount">
                        @error('total_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter the total amount.</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Paid Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="paid_amount" step="0.01" min="0" class="form-control @error('paid_amount') is-invalid @enderror" value="{{ old('paid_amount', 0) }}" required id="paid_amount">
                        @error('paid_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a valid paid amount.</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Due Amount (₹)</label>
                        <input type="number" name="due_amount" step="0.01" class="form-control" readonly id="due_amount">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" id="payment_status">
                            <option value="Unpaid" {{ old('payment_status', 'Unpaid') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="Partial" {{ old('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                            <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Installment Plan</label>
                        <select name="installment_plan" class="form-select @error('installment_plan') is-invalid @enderror">
                            <option value="">-- Select Plan --</option>
                            <option value="One Time" {{ old('installment_plan') == 'One Time' ? 'selected' : '' }}>One Time</option>
                            <option value="Monthly" {{ old('installment_plan') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Quarterly" {{ old('installment_plan') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="Half Yearly" {{ old('installment_plan') == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                            <option value="Yearly" {{ old('installment_plan') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                        @error('installment_plan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 3: Additional Details --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 3: Additional Details</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Academic Year</label>
                        <input type="text" name="academic_year" class="form-control @error('academic_year') is-invalid @enderror" value="{{ old('academic_year', date('Y') . '-' . (date('Y') + 1)) }}">
                        @error('academic_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3" placeholder="Any additional notes...">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="submit" class="btn btn-success">Assign Fees <i class="bi bi-check-circle"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .form-step { display: none; transition: all 0.3s ease; }
    .form-step.active { display: block; }
    .progress { height: 30px; font-weight: 500; font-size: 14px; }
    .card { border-radius: 12px; }
    .btn { min-width: 130px; }
    .is-invalid { border-color: #dc3545 !important; }
    .invalid-feedback { display: block; }
    input.form-control, select.form-select, textarea.form-control { text-transform: capitalize; }
    .text-danger { color: #dc3545; }
    .form-label { font-weight: 500; }
    .loading { opacity: 0.6; pointer-events: none; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.form-step');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    const progress = document.getElementById('formProgress');
    let currentStep = 0;

    // Form elements
    const classSelect = document.getElementById('classSelect');
    const studentSelect = document.getElementById('studentSelect');
    const feeStructureSelect = document.getElementById('feeStructureSelect');
    const totalAmountInput = document.getElementById('total_amount');
    const paidAmountInput = document.getElementById('paid_amount');
    const dueAmountInput = document.getElementById('due_amount');
    const paymentStatusSelect = document.getElementById('payment_status');

    function showStep(index) {
        steps.forEach((step, i) => step.classList.toggle('active', i === index));
        progress.style.width = ((index + 1) / steps.length * 100) + '%';
        progress.innerText = `Step ${index + 1} of ${steps.length}`;
        
        document.querySelector('.form-step.active').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Update payment status based on amounts
    function updatePaymentStatus() {
        const total = parseFloat(totalAmountInput.value) || 0;
        const paid = parseFloat(paidAmountInput.value) || 0;
        
        if (paid === 0) {
            paymentStatusSelect.value = 'Unpaid';
        } else if (paid > 0 && paid < total) {
            paymentStatusSelect.value = 'Partial';
        } else if (paid >= total) {
            paymentStatusSelect.value = 'Paid';
        }
        
        console.log('Payment status updated to:', paymentStatusSelect.value);
    }

    function calculateAmounts() {
        const total = parseFloat(totalAmountInput.value) || 0;
        const paid = parseFloat(paidAmountInput.value) || 0;
        const due = total - paid;
        
        dueAmountInput.value = due.toFixed(2);
        updatePaymentStatus(); // Update payment status
    }

    function validateStep(step) {
        const inputs = step.querySelectorAll('input, select, textarea');
        let valid = true;
        
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
            
            // Required field validation
            if (input.hasAttribute('required') && !input.value.trim()) {
                input.classList.add('is-invalid');
                valid = false;
            }
            // Pattern validation
            else if (input.pattern && input.value.trim() !== '' && !new RegExp(input.pattern).test(input.value.trim())) {
                input.classList.add('is-invalid');
                valid = false;
            }
            // Number validation
            else if (input.type === 'number' && input.hasAttribute('min') && input.value && parseFloat(input.value) < parseFloat(input.getAttribute('min'))) {
                input.classList.add('is-invalid');
                valid = false;
            }
            // Date validation (not in past for due date)
            else if (input.type === 'date' && input.name === 'due_date' && input.value && new Date(input.value) < new Date().setHours(0,0,0,0)) {
                input.classList.add('is-invalid');
                valid = false;
            }
        });

        // Custom validation for amounts
        if (step === steps[1]) {
            const total = parseFloat(totalAmountInput.value) || 0;
            const paid = parseFloat(paidAmountInput.value) || 0;
            
            if (paid > total) {
                paidAmountInput.classList.add('is-invalid');
                paidAmountInput.nextElementSibling.textContent = 'Paid amount cannot exceed total amount';
                valid = false;
            }
        }
        
        return valid;
    }

    // Load students based on class
    function loadStudents(classId) {
        if (!classId) {
            studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
            return;
        }

        studentSelect.classList.add('loading');
        
        fetch(`/sms/get-students/${classId}`)
            .then(response => response.json())
            .then(students => {
                studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
                students.forEach(student => {
                    studentSelect.innerHTML += `<option value="${student.id}">${student.first_name} ${student.last_name} (${student.admission_no})</option>`;
                });
            })
            .catch(error => {
                console.error('Error loading students:', error);
                studentSelect.innerHTML = '<option value="">-- Select Student --</option>';
            })
            .finally(() => {
                studentSelect.classList.remove('loading');
            });
    }

    // Load fee structures based on class
    function loadFeeStructures(classId) {
        if (!classId) {
            feeStructureSelect.innerHTML = '<option value="">-- Select Fee Structure --</option>';
            return;
        }

        feeStructureSelect.classList.add('loading');
        
        fetch(`/sms/get-fee-structures/${classId}`)
            .then(response => response.json())
            .then(structures => {
                feeStructureSelect.innerHTML = '<option value="">-- Select Fee Structure --</option>';
                structures.forEach(structure => {
                    feeStructureSelect.innerHTML += `<option value="${structure.id}" data-amount="${structure.amount}">${structure.fee_type} - ₹${parseFloat(structure.amount).toFixed(2)}</option>`;
                });
            })
            .catch(error => {
                console.error('Error loading fee structures:', error);
                feeStructureSelect.innerHTML = '<option value="">-- Select Fee Structure --</option>';
            })
            .finally(() => {
                feeStructureSelect.classList.remove('loading');
            });
    }

    // Event listeners
    nextBtns.forEach(btn => btn.addEventListener('click', () => {
        if (validateStep(steps[currentStep])) {
            if (currentStep < steps.length - 1) currentStep++;
            showStep(currentStep);
        } else {
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

    // Class change event
    classSelect.addEventListener('change', function() {
        const classId = this.value;
        loadStudents(classId);
        loadFeeStructures(classId);
    });

    // Fee structure change event
    feeStructureSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const amount = selectedOption.getAttribute('data-amount');
        totalAmountInput.value = amount || '';
        calculateAmounts();
    });

    // Paid amount change event
    paidAmountInput.addEventListener('input', calculateAmounts);

    // Real-time validation
    document.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else if (this.pattern && this.value.trim() !== '' && !new RegExp(this.pattern).test(this.value.trim())) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Form submission validation
    document.getElementById('studentFeeForm').addEventListener('submit', function(e) {
        // Update payment status one final time before submission
        updatePaymentStatus();
        
        console.log('Final payment status before submission:', paymentStatusSelect.value);
        
        let allValid = true;
        
        steps.forEach(step => {
            if (!validateStep(step)) {
                allValid = false;
            }
        });
        
        if (!allValid) {
            e.preventDefault();
            for (let i = 0; i < steps.length; i++) {
                if (!validateStep(steps[i])) {
                    currentStep = i;
                    showStep(currentStep);
                    break;
                }
            }
            alert('Please fix all validation errors before submitting the form.');
        } else {
            // Optional: Show confirmation with payment status
            const status = paymentStatusSelect.value;
            const paid = parseFloat(paidAmountInput.value) || 0;
            const total = parseFloat(totalAmountInput.value) || 0;
            
            if (status === 'Unpaid' && paid > 0) {
                if (!confirm(`You have entered paid amount of ₹${paid} but payment status is showing as Unpaid. Do you want to continue?`)) {
                    e.preventDefault();
                    return;
                }
            }
        }
    });

    // Initialize
    if (classSelect.value) {
        loadStudents(classSelect.value);
        loadFeeStructures(classSelect.value);
    }
    calculateAmounts();
});
</script>
@endsection