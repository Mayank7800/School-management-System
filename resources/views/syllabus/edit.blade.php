{{-- resources/views/syllabus/edit.blade.php --}}
@extends('layouts.app')

@section('content')
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Syllabus</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('syllabus.index') }}">Syllabus</a></li>
                        <li class="breadcrumb-item active">Edit Syllabus</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a href="{{ route('syllabus.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Syllabus Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('syllabus.update', $syllabus->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Current File Info -->
                            <div class="form-group">
                                <label>Current File</label>
                                <div class="current-file-info bg-light p-3 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="{{ $syllabus->file_icon }} fa-2x me-3 text-primary"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $syllabus->file_name }}</h6>
                                            <small class="text-muted">
                                                {{ $syllabus->formatted_file_size }} • 
                                                Uploaded: {{ $syllabus->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                        <div class="file-actions">
                                            <a href="{{ route('syllabus.download', $syllabus->id) }}" class="btn btn-sm btn-info" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ route('syllabus.view', $syllabus->id) }}" class="btn btn-sm btn-primary" title="View" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Class <span class="text-danger">*</span></label>
                                        <select name="class_id" class="form-control"  id="classSelect">
                                            <option value="">Select Class</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" 
                                                    {{ old('class_id', $syllabus->class_id) == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Section <span class="text-danger">*</span></label>
                                        <select name="section_id" class="form-control"  id="sectionSelect">
                                            <option value="">Select Section</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" 
                                                    {{ old('section_id', $syllabus->section_id) == $section->id ? 'selected' : '' }}>
                                                    {{ $section->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('section_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" 
                                       value="{{ old('title', $syllabus->title) }}" 
                                       placeholder="Enter syllabus title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3" 
                                          placeholder="Enter syllabus description">{{ old('description', $syllabus->description) }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Academic Year <span class="text-danger">*</span></label>
                                        <select name="academic_year" class="form-control" >
                                            <option value="">Select Academic Year</option>
                                            @foreach($academicYears as $year)
                                                <option value="{{ $year }}" 
                                                    {{ old('academic_year', $syllabus->academic_year) == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('academic_year')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Replace File</label>
                                        <input type="file" name="syllabus_file" class="form-control-file" 
                                               accept=".pdf,.doc,.docx,.txt,.ppt,.pptx,.xls,.xlsx">
                                        <small class="form-text text-muted">
                                            Leave empty to keep current file. Allowed: PDF, Word, Text, PowerPoint, Excel (Max: 10MB)
                                        </small>
                                        @error('syllabus_file')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span></label>
                                        <input type="date" name="start_date" class="form-control" 
                                               value="{{ old('start_date', $syllabus->start_date->format('Y-m-d')) }}" >
                                        @error('start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <input type="date" name="end_date" class="form-control" 
                                               value="{{ old('end_date', $syllabus->end_date->format('Y-m-d')) }}" >
                                        @error('end_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" 
                                           class="form-check-input" id="is_active"
                                           {{ old('is_active', $syllabus->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Syllabus
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    Inactive syllabus won't be visible to students
                                </small>
                            </div>

                            <!-- Additional Information -->
                            <div class="card bg-light mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">Additional Information</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <strong>Created By:</strong> {{ $syllabus->createdBy->name ?? 'System' }}<br>
                                                <strong>Created At:</strong> {{ $syllabus->created_at->format('M d, Y h:i A') }}
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <strong>Last Updated:</strong> {{ $syllabus->updated_at->format('M d, Y h:i A') }}<br>
                                                <strong>Duration:</strong> {{ $syllabus->start_date->diffInDays($syllabus->end_date) }} days
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Syllabus
                                </button>
                                <a href="{{ route('syllabus.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                
                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
   

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5>Are you sure you want to delete this syllabus?</h5>
                    <p class="text-muted">
                        <strong>{{ $syllabus->title }}</strong><br>
                        Class: {{ $syllabus->class->name }} - {{ $syllabus->section->name }}<br>
                        This action cannot be undone.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('syllabus.destroy', $syllabus->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete Syllabus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.current-file-info {
    border-left: 4px solid #0d6efd;
}

.file-actions .btn {
    margin-left: 5px;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.card.bg-light {
    border: 1px solid #dee2e6;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.form-control, .form-select {
    border-radius: 6px;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('classSelect');
    const sectionSelect = document.getElementById('sectionSelect');

    // Function to load sections based on selected class
    function loadSections(classId) {
        if (classId) {
            fetch(`/get-sections/${classId}`)
                .then(response => response.json())
                .then(sections => {
                    // Store current selected section
                    const currentSectionId = '{{ $syllabus->section_id }}';
                    
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    sections.forEach(section => {
                        const selected = section.id == currentSectionId ? 'selected' : '';
                        sectionSelect.innerHTML += `<option value="${section.id}" ${selected}>${section.section_name}</option>`;
                    });
                })
                .catch(error => console.error('Error loading sections:', error));
        } else {
            sectionSelect.innerHTML = '<option value="">Select Section</option>';
        }
    }

    // Load sections when class changes
    classSelect.addEventListener('change', function() {
        loadSections(this.value);
    });

    // Validate end date is after start date
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');

    function validateDates() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (startDate && endDate && endDate <= startDate) {
            endDateInput.setCustomValidity('End date must be after start date');
        } else {
            endDateInput.setCustomValidity('');
        }
    }

    startDateInput.addEventListener('change', validateDates);
    endDateInput.addEventListener('change', validateDates);

    // File input change handler
    const fileInput = document.querySelector('input[name="syllabus_file"]');
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const fileSize = file.size / 1024 / 1024; // MB
            const allowedTypes = ['pdf', 'doc', 'docx', 'txt', 'ppt', 'pptx', 'xls', 'xlsx'];
            const fileExtension = file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(fileExtension)) {
                alert('Invalid file type. Please select a PDF, Word, Excel, PowerPoint, or Text file.');
                this.value = '';
                return;
            }

            if (fileSize > 10) {
                alert('File size must be less than 10MB.');
                this.value = '';
                return;
            }
        }
    });

    // Form submission handler
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (endDate <= startDate) {
            e.preventDefault();
            alert('End date must be after start date.');
            return;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection