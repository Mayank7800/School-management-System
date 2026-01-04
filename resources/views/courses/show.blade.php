@extends('layouts.app')

@section('title', $course->name . ' - Course Details')
@section('page_title', 'Course Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $course->name }} - Details</h5>
                    <div class="btn-group">
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-light btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Course Status Alert --}}
                    @if($course->status == 'Active')
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i> This course is currently active
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i> This course is currently inactive
                        </div>
                    @endif

                    <div class="row">
                        {{-- Basic Information --}}
                        <div class="col-md-6 mb-4">
                            <h6 class="border-bottom pb-2 mb-3">Basic Information</h6>
                            <div class="row g-2">
                                <div class="col-4 fw-semibold">Course Name:</div>
                                <div class="col-8">{{ $course->name }}</div>
                                
                                <div class="col-4 fw-semibold">Short Name:</div>
                                <div class="col-8">{{ $course->short_name ?? 'N/A' }}</div>
                                
                                <div class="col-4 fw-semibold">Class Type:</div>
                                <div class="col-8">
                                    <span class="badge bg-info">{{ $course->class_type }}</span>
                                </div>
                                
                                <div class="col-4 fw-semibold">Status:</div>
                                <div class="col-8">
                                    <span class="badge {{ $course->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $course->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Statistics --}}
                        <div class="col-md-6 mb-4">
                            <h6 class="border-bottom pb-2 mb-3">Statistics</h6>
                            <div class="row g-2">
                                <div class="col-6 fw-semibold">Total Sections:</div>
                                <div class="col-6">
                                    <span class="badge bg-primary">{{ $course->sections->count() }}</span>
                                </div>
                                
                                <div class="col-6 fw-semibold">Created Date:</div>
                                <div class="col-6">{{ $course->created_at->format('d M, Y') }}</div>
                                
                                <div class="col-6 fw-semibold">Last Updated:</div>
                                <div class="col-6">{{ $course->updated_at->format('d M, Y') }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($course->description)
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h6 class="border-bottom pb-2 mb-3">Description</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $course->description }}
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Sections --}}
                    <div class="row">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Sections ({{ $course->sections->count() }})</h6>
                            @if($course->sections->count() > 0)
                                <div class="row g-2">
                                    @foreach($course->sections as $section)
                                        <div class="col-md-3 mb-2">
                                            <div class="card border">
                                                <div class="card-body text-center py-3">
                                                    <h5 class="mb-1">{{ $section->name }}</h5>
                                                    <small class="text-muted">Section</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox display-4"></i>
                                        <h5 class="mt-3">No sections found</h5>
                                        <p>This course doesn't have any sections yet.</p>
                                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle"></i> Add Sections
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar with Actions --}}
        <div class="col-lg-4">
            {{-- Quick Actions --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Course
                        </a>
                        <a href="{{ route('admissions.index', ['course' => $course->id]) }}" class="btn btn-outline-info">
                            <i class="bi bi-people"></i> View Students
                        </a>
                        
                        {{-- Toggle Status --}}
                        <form action="{{ route('courses.update', $course->id) }}" method="POST" class="d-grid">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="{{ $course->status == 'Active' ? 'Inactive' : 'Active' }}">
                            <button type="submit" class="btn btn-outline-warning">
                                <i class="bi bi-arrow-repeat"></i> 
                                {{ $course->status == 'Active' ? 'Deactivate' : 'Activate' }} Course
                            </button>
                        </form>
                        
                        {{-- Delete Course --}}
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to delete this course? This will also delete all associated sections and cannot be undone.')">
                                <i class="bi bi-trash"></i> Delete Course
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Course Timeline --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Course Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Course Created</h6>
                                <small class="text-muted">
                                    {{ $course->created_at->format('d M, Y h:i A') }}
                                </small>
                            </div>
                        </div>
                        @if($course->updated_at != $course->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Last Updated</h6>
                                <small class="text-muted">
                                    {{ $course->updated_at->format('d M, Y h:i A') }}
                                </small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-bottom {
        border-color: #dee2e6 !important;
    }
    .timeline {
        position: relative;
        padding-left: 20px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-marker {
        position: absolute;
        left: -20px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px;
    }
    .timeline-content {
        padding-left: 10px;
    }
    .card.border:hover {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 1px #0d6efd;
    }
</style>
@endsection