{{-- resources/views/syllabus/create.blade.php --}}
@extends('layouts.app')

@section('content')
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add New Syllabus</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('syllabus.index') }}">Syllabus</a></li>
                        <li class="breadcrumb-item active">Add Syllabus</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('syllabus.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Class <span class="text-danger">*</span></label>
                                        <select name="class_id" class="form-control"  id="classSelect">
                                            <option value="">Select Class</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
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
                                            <option value="">Select Class</option>
                                              @foreach($sections as $class)
                                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
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
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" >
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
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
                                                <option value="{{ $year }}" {{ old('academic_year') == $year ? 'selected' : '' }}>
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
                                        <label>Syllabus File <span class="text-danger">*</span></label>
                                        <input type="file" name="syllabus_file" class="form-control-file" accept=".pdf,.doc,.docx,.txt,.ppt,.pptx,.xls,.xlsx" >
                                        <small class="form-text text-muted">Allowed: PDF, Word, Text, PowerPoint, Excel (Max: 10MB)</small>
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
                                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" >
                                        @error('start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" >
                                        @error('end_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Upload Syllabus</button>
                                <a href="{{ route('syllabus.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
   
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const classSelect = document.getElementById('classSelect');
        const sectionSelect = document.getElementById('sectionSelect');

        classSelect.addEventListener('change', function() {
            const classId = this.value;
            sectionSelect.innerHTML = '<option value="">Select Section</option>';
            
            if (classId) {
                fetch(`/get-sections/${classId}`)
                    .then(response => response.json())
                    .then(sections => {
                        sections.forEach(section => {
                            sectionSelect.innerHTML += `<option value="${section.id}">${section.section_name}</option>`;
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Trigger change on page load if class is preselected
        if (classSelect.value) {
            classSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection