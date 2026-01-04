{{-- resources/views/syllabus/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Syllabus Management')
@section('page_title', 'Syllabus Management')

@section('content')
<div class="container-fluid py-2 py-md-4">
    <!-- ✅ Header Section - Mobile Optimized -->
    <div class="card shadow-lg border-0 mb-3 mb-md-4">
        <div class="card-header bg-gradient-primary text-white py-3 py-md-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <i class="fas fa-book-open fa-2x me-3 d-none d-md-block"></i>
                    <i class="fas fa-book-open fa-lg me-2 d-md-none"></i>
                    <div>
                        <h4 class="mb-1 fw-bold d-md-none">Syllabus Management</h4>
                        <h2 class="mb-1 fw-bold d-none d-md-block">Syllabus Management</h2>
                        <p class="mb-0 opacity-80 small d-none d-md-block">Manage and organize academic syllabus for all classes</p>
                        <p class="mb-0 opacity-80 small d-md-none">Manage academic syllabus</p>
                    </div>
                </div>
                <a href="{{ route('syllabus.create') }}" class="btn btn-light btn-sm btn-md-lg w-100 w-md-auto">
                    <i class="fas fa-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Add New Syllabus</span>
                    <span class="d-md-none">Add Syllabus</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ✅ Filter Section - Mobile Collapsible -->
    <div class="card shadow-sm border-0 mb-3 mb-md-4">
        <div class="card-header bg-white py-2 py-md-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-filter me-2 text-primary"></i>
                    Filter Syllabus
                </h5>
                <button class="btn btn-sm btn-outline-primary d-md-none" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#filterCollapse"
                        aria-expanded="false" 
                        aria-controls="filterCollapse">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>
        <div class="collapse d-md-block" id="filterCollapse">
            <div class="card-body py-2 py-md-3">
                <form method="GET" action="{{ route('syllabus.index') }}">
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6 col-xl-3">
                            <label class="form-label fw-semibold small">Class</label>
                            <select name="class_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <label class="form-label fw-semibold small">Section</label>
                            <select name="section_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Sections</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <label class="form-label fw-semibold small">Academic Year</label>
                            <select name="academic_year" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Years</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <label class="form-label fw-semibold small d-md-none d-xl-block">&nbsp;</label>
                            <div class="d-grid">
                                <a href="{{ route('syllabus.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-redo me-1 me-md-2"></i>
                                    <span class="d-none d-md-inline">Reset Filters</span>
                                    <span class="d-md-none">Reset</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ✅ Syllabus List - Mobile Cards -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white py-2 py-md-3 border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-primary"></i>
                    <span class="d-none d-md-inline">Syllabus Records</span>
                    <span class="d-md-none">Syllabus</span>
                    <span class="badge bg-primary ms-2">{{ $syllabus->total() }}</span>
                </h5>
                <div class="d-flex gap-2 w-100 w-md-auto">
                    <div class="input-group input-group-sm flex-grow-1 flex-md-grow-0" style="min-width: 200px; max-width: 100%;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search syllabus..." id="searchInput">
                        <button class="btn btn-outline-secondary d-md-none" type="button" onclick="resetSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Desktop Table View -->
            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="25%">Title & Description</th>
                                <th width="15%">Class & Section</th>
                                <th width="12%">Academic Year</th>
                                <th width="15%">Duration</th>
                                <th width="15%">File</th>
                                <th width="8%">Status</th>
                                <th width="20%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($syllabus as $item)
                                <tr class="syllabus-row">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-start">
                                            <div class="syllabus-icon me-3">
                                                <i class="fas fa-book-open fa-2x text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold text-dark">{{ ucwords($item->title) }}</h6>
                                                @if($item->description)
                                                    <p class="mb-0 text-muted small">{{ ucwords(Str::limit($item->description, 60)) }}</p>
                                                @else
                                                    <small class="text-muted fst-italic">No description</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-primary fs-7">
                                                <i class="fas fa-graduation-cap me-1"></i>
                                                {{ ucwords($item->class->name) }}
                                            </span>
                                            <span class="badge bg-secondary fs-7">
                                                <i class="fas fa-layer-group me-1"></i>
                                                {{ ucwords($item->section->name) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark fs-7">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $item->academic_year }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-start">
                                            <div class="fw-semibold text-dark small">
                                                {{ $item->start_date->format('M d, Y') }}
                                            </div>
                                            <div class="text-muted small">
                                                to {{ $item->end_date->format('M d, Y') }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $item->start_date->diffInMonths($item->end_date) }} months
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="file-icon me-3">
                                                <i class="{{ $item->file_icon }} fa-2x text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark small text-truncate" style="max-width: 120px;">
                                                    {{ $item->file_name }}
                                                </div>
                                                <small class="text-muted">{{ $item->formatted_file_size }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                                <i class="fas fa-times-circle me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('syllabus.download', $item->id) }}" 
                                               class="btn btn-sm btn-outline-info d-flex align-items-center"
                                               data-bs-toggle="tooltip" title="Download File">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ route('syllabus.view', $item->id) }}" 
                                               class="btn btn-sm btn-outline-primary d-flex align-items-center"
                                               data-bs-toggle="tooltip" title="View Syllabus" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('syllabus.edit', $item->id) }}" 
                                               class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                               data-bs-toggle="tooltip" title="Edit Syllabus">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('syllabus.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                        data-bs-toggle="tooltip" title="Delete Syllabus"
                                                        onclick="return confirm('Are you sure you want to delete this syllabus? This action cannot be undone.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                                            <h4 class="text-muted">No Syllabus Found</h4>
                                            <p class="text-muted mb-4">No syllabus records match your current filters.</p>
                                            <a href="{{ route('syllabus.create') }}" class="btn btn-primary btn-lg">
                                                <i class="fas fa-plus-circle me-2"></i>Create First Syllabus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="d-md-none">
                <div class="syllabus-mobile-list">
                    @forelse($syllabus as $item)
                        <div class="syllabus-mobile-card">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">
                                    <!-- Header Section -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="syllabus-icon-mobile me-3">
                                                <i class="fas fa-book-open text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold text-dark">{{ ucwords($item->title) }}</h6>
                                                <div class="d-flex flex-wrap gap-1 mb-2">
                                                    <span class="badge bg-primary fs-8">
                                                        <i class="fas fa-graduation-cap me-1"></i>
                                                        {{ ucwords($item->class->name) }}
                                                    </span>
                                                    <span class="badge bg-secondary fs-8">
                                                        <i class="fas fa-layer-group me-1"></i>
                                                        {{ ucwords($item->section->name) }}
                                                    </span>
                                                    <span class="badge bg-info text-dark fs-8">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        {{ $item->academic_year }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-2">
                                            @if($item->is_active)
                                                <span class="badge bg-success rounded-pill px-2 py-1">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-2 py-1">
                                                    <i class="fas fa-times-circle me-1"></i>Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    @if($item->description)
                                        <p class="text-muted small mb-3">{{ ucwords(Str::limit($item->description, 80)) }}</p>
                                    @endif

                                    <!-- Duration & File Info -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div class="bg-light rounded p-2">
                                                <small class="text-muted d-block">Duration</small>
                                                <div class="fw-semibold text-dark small">
                                                    {{ $item->start_date->format('M d') }} - {{ $item->end_date->format('M d, Y') }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $item->start_date->diffInMonths($item->end_date) }} months
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-light rounded p-2">
                                                <small class="text-muted d-block">File</small>
                                                <div class="d-flex align-items-center">
                                                    <i class="{{ $item->file_icon }} text-primary me-2"></i>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold text-dark small text-truncate">
                                                            {{ $item->file_name }}
                                                        </div>
                                                        <small class="text-muted">{{ $item->formatted_file_size }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-1 flex-grow-1">
                                            <a href="{{ route('syllabus.download', $item->id) }}" 
                                               class="btn btn-sm btn-outline-info flex-fill d-flex align-items-center justify-content-center py-2">
                                                <i class="fas fa-download me-1"></i>
                                                <span class="d-none d-sm-inline">Download</span>
                                            </a>
                                            <a href="{{ route('syllabus.view', $item->id) }}" 
                                               class="btn btn-sm btn-outline-primary flex-fill d-flex align-items-center justify-content-center py-2"
                                               target="_blank">
                                                <i class="fas fa-eye me-1"></i>
                                                <span class="d-none d-sm-inline">View</span>
                                            </a>
                                        </div>
                                        <div class="dropdown ms-2">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    type="button" 
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('syllabus.edit', $item->id) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('syllabus.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="dropdown-item text-danger"
                                                                onclick="return confirm('Are you sure you want to delete this syllabus?')">
                                                            <i class="fas fa-trash me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Syllabus Found</h5>
                                <p class="text-muted mb-4 small">No syllabus records match your current filters.</p>
                                <a href="{{ route('syllabus.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Create First Syllabus
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($syllabus->hasPages())
                <div class="card-footer bg-light py-2 py-md-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small">
                            Showing {{ $syllabus->firstItem() }} to {{ $syllabus->lastItem() }} of {{ $syllabus->total() }} entries
                        </div>
                        <nav>
                            {{ $syllabus->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Base Styles */
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

    /* Desktop Table Styles */
    .table th {
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        background-color: #f8f9fa;
        padding: 0.75rem 1rem;
    }

    .table td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transition: all 0.2s ease;
    }

    .syllabus-icon {
        width: 50px;
        height: 50px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .file-icon {
        width: 40px;
        height: 40px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Mobile Card Styles */
    .syllabus-mobile-card .card {
        border-radius: 10px;
        margin-bottom: 0.75rem;
    }

    .syllabus-icon-mobile {
        width: 40px;
        height: 40px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge {
        font-weight: 500;
    }

    .fs-8 {
        font-size: 0.75rem !important;
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-sm {
        min-height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-md-lg {
        padding: 0.5rem 1rem;
    }

    @media (max-width: 768px) {
        .btn-md-lg {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }

    /* Form Styles */
    .form-select, .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-select:focus, .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
    }

    .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }

    /* Empty State */
    .empty-state {
        padding: 2rem 1rem;
    }

    /* Pagination */
    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border-radius: 6px;
        margin: 0 1px;
        border: 1px solid #e9ecef;
        padding: 0.375rem 0.75rem;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }

    /* Mobile Optimizations */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        h2 {
            font-size: 1.5rem;
        }
        
        h4 {
            font-size: 1.25rem;
        }
        
        h5 {
            font-size: 1.1rem;
        }
        
        h6 {
            font-size: 0.95rem;
        }
        
        .small {
            font-size: 0.8rem;
        }
        
        .btn {
            min-height: 44px; /* Touch target size */
        }
        
        .dropdown-menu {
            font-size: 0.9rem;
        }
        
        /* Improve spacing for mobile */
        .row.g-2 {
            margin-left: -0.25rem;
            margin-right: -0.25rem;
        }
        
        .row.g-2 > [class*="col-"] {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        
        /* Collapsible filter animation */
        .collapse:not(.show) {
            display: none;
        }
        
        .collapsing {
            transition: height 0.35s ease;
        }
    }

    /* Custom scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Animation for rows */
    .syllabus-row, .syllabus-mobile-card {
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

    /* Hide desktop elements on mobile and vice versa */
    @media (max-width: 767.98px) {
        .d-md-block {
            display: none !important;
        }
    }

    @media (min-width: 768px) {
        .d-md-none {
            display: none !important;
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

        // Simple search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                // Search in desktop table
                const desktopRows = document.querySelectorAll('.syllabus-row');
                desktopRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
                
                // Search in mobile cards
                const mobileCards = document.querySelectorAll('.syllabus-mobile-card');
                mobileCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }

        // Auto-refresh sections when class changes
        const classSelect = document.querySelector('select[name="class_id"]');
        const sectionSelect = document.querySelector('select[name="section_id"]');
        
        if (classSelect && sectionSelect) {
            classSelect.addEventListener('change', function() {
                const classId = this.value;
                if (classId) {
                    // Show loading state
                    sectionSelect.innerHTML = '<option value="">Loading sections...</option>';
                    
                    fetch(`/get-sections/${classId}`)
                        .then(response => response.json())
                        .then(sections => {
                            sectionSelect.innerHTML = '<option value="">All Sections</option>';
                            sections.forEach(section => {
                                sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                            });
                        })
                        .catch(error => {
                            console.error('Error loading sections:', error);
                            sectionSelect.innerHTML = '<option value="">Error loading sections</option>';
                        });
                } else {
                    sectionSelect.innerHTML = '<option value="">All Sections</option>';
                }
            });
        }

        // Auto-expand filter on mobile when filters are applied
        const urlParams = new URLSearchParams(window.location.search);
        if (window.innerWidth < 768 && (urlParams.has('class_id') || urlParams.has('section_id') || urlParams.has('academic_year'))) {
            const filterCollapse = document.getElementById('filterCollapse');
            if (filterCollapse) {
                new bootstrap.Collapse(filterCollapse, { show: true });
            }
        }
    });

    function resetSearch() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.value = '';
            
            // Show all desktop rows
            const desktopRows = document.querySelectorAll('.syllabus-row');
            desktopRows.forEach(row => row.style.display = '');
            
            // Show all mobile cards
            const mobileCards = document.querySelectorAll('.syllabus-mobile-card');
            mobileCards.forEach(card => card.style.display = '');
        }
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        // Reinitialize tooltips on resize
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection