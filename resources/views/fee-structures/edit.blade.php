@extends('layouts.app')

@section('title', 'Edit Fee Structure')
@section('page_title', 'Edit Fee Structure')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Edit Fee Structure</h5>
        </div>
        <div class="card-body">
            {{-- ✅ Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- ❌ Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Please fix the following errors:
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="feeStructureForm" action="{{ route('fee-structures.update', $feeStructure->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Course <span class="text-danger">*</span></label>
                        <select name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                            <option value="">-- Select Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $feeStructure->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a course.</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Academic Year <span class="text-danger">*</span></label>
                        <input type="text" name="academic_year" class="form-control @error('academic_year') is-invalid @enderror" 
                            value="{{ old('academic_year', $feeStructure->academic_year) }}" 
                            placeholder="e.g. 2025-2026" pattern="^[0-9]{4}-[0-9]{4}$" required>
                        @error('academic_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a valid academic year (e.g. 2025-2026).</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Fee Type <span class="text-danger">*</span></label>
                        <input type="text" name="fee_type" class="form-control @error('fee_type') is-invalid @enderror" 
                            value="{{ old('fee_type', $feeStructure->fee_type) }}" 
                            placeholder="e.g. Tuition, Library, Hostel" required maxlength="100">
                        @error('fee_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a fee type.</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="amount" step="0.01" min="0" class="form-control @error('amount') is-invalid @enderror" 
                            value="{{ old('amount', $feeStructure->amount) }}" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a valid amount.</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                        rows="2" maxlength="500">{{ old('description', $feeStructure->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Maximum 500 characters</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Active" {{ old('status', $feeStructure->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $feeStructure->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback">Please select a status.</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">Update Fee Structure</button>
                    <a href="{{ route('fee-structures.index') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    input.form-control, select.form-select, textarea.form-control {
        text-transform: capitalize;
    }
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .text-danger {
        color: #dc3545;
    }
    .form-label {
        font-weight: 500;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('feeStructureForm');

    // Real-time validation
    function setupRealTimeValidation() {
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                // Remove invalid class when user starts typing
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    }

    // Validate individual field
    function validateField(field) {
        field.classList.remove('is-invalid');
        
        // Required field validation
        if (field.hasAttribute('required') && !field.value.trim()) {
            field.classList.add('is-invalid');
            return false;
        }
        
        // Pattern validation
        if (field.pattern && field.value.trim() !== '' && !new RegExp(field.pattern).test(field.value.trim())) {
            field.classList.add('is-invalid');
            return false;
        }
        
        // Number validation (min value)
        if (field.type === 'number' && field.hasAttribute('min') && field.value && parseFloat(field.value) < parseFloat(field.getAttribute('min'))) {
            field.classList.add('is-invalid');
            return false;
        }
        
        // Max length validation
        if (field.hasAttribute('maxlength') && field.value.length > parseInt(field.getAttribute('maxlength'))) {
            field.classList.add('is-invalid');
            return false;
        }
        
        return true;
    }

    // Validate academic year format
    function validateAcademicYear() {
        const academicYearInput = document.querySelector('input[name="academic_year"]');
        const academicYear = academicYearInput.value.trim();
        
        if (academicYear && !/^[0-9]{4}-[0-9]{4}$/.test(academicYear)) {
            academicYearInput.classList.add('is-invalid');
            return false;
        }
        
        return true;
    }

    // Auto-capitalize fee type
    document.querySelector('input[name="fee_type"]').addEventListener('input', function() {
        this.value = this.value
            .toLowerCase()
            .replace(/\b\w/g, char => char.toUpperCase());
    });

    // Form submission validation
    form.addEventListener('submit', function (event) {
        let formValid = true;
        
        // Validate all fields
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (!validateField(input)) {
                formValid = false;
            }
        });
        
        // Special validation for academic year
        if (!validateAcademicYear()) {
            formValid = false;
        }

        if (!formValid) {
            event.preventDefault();
            event.stopPropagation();
            
            // Scroll to first invalid field
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
        
        form.classList.add('was-validated');
    });

    // Initialize
    setupRealTimeValidation();
});
</script>
@endsection