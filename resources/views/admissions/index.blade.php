@extends('layouts.app')

@section('title', 'Students')
@section('page_title', 'Student Management')

@section('content')
<div class="container-fluid py-2 py-md-4">
    <!-- ✅ Header Section - Mobile Optimized -->
    <div class="card shadow-lg border-0 mb-3 mb-md-4">
        <div class="card-header bg-gradient-primary text-white py-3 py-md-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <i class="fas fa-user-graduate fa-lg fa-2x-md me-2 me-md-3"></i>
                    <div>
                        <h4 class="mb-1 fw-bold d-md-none">Students</h4>
                        <h2 class="mb-1 fw-bold d-none d-md-block">Student Management</h2>
                        <p class="mb-0 opacity-80 small d-none d-md-block">Manage all student records and information</p>
                        <p class="mb-0 opacity-80 small d-md-none">Manage student records</p>
                    </div>
                </div>
                <!-- ✅ Fixed Add Student Button -->
                <a href="{{ route('admissions.create') }}" class="btn btn-light btn-sm btn-md-lg w-100 w-md-auto text-nowrap">
                    <i class="fas fa-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Add New Student</span>
                    <span class="d-md-none">Add Student</span>
                </a>
            </div>
        </div>
    </div>
            <p class="mb-0 opacity-80 small d-md-none mt-2">Manage all student records and admissions</p>
        </div>

        <div class="card-body p-2 p-md-4">
            {{-- Search & Filters - Mobile Optimized --}}
            <div class="row mb-3 mb-md-4 g-2">
                <div class="col-12 col-md-8">
                    <form action="{{ route('admissions.index') }}" method="GET" class="search-form">
                        <div class="input-group input-group-md shadow-sm">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ request('q') }}" 
                                class="form-control border-start-0" 
                                placeholder="Search students..."
                            >
                            @if(request('q'))
                                <a href="{{ route('admissions.index') }}" class="input-group-text bg-light border-start-0">
                                    <i class="fas fa-times text-muted"></i>
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary px-3 px-md-4">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-4 text-start text-md-end">
                    <div class="btn-group shadow-sm w-100 w-md-auto">
                        <button type="button" class="btn btn-outline-primary btn-sm btn-md-lg dropdown-toggle w-100 w-md-auto" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1 me-md-2"></i>
                            <span>Filters</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end w-100">
                            <li><a class="dropdown-item" href="{{ route('admissions.index', ['status' => 'Active']) }}">Active Students</a></li>
                            <li><a class="dropdown-item" href="{{ route('admissions.index', ['status' => 'Inactive']) }}">Inactive Students</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admissions.index') }}">All Students</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div class="flex-grow-1 small">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Students Table - Mobile Optimized --}}
            <div class="table-responsive rounded-3 border shadow-sm">
                {{-- Mobile Cards View --}}
                <div class="d-md-none">
                    @forelse($students as $student)
                    <div class="card m-2 border student-card">
                        <div class="card-body">
                            {{-- Student Header --}}
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <div class="student-avatar me-2">
                                        <div class="avatar-placeholder bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-semibold text-dark">{{ $student->first_name }} {{ $student->last_name }}</h6>
                                        <small class="text-muted">{{ $student->admission_no }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    @if($student->status === 'Active')
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
                            
                            {{-- Student Details --}}
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Class</small>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-graduation-cap me-1"></i>
                                        {{ $student->course_name ?? 'Not assigned' }}
                                    </span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Section</small>
                                    <span class="badge bg-light text-dark">
                                        {{ $student->section ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Contact Info --}}
                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Contact</small>
                                <div class="d-flex justify-content-between">
                                    @if($student->email)
                                        <small class="text-truncate me-2">
                                            <i class="fas fa-envelope me-1 text-muted"></i>
                                            {{ Str::limit($student->email, 20) }}
                                        </small>
                                    @endif
                                    @if($student->mobile_no)
                                        <small>
                                            <i class="fas fa-mobile-alt me-1 text-muted"></i>
                                            {{ $student->mobile_no }}
                                        </small>
                                    @endif
                                </div>
                                @if($student->city)
                                    <small class="text-muted">
                                        <i class="fas fa-city me-1"></i>
                                        {{ $student->city }}
                                    </small>
                                @endif
                            </div>
                            
                            {{-- Actions --}}
                            <div class="d-flex justify-content-between gap-1">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admissions.show', $student->id) }}" 
                                       class="btn btn-sm btn-outline-info d-flex align-items-center"
                                       data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admissions.edit', $student->id) }}" 
                                       class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                       data-bs-toggle="tooltip" title="Edit Student">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                
                                <div class="d-flex gap-1">
                                    {{-- WhatsApp Dropdown --}}
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-success dropdown-toggle d-flex align-items-center" 
                                                type="button" data-bs-toggle="dropdown"
                                                data-bs-toggle="tooltip" title="Quick Actions">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <form action="{{ route('whatsapp.form') }}" method="POST" class="d-inline w-100">
                                                    @csrf
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="template_name" value="attendance_update">
                                                    <input type="hidden" name="parameters[]" value="{{ $student->first_name }} {{ $student->last_name }}">
                                                    <input type="hidden" name="parameters[]" value="{{ date('Y-m-d') }}">
                                                    <input type="hidden" name="parameters[]" value="Present">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-user-check me-2 text-success"></i>Mark Present
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('whatsapp.form') }}" method="POST" class="d-inline w-100">
                                                    @csrf
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="template_name" value="fee_reminder">
                                                    <input type="hidden" name="parameters[]" value="{{ $student->first_name }} {{ $student->last_name }}">
                                                    <input type="hidden" name="parameters[]" value="1500.00">
                                                    <input type="hidden" name="parameters[]" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-money-bill-wave me-2 text-warning"></i>Fee Reminder
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-comment me-2 text-primary"></i>Custom Message
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admissions.destroy', $student->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete {{ $student->first_name }}? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                data-bs-toggle="tooltip" title="Delete Student">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <div class="empty-state">
                            <i class="fas fa-user-slash fa-3x text-muted mb-2"></i>
                            <h4 class="h5 text-muted">No Students Found</h4>
                            <p class="text-muted mb-3 small">No students match your search criteria.</p>
                            <a href="{{ route('admissions.create') }}" class="btn btn-primary btn-sm btn-md-lg">
                                <i class="fas fa-plus-circle me-2"></i>Add Your First Student
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
                
                {{-- Desktop Table View --}}
                <table class="table table-hover align-middle mb-0 d-none d-md-table">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="12%">
                                <i class="fas fa-id-card me-1 text-muted"></i>Admission No
                            </th>
                            <th width="25%">
                                <i class="fas fa-user me-1 text-muted"></i>Student Name
                            </th>
                            <th width="15%">
                                <i class="fas fa-chalkboard me-1 text-muted"></i>Class
                            </th>
                            <th width="12%">
                                <i class="fas fa-layer-group me-1 text-muted"></i>Section
                            </th>
                            <th width="15%">
                                <i class="fas fa-phone me-1 text-muted"></i>Mobile
                            </th>
                            <th width="10%">
                                <i class="fas fa-circle me-1 text-muted"></i>Status
                            </th>
                            <th width="21%" class="text-center">
                                <i class="fas fa-cogs me-1 text-muted"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr class="student-row">
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $student->admission_no }}</div>
                                <small class="text-muted">City: {{ $student->city }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="student-avatar me-3">
                                        <div class="avatar-placeholder bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $student->first_name }} {{ $student->last_name }}</div>
                                        <small class="text-muted">{{ $student->email ?? 'No email' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark fs-7">
                                    <i class="fas fa-graduation-cap me-1"></i>
                                    {{ $student->course_name ?? 'Not assigned' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark fs-7">
                                    {{ $student->section ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if($student->mobile_no)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-mobile-alt me-2 text-muted"></i>
                                        {{ $student->mobile_no }}
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Not provided</span>
                                @endif
                            </td>
                            <td>
                                @if($student->status === 'Active')
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
                                    {{-- View Button --}}
                                    <a href="{{ route('admissions.show', $student->id) }}" 
                                       class="btn btn-sm btn-outline-info d-flex align-items-center"
                                       data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('admissions.edit', $student->id) }}" 
                                       class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                       data-bs-toggle="tooltip" title="Edit Student">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- WhatsApp Dropdown --}}
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-success dropdown-toggle d-flex align-items-center" 
                                                type="button" data-bs-toggle="dropdown"
                                                data-bs-toggle="tooltip" title="Quick Actions">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <form action="{{ route('whatsapp.form') }}" method="POST" class="d-inline w-100">
                                                    @csrf
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="template_name" value="attendance_update">
                                                    <input type="hidden" name="parameters[]" value="{{ $student->first_name }} {{ $student->last_name }}">
                                                    <input type="hidden" name="parameters[]" value="{{ date('Y-m-d') }}">
                                                    <input type="hidden" name="parameters[]" value="Present">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-user-check me-2 text-success"></i>Mark Present
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('whatsapp.form') }}" method="POST" class="d-inline w-100">
                                                    @csrf
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="template_name" value="fee_reminder">
                                                    <input type="hidden" name="parameters[]" value="{{ $student->first_name }} {{ $student->last_name }}">
                                                    <input type="hidden" name="parameters[]" value="1500.00">
                                                    <input type="hidden" name="parameters[]" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-money-bill-wave me-2 text-warning"></i>Fee Reminder
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-comment me-2 text-primary"></i>Custom Message
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('admissions.destroy', $student->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete {{ $student->first_name }}? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                data-bs-toggle="tooltip" title="Delete Student">
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
                                    <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                                    <h4 class="text-muted">No Students Found</h4>
                                    <p class="text-muted mb-4">No students match your search criteria.</p>
                                    <a href="{{ route('admissions.create') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus-circle me-2"></i>Add Your First Student
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination - Mobile Optimized --}}
            @if($students->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 mt-md-4 gap-2">
                    <div class="text-muted small text-center text-md-start">
                        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} entries
                    </div>
                    <nav>
                        {{ $students->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            @endif
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

    .search-form .input-group {
        border-radius: 8px;
    }

    .search-form .form-control {
        border-radius: 0 8px 8px 0;
        border: 1px solid #e9ecef;
        border-left: none;
    }

    .search-form .input-group-text {
        border-radius: 8px 0 0 8px;
        border: 1px solid #e9ecef;
        border-right: none;
    }

    .search-form .form-control:focus {
        border-color: #667eea;
        box-shadow: none;
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

    .student-avatar .avatar-placeholder {
        width: 40px;
        height: 40px;
        background: rgba(102, 126, 234, 0.1);
    }

    .btn {
        border-radius: 6px;
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

    .badge {
        font-weight: 500;
    }

    .empty-state {
        padding: 2rem 1rem;
    }

    .dropdown-menu {
        border-radius: 8px;
        border: 1px solid #e9ecef;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .dropdown-item {
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
        margin: 0.1rem 0.25rem;
        font-size: 0.875rem;
    }

    .dropdown-item:hover {
        background-color: rgba(102, 126, 234, 0.1);
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border-radius: 6px;
        margin: 0 1px;
        border: 1px solid #e9ecef;
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
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

    /* Animation for new rows */
    .student-row, .student-card {
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
            padding-left: 8px;
            padding-right: 8px;
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
            padding: 0.5rem 0.75rem;
        }
        
        .student-card {
            margin-bottom: 8px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .student-card .student-avatar .avatar-placeholder {
            width: 35px;
            height: 35px;
        }
        
        .student-card .badge {
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
        
        .dropdown-menu {
            font-size: 0.875rem;
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
        
        .student-card .card-body {
            padding: 0.75rem;
        }
        
        .search-form .btn {
            padding: 0.5rem 0.75rem;
        }
    }
    
    /* Small mobile devices */
    @media (max-width: 375px) {
        .container-fluid {
            padding-left: 5px;
            padding-right: 5px;
        }
        
        .student-card {
            margin-left: 2px;
            margin-right: 2px;
        }
        
        .btn-sm {
            width: 28px;
            height: 28px;
        }
        
        .dropdown-item {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
        }
    }
    
    /* Extra small devices */
    @media (max-width: 320px) {
        .card-header .h4 {
            font-size: 1.1rem;
        }
        
        .student-card h6 {
            font-size: 0.9rem;
        }
        
        .d-flex.gap-1 {
            gap: 0.25rem !important;
        }
        
        .input-group .btn {
            font-size: 0.8rem;
            padding: 0.375rem 0.5rem;
        }
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    // Add confirmation for delete actions
    document.querySelectorAll('form[action*="destroy"]').forEach(form => {
        const button = form.querySelector('button[type="submit"]');
        if (button) {
            button.addEventListener('click', function(e) {
                const studentName = this.closest('.student-card, .student-row')
                    .querySelector('.fw-semibold, .fw-bold')
                    .textContent.trim();
                    
                if (!confirm(`Are you sure you want to delete ${studentName}? This action cannot be undone.`)) {
                    e.preventDefault();
                }
            });
        }
    });

    // Mobile search enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="q"]');
        if (searchInput && window.innerWidth < 768) {
            searchInput.placeholder = "Search students...";
        }
    });
</script>
@endsection