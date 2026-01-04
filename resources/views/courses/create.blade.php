@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">{{ isset($course) ? 'Edit Course' : 'Add New Course' }}</h4>
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

            <form id="courseForm" action="{{ isset($course) ? route('courses.update', $course->id) : route('courses.store') }}" method="POST" novalidate>
                @csrf
                @if(isset($course)) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Course Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ $course->name ?? old('name') }}" required maxlength="100">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please enter a course name.</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Short Name</label>
                        <input type="text" name="short_name" class="form-control @error('short_name') is-invalid @enderror" 
                               value="{{ $course->short_name ?? old('short_name') }}" maxlength="20">
                        @error('short_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Class Type <span class="text-danger">*</span></label>
                        <select name="class_type" class="form-select @error('class_type') is-invalid @enderror" required>
                            <option value="">-- Select Class Type --</option>
                            @php
                                $types = ['Nursery','Primary','Secondary','Higher Secondary'];
                            @endphp
                            @foreach($types as $type)
                                <option value="{{ $type }}" 
                                    @if(isset($course) && $course->class_type==$type) selected 
                                    @elseif(old('class_type') == $type) selected @endif>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a class type.</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">-- Select Status --</option>
                            <option value="Active" 
                                @if(isset($course) && $course->status=='Active') selected 
                                @elseif(old('status', 'Active') == 'Active') selected @endif>
                                Active
                            </option>
                            <option value="Inactive" 
                                @if(isset($course) && $course->status=='Inactive') selected 
                                @elseif(old('status') == 'Inactive') selected @endif>
                                Inactive
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="invalid-feedback">Please select a status.</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="3" maxlength="500">{{ $course->description ?? old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Maximum 500 characters</small>
                </div>

                {{-- ✅ Multiple Section Inputs --}}
                <div class="mb-4">
                    <label class="form-label">Sections <span class="text-danger">*</span></label>
                    <div id="section-container">
                        @php
                            // Get existing sections or old input
                            $sections = [];
                            if (isset($course) && $course->sections) {
                                $sections = $course->sections->map(function($section) {
                                    return [
                                        'name' => $section->name,
                                        'class_name' => $section->class_name ?? $course->name
                                    ];
                                })->toArray();
                            } elseif (old('sections')) {
                                $sections = old('sections');
                            } else {
                                $sections = [['name' => '', 'class_name' => isset($course) ? $course->name : '']];
                            }
                            
                            // Ensure at least one section exists
                            if (empty($sections)) {
                                $sections = [['name' => '', 'class_name' => isset($course) ? $course->name : '']];
                            }
                        @endphp
                        @foreach($sections as $index => $section)
                            <div class="mb-3 section-row border rounded p-3 bg-light">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Section Name <span class="text-danger">*</span></label>
                                        <input type="text" name="sections[{{ $index }}][name]" 
                                               class="form-control section-input @if($errors->has('sections.' . $index . '.name')) is-invalid @endif" 
                                               value="{{ $section['name'] ?? '' }}" 
                                               placeholder="Enter section name (e.g., A, B, C)" 
                                               required maxlength="10">
                                        @if($errors->has('sections.' . $index . '.name'))
                                            <div class="invalid-feedback d-block">{{ $errors->first('sections.' . $index . '.name') }}</div>
                                        @else
                                            <div class="invalid-feedback">Section name is required.</div>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Class Name <span class="text-danger">*</span></label>
                                        <input type="text" name="sections[{{ $index }}][class_name]" 
                                               class="form-control class-name-input @if($errors->has('sections.' . $index . '.class_name')) is-invalid @endif" 
                                               value="{{ $section['class_name'] ?? (isset($course) ? $course->name : '') }}" 
                                               placeholder="Enter class name" 
                                               required maxlength="100">
                                        @if($errors->has('sections.' . $index . '.class_name'))
                                            <div class="invalid-feedback d-block">{{ $errors->first('sections.' . $index . '.class_name') }}</div>
                                        @else
                                            <div class="invalid-feedback">Class name is required.</div>
                                        @endif
                                    </div>
                                </div>
                                @if($index > 0)
                                    <button type="button" class="btn btn-danger btn-sm remove-section">Remove Section</button>
                                @else
                                    <button type="button" class="btn btn-danger btn-sm remove-section" disabled>Remove Section</button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-section" class="btn btn-sm btn-primary mt-2">+ Add Another Section</button>
                    <small class="text-muted d-block mt-1">Add at least one section for this course. Each section will be saved with its class name.</small>
                    
                    {{-- Display general sections error --}}
                    @error('sections')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">{{ isset($course) ? 'Update Course' : 'Add Course' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: #dc3545;
    }
    .form-label {
        font-weight: 500;
    }
    .text-danger {
        color: #dc3545;
    }
    .section-row {
        position: relative;
    }
    .section-input, .class-name-input {
        flex: 1;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('courseForm');
    const container = document.getElementById('section-container');
    const addBtn = document.getElementById('add-section');
    const courseNameInput = document.querySelector('input[name="name"]');

    // Auto-fill class name when course name changes
    courseNameInput.addEventListener('input', function() {
        const className = this.value.trim();
        if (className) {
            // Update all class name inputs with the main course name
            const classNameInputs = container.querySelectorAll('.class-name-input');
            classNameInputs.forEach(input => {
                if (!input.value.trim()) { // Only update if empty
                    input.value = className;
                }
            });
        }
    });

    // Add section field
    addBtn.addEventListener('click', () => {
        const sectionCount = container.querySelectorAll('.section-row').length;
        const currentCourseName = courseNameInput.value.trim();
        
        const div = document.createElement('div');
        div.classList.add('mb-3', 'section-row', 'border', 'rounded', 'p-3', 'bg-light');
        div.innerHTML = `
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Section Name <span class="text-danger">*</span></label>
                    <input type="text" name="sections[${sectionCount}][name]" class="form-control section-input" placeholder="Enter section name (e.g., A, B, C)" required maxlength="10">
                    <div class="invalid-feedback">Section name is required.</div>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Class Name <span class="text-danger">*</span></label>
                    <input type="text" name="sections[${sectionCount}][class_name]" class="form-control class-name-input" placeholder="Enter class name" value="${currentCourseName}" required maxlength="100">
                    <div class="invalid-feedback">Class name is required.</div>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-section">Remove Section</button>
        `;
        container.appendChild(div);
        updateRemoveButtons();
        setupRealTimeValidationForNewFields(div);
    });

    // Remove section field
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-section')) {
            const sectionRow = e.target.closest('.section-row');
            if (container.querySelectorAll('.section-row').length > 1) {
                sectionRow.remove();
                updateRemoveButtons();
                reindexSections();
            }
        }
    });

    // Reindex sections after removal
    function reindexSections() {
        const sectionRows = container.querySelectorAll('.section-row');
        sectionRows.forEach((row, index) => {
            // Update section name input
            const sectionNameInput = row.querySelector('.section-input');
            sectionNameInput.name = `sections[${index}][name]`;
            
            // Update class name input
            const classNameInput = row.querySelector('.class-name-input');
            classNameInput.name = `sections[${index}][class_name]`;
        });
    }

    // Update remove buttons state (disable if only one section remains)
    function updateRemoveButtons() {
        const sectionRows = container.querySelectorAll('.section-row');
        const removeButtons = container.querySelectorAll('.remove-section');
        
        if (sectionRows.length === 1) {
            removeButtons[0].disabled = true;
        } else {
            removeButtons.forEach(btn => btn.disabled = false);
        }
    }

    // Setup validation for newly added fields
    function setupRealTimeValidationForNewFields(containerElement) {
        const inputs = containerElement.querySelectorAll('input');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.classList.contains('section-input')) {
                    validateSectionField(this);
                } else if (this.classList.contains('class-name-input')) {
                    validateClassNameField(this);
                }
            });
            
            input.addEventListener('input', function() {
                // Remove invalid class when user starts typing
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                    const errorDiv = this.parentElement.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.style.display = 'none';
                    }
                }
            });
        });
    }

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
                    const errorDiv = this.parentElement.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.style.display = 'none';
                    }
                }
            });
        });

        // Special handling for dynamic section inputs
        container.addEventListener('blur', function(e) {
            if (e.target.classList.contains('section-input')) {
                validateSectionField(e.target);
            } else if (e.target.classList.contains('class-name-input')) {
                validateClassNameField(e.target);
            }
        }, true);

        container.addEventListener('input', function(e) {
            if (e.target.classList.contains('section-input') || e.target.classList.contains('class-name-input')) {
                // Remove invalid state when typing
                if (e.target.classList.contains('is-invalid')) {
                    e.target.classList.remove('is-invalid');
                    const errorDiv = e.target.parentElement.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.style.display = 'none';
                    }
                }
            }
        }, true);
    }

    // Validate individual field
    function validateField(field) {
        field.classList.remove('is-invalid');
        
        // Required field validation
        if (field.hasAttribute('required') && !field.value.trim()) {
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

    // Validate section field specifically
    function validateSectionField(field) {
        const parentDiv = field.parentElement;
        const errorDiv = parentDiv.querySelector('.invalid-feedback');
        
        field.classList.remove('is-invalid');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
        
        // Required field validation
        if (field.hasAttribute('required') && !field.value.trim()) {
            field.classList.add('is-invalid');
            if (errorDiv) {
                errorDiv.style.display = 'block';
                errorDiv.textContent = 'Section name is required.';
            }
            return false;
        }
        
        // Max length validation
        if (field.hasAttribute('maxlength') && field.value.length > parseInt(field.getAttribute('maxlength'))) {
            field.classList.add('is-invalid');
            if (errorDiv) {
                errorDiv.style.display = 'block';
                errorDiv.textContent = `Section name cannot exceed ${field.getAttribute('maxlength')} characters.`;
            }
            return false;
        }
        
        return true;
    }

    // Validate class name field specifically
    function validateClassNameField(field) {
        const parentDiv = field.parentElement;
        const errorDiv = parentDiv.querySelector('.invalid-feedback');
        
        field.classList.remove('is-invalid');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
        
        // Required field validation
        if (field.hasAttribute('required') && !field.value.trim()) {
            field.classList.add('is-invalid');
            if (errorDiv) {
                errorDiv.style.display = 'block';
                errorDiv.textContent = 'Class name is required.';
            }
            return false;
        }
        
        // Max length validation
        if (field.hasAttribute('maxlength') && field.value.length > parseInt(field.getAttribute('maxlength'))) {
            field.classList.add('is-invalid');
            if (errorDiv) {
                errorDiv.style.display = 'block';
                errorDiv.textContent = `Class name cannot exceed ${field.getAttribute('maxlength')} characters.`;
            }
            return false;
        }
        
        return true;
    }

    // Validate all sections have unique names
    function validateSections() {
        const sectionInputs = container.querySelectorAll('.section-input');
        const sectionValues = Array.from(sectionInputs).map(input => input.value.trim().toLowerCase());
        const uniqueValues = new Set(sectionValues.filter(val => val !== ''));
        
        // Check for duplicates
        if (uniqueValues.size !== sectionValues.filter(val => val !== '').length) {
            // Highlight duplicate sections
            sectionInputs.forEach(input => {
                const value = input.value.trim().toLowerCase();
                if (value !== '' && sectionValues.filter(v => v === value).length > 1) {
                    input.classList.add('is-invalid');
                    const errorDiv = input.parentElement.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.style.display = 'block';
                        errorDiv.textContent = 'Section name must be unique.';
                    }
                }
            });
            return false;
        }
        
        return true;
    }

    // Validate all sections and class names are filled
    function validateAllSectionsFilled() {
        const sectionInputs = container.querySelectorAll('.section-input');
        const classNameInputs = container.querySelectorAll('.class-name-input');
        let allFilled = true;
        
        sectionInputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                const errorDiv = input.parentElement.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.style.display = 'block';
                    errorDiv.textContent = 'Section name is required.';
                }
                allFilled = false;
            }
        });

        classNameInputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                const errorDiv = input.parentElement.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.style.display = 'block';
                    errorDiv.textContent = 'Class name is required.';
                }
                allFilled = false;
            }
        });
        
        return allFilled;
    }

    // Form submission validation
    form.addEventListener('submit', function (event) {
        let formValid = true;
        
        // Validate all static fields
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (!input.classList.contains('section-input') && !input.classList.contains('class-name-input')) {
                if (!validateField(input)) {
                    formValid = false;
                }
            }
        });

        // Validate sections
        if (!validateAllSectionsFilled()) {
            formValid = false;
        }

        if (!validateSections()) {
            formValid = false;
        }

        // Check if at least one section is provided
        const sectionInputs = container.querySelectorAll('.section-input');
        const filledSections = Array.from(sectionInputs).filter(input => input.value.trim() !== '').length;
        
        if (filledSections === 0) {
            alert('Please add at least one section for this course.');
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
    updateRemoveButtons();
    setupRealTimeValidation();
});
</script>
@endsection