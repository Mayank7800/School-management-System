@extends('layouts.app')

@section('title', 'Edit Student Fees')
@section('page_title', 'Edit Student Fees')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Edit Student Fees</h5>
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

        <form id="studentFeeForm" action="{{ route('student-fees.update', $studentFee->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            {{-- STEP 1: Student & Fee Selection --}}
            <div class="form-step active card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 1: Student & Fee Selection</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Student <span class="text-danger">*</span></label>
                        <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id', $studentFee->student_id) == $student->id ? 'selected' : '' }}>
                                    {{ $student->first_name }} {{ $student->last_name }} ({{ $student->admission_no }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a student.</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fee Structure <span class="text-danger">*</span></label>
                        <select name="fee_structure_id" class="form-select @error('fee_structure_id') is-invalid @enderror" required>
                            <option value="">-- Select Fee Structure --</option>
                            @foreach($structures as $structure)
                                <option value="{{ $structure->id }}" 
                                    {{ old('fee_structure_id', $studentFee->fee_structure_id) == $structure->id ? 'selected' : '' }} 
                                    data-amount="{{ $structure->amount }}">
                                    {{ $structure->fee_type }} - ₹{{ number_format($structure->amount, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('fee_structure_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a fee structure.</div>
                        @enderror
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="button" class="btn btn-primary next-step">Next <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 2: Amount Details --}}
            <div class="form-step card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Step 2: Amount Details</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Total Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="total_amount" step="0.01" min="0" class="form-control @error('total_amount') is-invalid @enderror" 
                               value="{{ old('total_amount', $studentFee->total_amount) }}" required readonly id="total_amount">
                        @error('total_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter the total amount.</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Paid Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="paid_amount" step="0.01" min="0" class="form-control @error('paid_amount') is-invalid @enderror" 
                               value="{{ old('paid_amount', $studentFee->paid_amount) }}" required id="paid_amount">
                        @error('paid_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a valid paid amount.</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Due Amount (₹)</label>
                        <input type="number" name="due_amount" step="0.01" class="form-control" readonly id="due_amount" value="{{ $studentFee->total_amount - $studentFee->paid_amount }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" id="payment_status">
                            <option value="Unpaid" {{ old('payment_status', $studentFee->payment_status) == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="Partial" {{ old('payment_status', $studentFee->payment_status) == 'Partial' ? 'selected' : '' }}>Partial</option>
                            <option value="Paid" {{ old('payment_status', $studentFee->payment_status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" 
                               value="{{ old('due_date', $studentFee->due_date) }}" min="{{ date('Y-m-d') }}">
                        @error('due_date')
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
                        <input type="text" name="academic_year" class="form-control @error('academic_year') is-invalid @enderror" 
                               value="{{ old('academic_year', $studentFee->academic_year) }}">
                        @error('academic_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Installment Plan</label>
                        <select name="installment_plan" class="form-select @error('installment_plan') is-invalid @enderror">
                            <option value="">-- Select Plan --</option>
                            <option value="One Time" {{ old('installment_plan', $studentFee->installment_plan) == 'One Time' ? 'selected' : '' }}>One Time</option>
                            <option value="Monthly" {{ old('installment_plan', $studentFee->installment_plan) == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Quarterly" {{ old('installment_plan', $studentFee->installment_plan) == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="Half Yearly" {{ old('installment_plan', $studentFee->installment_plan) == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                            <option value="Yearly" {{ old('installment_plan', $studentFee->installment_plan) == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                        @error('installment_plan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3" 
                                  placeholder="Any additional notes...">{{ old('remarks', $studentFee->remarks) }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="Active" {{ old('status', $studentFee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $studentFee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Previous</button>
                    <button type="submit" class="btn btn-success">Update Fees <i class="bi bi-check-circle"></i></button>
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.form-step');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    const progress = document.getElementById('formProgress');
    let currentStep = 0;

    // Form elements - FIXED SELECTORS
    const totalAmountInput = document.querySelector('input[name="total_amount"]');
    const paidAmountInput = document.querySelector('input[name="paid_amount"]');
    const dueAmountInput = document.querySelector('input[name="due_amount"]');
    const paymentStatusSelect = document.querySelector('select[name="payment_status"]');
    const feeStructureSelect = document.querySelector('select[name="fee_structure_id"]');

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
        
        console.log('Updating payment status:', { total, paid });
        
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
        
        console.log('Calculating amounts:', { total, paid, due });
        
        dueAmountInput.value = due.toFixed(2);
        updatePaymentStatus();
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
            // Number validation
            else if (input.type === 'number' && input.hasAttribute('min') && input.value && parseFloat(input.value) < parseFloat(input.getAttribute('min'))) {
                input.classList.add('is-invalid');
                valid = false;
            }
        });

        // Custom validation for amounts in step 2
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

    // Fee structure change event - FIXED
    if (feeStructureSelect) {
        feeStructureSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const amount = selectedOption.getAttribute('data-amount');
            console.log('Fee structure changed:', amount);
            
            if (amount) {
                totalAmountInput.value = amount;
                calculateAmounts(); // Recalculate when fee structure changes
            }
        });
    }

    // Paid amount change event - FIXED
    if (paidAmountInput) {
        paidAmountInput.addEventListener('input', function() {
            console.log('Paid amount changed:', this.value);
            calculateAmounts();
        });
        
        paidAmountInput.addEventListener('change', function() {
            console.log('Paid amount changed (change event):', this.value);
            calculateAmounts();
        });
    }

    // Real-time validation
    document.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Form submission validation
    document.getElementById('studentFeeForm').addEventListener('submit', function(e) {
        calculateAmounts(); // Final calculation before submit
        
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
        }
    });

    // Initialize calculations
    console.log('Initializing fee form...');
    calculateAmounts(); // Calculate initial amounts
    
    // Debug: Check if elements are found
    console.log('Elements found:', {
        totalAmountInput: !!totalAmountInput,
        paidAmountInput: !!paidAmountInput,
        dueAmountInput: !!dueAmountInput,
        paymentStatusSelect: !!paymentStatusSelect,
        feeStructureSelect: !!feeStructureSelect
    });
});
</script>
@endsection