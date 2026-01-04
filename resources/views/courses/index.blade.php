@extends('layouts.app')

@section('title', 'Courses Management')
@section('page_title', 'Courses Management')

@section('content')
<div class="container-fluid py-2 py-md-4">
    <!-- ✅ Header Section - Mobile Optimized -->
    <div class="card shadow-lg border-0 mb-3 mb-md-4">
        <div class="card-header bg-gradient-primary text-white py-3 py-md-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <i class="fas fa-graduation-cap fa-2x me-2 me-md-3"></i>
                    <div>
                        <h2 class="h4 mb-1 fw-bold">Courses Management</h2>
                        <p class="mb-0 opacity-80 small d-none d-md-block">Manage all academic courses and their sections</p>
                    </div>
                </div>
                <div class="d-flex align-items-center w-100 w-md-auto justify-content-between justify-content-md-end">
                    <span class="badge bg-white text-primary fs-6 me-2 me-md-3">
                        <i class="fas fa-book me-1"></i>
                        {{ $courses->count() }}
                    </span>
                    <a href="{{ route('courses.create') }}" class="btn btn-light btn-sm btn-md-lg">
                        <i class="fas fa-plus-circle me-1 me-md-2"></i>
                        <span class="d-none d-sm-inline">Add Course</span>
                    </a>
                </div>
            </div>
            <p class="mb-0 opacity-80 small d-md-none mt-2">Manage all academic courses and their sections</p>
        </div>
    </div>

    <!-- ✅ Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3 mb-md-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div class="flex-grow-1 small">
                <strong>Success!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- ✅ Courses Table - Mobile Optimized -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white py-2 py-md-3 border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0 fw-bold text-dark h6 h5-md">
                    <i class="fas fa-list me-2 text-primary"></i>
                    All Courses
                </h5>
                <div class="d-flex gap-1 gap-md-2 w-100 w-md-auto">
                    <div class="input-group input-group-sm input-group-md flex-grow-1 flex-md-grow-0" style="min-width: 150px; max-width: 250px;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search..." id="searchInput">
                    </div>
                    <button class="btn btn-sm btn-outline-secondary d-flex align-items-center" onclick="resetSearch()">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Mobile Cards View -->
            <div class="d-md-none">
                @forelse($courses as $course)
                <div class="card m-2 border course-card">
                    <div class="card-body">
                        <!-- Course Header -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-start flex-grow-1">
                                <div class="course-icon me-2">
                                    <i class="fas fa-graduation-cap text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold text-dark">{{ $course->name }}</h6>
                                    @if($course->description)
                                        <small class="text-muted d-block">{{ Str::limit($course->description, 40) }}</small>
                                    @else
                                        <small class="text-muted fst-italic d-block">No description</small>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                @if($course->status === 'Active')
                                    <span class="badge bg-success rounded-pill px-2 py-1">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-2 py-1">
                                        <i class="fas fa-pause-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Course Details -->
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <small class="text-muted d-block">Short Name</small>
                                <span class="badge bg-light text-dark">
                                    {{ $course->short_name ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Class Type</small>
                                <span class="badge bg-primary">
                                    <i class="fas fa-chalkboard me-1"></i>
                                    {{ $course->class_type }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Sections -->
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Sections</small>
                            @if($course->sections && $course->sections->count() > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($course->sections->take(3) as $section)
                                        <span class="badge bg-info text-dark">
                                            <i class="fas fa-layer-group me-1"></i>
                                            {{ $section->name }}
                                        </span>
                                    @endforeach
                                    @if($course->sections->count() > 3)
                                        <span class="badge bg-light text-muted">
                                            +{{ $course->sections->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted fst-italic small">No sections assigned</span>
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('courses.show', $course->id) }}" 
                               class="btn btn-sm btn-outline-info d-flex align-items-center"
                               data-bs-toggle="tooltip" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('courses.edit', $course->id) }}" 
                               class="btn btn-sm btn-outline-warning d-flex align-items-center"
                               data-bs-toggle="tooltip" title="Edit Course">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                        data-bs-toggle="tooltip" title="Delete Course"
                                        onclick="return confirm('Are you sure you want to delete {{ $course->name }}? This action cannot be undone.')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                        <h4 class="h5 text-muted">No Courses Found</h4>
                        <p class="text-muted mb-4 small">Get started by creating your first course.</p>
                        <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm btn-md-lg">
                            <i class="fas fa-plus-circle me-2"></i>Create First Course
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0" id="coursesTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="20%">
                                <i class="fas fa-book me-1 text-muted"></i>Course Name
                            </th>
                            <th width="15%">
                                <i class="fas fa-tag me-1 text-muted"></i>Short Name
                            </th>
                            <th width="15%">
                                <i class="fas fa-layer-group me-1 text-muted"></i>Class Type
                            </th>
                            <th width="25%">
                                <i class="fas fa-sitemap me-1 text-muted"></i>Sections
                            </th>
                            <th width="10%">
                                <i class="fas fa-circle me-1 text-muted"></i>Status
                            </th>
                            <th width="15%" class="text-center">
                                <i class="fas fa-cogs me-1 text-muted"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr class="course-row">
                            <td class="ps-4">
                                <div class="d-flex align-items-start">
                                    <div class="course-icon me-3">
                                        <i class="fas fa-graduation-cap fa-lg text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold text-dark">{{ $course->name }}</h6>
                                        @if($course->description)
                                            <small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                        @else
                                            <small class="text-muted fst-italic">No description</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark fs-6">
                                    {{ $course->short_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary fs-7">
                                    <i class="fas fa-chalkboard me-1"></i>
                                    {{ $course->class_type }}
                                </span>
                            </td>
                            <td>
                                @if($course->sections && $course->sections->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($course->sections as $section)
                                            <span class="badge bg-info text-dark fs-7">
                                                <i class="fas fa-layer-group me-1"></i>
                                                {{ $section->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">No sections assigned</span>
                                @endif
                            </td>
                            <td>
                                @if($course->status === 'Active')
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                        <i class="fas fa-pause-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('courses.show', $course->id) }}" 
                                       class="btn btn-sm btn-outline-info d-flex align-items-center"
                                       data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('courses.edit', $course->id) }}" 
                                       class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                       data-bs-toggle="tooltip" title="Edit Course">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                data-bs-toggle="tooltip" title="Delete Course"
                                                onclick="return confirm('Are you sure you want to delete {{ $course->name }}? This action cannot be undone.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
                                    <h4 class="text-muted">No Courses Found</h4>
                                    <p class="text-muted mb-4">Get started by creating your first course.</p>
                                    <a href="{{ route('courses.create') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus-circle me-2"></i>Create First Course
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
        border: none;
    }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .table th {
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        background-color: #f8f9fa;
        padding: 1rem;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
        transition: all 0.2s ease;
    }

    .course-icon {
        width: 40px;
        height: 40px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .badge {
        font-weight: 500;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        padding: 2rem 1rem;
    }

    .alert {
        border-radius: 8px;
        border: none;
    }

    .input-group-text {
        border-radius: 6px 0 0 6px;
    }

    .form-control {
        border-radius: 0 6px 6px 0;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    /* Custom scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 8px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 8px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Animation for rows */
    .course-row, .course-card {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    /* Mobile-specific styles */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .h5-md {
            font-size: 1.1rem;
        }
        
        .btn-md-lg {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .input-group-md {
            height: auto;
        }
        
        .form-control, .input-group-text {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
        
        .course-card {
            margin-bottom: 8px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .course-card .course-icon {
            width: 35px;
            height: 35px;
        }
        
        .course-card .badge {
            font-size: 0.75rem;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .empty-state {
            padding: 1.5rem 1rem;
        }
        
        .empty-state .fa-3x {
            font-size: 2.5rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .card-header {
            padding: 0.75rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .btn-sm {
            width: 30px;
            height: 30px;
        }
        
        .badge {
            font-size: 0.7rem;
        }
        
        .course-card .card-body {
            padding: 0.75rem;
        }
    }
    
    /* Small mobile devices */
    @media (max-width: 375px) {
        .container-fluid {
            padding-left: 5px;
            padding-right: 5px;
        }
        
        .course-card {
            margin-left: 2px;
            margin-right: 2px;
        }
        
        .btn-sm {
            width: 28px;
            height: 28px;
        }
        
        .input-group {
            min-width: 120px !important;
        }
    }
    
    /* Extra small devices */
    @media (max-width: 320px) {
        .card-header .h4 {
            font-size: 1.1rem;
        }
        
        .course-card h6 {
            font-size: 0.9rem;
        }
        
        .d-flex.gap-1 {
            gap: 0.25rem !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Search functionality for both desktop and mobile
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                // Search in desktop table
                const desktopRows = document.querySelectorAll('.course-row');
                let desktopVisibleCount = 0;
                desktopRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const isVisible = text.includes(searchTerm);
                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) desktopVisibleCount++;
                });

                // Search in mobile cards
                const mobileCards = document.querySelectorAll('.course-card');
                let mobileVisibleCount = 0;
                mobileCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    const isVisible = text.includes(searchTerm);
                    card.style.display = isVisible ? '' : 'none';
                    if (isVisible) mobileVisibleCount++;
                });

                // Update the course count badge
                const countBadge = document.querySelector('.badge.bg-white');
                if (countBadge) {
                    const visibleCount = Math.max(desktopVisibleCount, mobileVisibleCount);
                    countBadge.innerHTML = `<i class="fas fa-book me-1"></i>${visibleCount} Courses`;
                }
            });
        }
    });

    function resetSearch() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.value = '';
            
            // Show all desktop rows
            const desktopRows = document.querySelectorAll('.course-row');
            desktopRows.forEach(row => row.style.display = '');
            
            // Show all mobile cards
            const mobileCards = document.querySelectorAll('.course-card');
            mobileCards.forEach(card => card.style.display = '');
            
            // Reset the course count badge
            const countBadge = document.querySelector('.badge.bg-white');
            if (countBadge) {
                countBadge.innerHTML = `<i class="fas fa-book me-1"></i>{{ $courses->count() }} Courses`;
            }
        }
    }

    // Add confirmation for delete actions
    document.querySelectorAll('form[action*="destroy"]').forEach(form => {
        const button = form.querySelector('button[type="submit"]');
        if (button) {
            button.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
@endsection