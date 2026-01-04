@extends('layouts.app')

@section('title', 'Fee Structures')
@section('page_title', 'Fee Structures Management')

@section('content')
<div class="container-fluid py-2 py-md-4">
    <!-- ✅ Header Section - Mobile Optimized -->
    <div class="card shadow-lg border-0 mb-3 mb-md-4">
        <div class="card-header bg-gradient-primary text-white py-3 py-md-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <i class="fas fa-money-bill-wave fa-2x me-2 me-md-3"></i>
                    <div>
                        <h2 class="h4 mb-1 fw-bold">Fee Structures Management</h2>
                        <p class="mb-0 opacity-80 small d-none d-md-block">Manage fee structures for different courses and academic years</p>
                    </div>
                </div>
                <div class="d-flex align-items-center w-100 w-md-auto justify-content-between justify-content-md-end">
                    <span class="badge bg-white text-primary fs-6 me-2 me-md-3">
                        <i class="fas fa-list me-1"></i>
                        {{ $feeStructures->total() }}
                    </span>
                    <a href="{{ route('fee-structures.create') }}" class="btn btn-light btn-sm btn-md-lg">
                        <i class="fas fa-plus-circle me-1 me-md-2"></i>
                        <span class="d-none d-sm-inline">Add New</span>
                    </a>
                </div>
            </div>
            <p class="mb-0 opacity-80 small d-md-none mt-2">Manage fee structures for different courses and academic years</p>
        </div>
    </div>

    <!-- ✅ Search & Filters - Mobile Optimized -->
    <div class="card shadow-sm border-0 mb-3 mb-md-4">
        <div class="card-header bg-white py-2 py-md-3">
            <h5 class="mb-0 fw-bold text-dark h6 h5-md">
                <i class="fas fa-filter me-2 text-primary"></i>
                Search & Filter
            </h5>
        </div>
        <div class="card-body p-2 p-md-3">
            <form method="GET" action="{{ route('fee-structures.index') }}">
                <div class="row g-2 g-md-3">
                    <div class="col-12 col-md-6 col-xl-4">
                        <label class="form-label fw-semibold small">Search</label>
                        <div class="input-group input-group-sm input-group-md">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control border-start-0" 
                                   placeholder="Search by fee type, course, amount...">
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold small">Academic Year</label>
                        <select name="academic_year" class="form-select form-select-sm form-select-md" onchange="this.form.submit()">
                            <option value="">All Years</option>
                            @php
                                $years = range(date('Y'), date('Y') - 5);
                            @endphp
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>
                                    {{ $year }}-{{ $year + 1 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-6 col-xl-3">
                        <label class="form-label fw-semibold small">Status</label>
                        <select name="status" class="form-select form-select-sm form-select-md" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-xl-2">
                        <label class="form-label fw-semibold small d-md-none">&nbsp;</label>
                        <div class="d-flex gap-1 gap-md-2">
                            <button type="submit" class="btn btn-primary flex-grow-1 btn-sm btn-md-lg">
                                <i class="fas fa-search me-1 me-md-2"></i>
                                <span class="d-none d-sm-inline">Search</span>
                            </button>
                            <a href="{{ route('fee-structures.index') }}" class="btn btn-outline-secondary btn-sm btn-md-lg">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            @if(request()->has('search') && !empty(request('search')))
                <div class="alert alert-info mt-2 mt-md-3 d-flex align-items-center small py-2">
                    <i class="fas fa-info-circle me-2"></i>
                    <div class="flex-grow-1">
                        Showing results for: "<strong>{{ request('search') }}</strong>"
                    </div>
                    <a href="{{ route('fee-structures.index') }}" class="text-decoration-none ms-2">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- ✅ Fee Structures Table - Mobile Optimized -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white py-2 py-md-3 border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <h5 class="mb-1 mb-md-0 fw-bold text-dark h6 h5-md">
                    <i class="fas fa-list me-2 text-primary"></i>
                    Fee Structures
                </h5>
                <div class="text-muted small">
                    Showing {{ $feeStructures->firstItem() }} to {{ $feeStructures->lastItem() }} of {{ $feeStructures->total() }} entries
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Mobile Cards View -->
            <div class="d-md-none">
                @forelse ($feeStructures as $key => $structure)
                    <div class="card m-2 border fee-structure-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="fw-bold text-dark">{{ $structure->course->name ?? '—' }}</div>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-receipt me-1"></i>
                                    {{ ucwords($structure->fee_type) }}
                                </span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fw-bold text-success">₹{{ number_format($structure->amount, 2) }}</div>
                                @if($structure->status == 'Active')
                                    <span class="badge bg-success rounded-pill px-2 py-1">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-2 py-1">
                                        <i class="fas fa-times-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $structure->academic_year }}
                                </span>
                                <small class="text-muted">
                                    {{ $structure->created_at->format('d M Y') }}
                                </small>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('fee-structures.edit', $structure->id) }}" 
                                   class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                   data-bs-toggle="tooltip" title="Edit Structure">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('fee-structures.destroy', $structure->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                            data-bs-toggle="tooltip" title="Delete Structure"
                                            onclick="return confirm('Are you sure you want to delete this fee structure? This action cannot be undone.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-money-bill-wave fa-3x fa-4x-md text-muted mb-3"></i>
                            <h4 class="h5 text-muted">No Fee Structures Found</h4>
                            <p class="text-muted mb-4 small">
                                @if(request()->anyFilled(['search', 'academic_year', 'status']))
                                    No structures match your current filters.
                                @else
                                    Get started by creating your first fee structure.
                                @endif
                            </p>
                            <a href="{{ route('fee-structures.create') }}" class="btn btn-primary btn-sm btn-md-lg">
                                <i class="fas fa-plus-circle me-2"></i>Create First Structure
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="5%">#</th>
                            <th width="20%">
                                <i class="fas fa-graduation-cap me-1 text-muted"></i>Course
                            </th>
                            <th width="20%">
                                <i class="fas fa-tag me-1 text-muted"></i>Fee Type
                            </th>
                            <th width="15%">
                                <i class="fas fa-money-bill me-1 text-muted"></i>Amount
                            </th>
                            <th width="15%">
                                <i class="fas fa-calendar-alt me-1 text-muted"></i>Academic Year
                            </th>
                            <th width="10%">
                                <i class="fas fa-circle me-1 text-muted"></i>Status
                            </th>
                            <th width="15%">
                                <i class="fas fa-clock me-1 text-muted"></i>Created At
                            </th>
                            <th width="15%" class="text-center">
                                <i class="fas fa-cogs me-1 text-muted"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feeStructures as $key => $structure)
                            <tr class="fee-structure-row">
                                <td class="ps-4 fw-semibold text-muted">{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="course-icon me-3">
                                            <i class="fas fa-book text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $structure->course->name ?? '—' }}</div>
                                            <small class="text-muted">{{ $structure->course->class_type ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark fs-6">
                                        <i class="fas fa-receipt me-1"></i>
                                        {{ ucwords($structure->fee_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success fs-5">
                                        ₹{{ number_format($structure->amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark fs-7">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $structure->academic_year }}
                                    </span>
                                </td>
                                <td>
                                    @if($structure->status == 'Active')
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
                                    <div class="text-start">
                                        <div class="fw-semibold text-dark small">
                                            {{ $structure->created_at->format('d M Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $structure->created_at->format('h:i A') }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('fee-structures.edit', $structure->id) }}" 
                                           class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                           data-bs-toggle="tooltip" title="Edit Structure">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('fee-structures.destroy', $structure->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                    data-bs-toggle="tooltip" title="Delete Structure"
                                                    onclick="return confirm('Are you sure you want to delete this fee structure? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-money-bill-wave fa-4x text-muted mb-3"></i>
                                        <h4 class="text-muted">No Fee Structures Found</h4>
                                        <p class="text-muted mb-4">
                                            @if(request()->anyFilled(['search', 'academic_year', 'status']))
                                                No structures match your current filters.
                                            @else
                                                Get started by creating your first fee structure.
                                            @endif
                                        </p>
                                        <a href="{{ route('fee-structures.create') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-plus-circle me-2"></i>Create First Structure
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($feeStructures->hasPages())
                <div class="card-footer bg-light py-2 py-md-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="text-muted small mb-2 mb-md-0">
                            Page {{ $feeStructures->currentPage() }} of {{ $feeStructures->lastPage() }}
                        </div>
                        <nav>
                            {{ $feeStructures->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
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
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        padding: 2rem 1rem;
    }

    .alert {
        border-radius: 12px;
        border: none;
    }

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
        border-left: none;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid #e9ecef;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }

    /* Custom scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
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
    .fee-structure-row, .fee-structure-card {
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
            font-size: 1.25rem;
        }
        
        .btn-md-lg {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .input-group-md {
            height: auto;
        }
        
        .form-select-md, .form-control {
            font-size: 0.875rem;
            padding: 0.5rem;
        }
        
        .fee-structure-card {
            margin-bottom: 10px;
            border-radius: 8px;
        }
        
        .table-responsive {
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
            width: 32px;
            height: 32px;
        }
        
        .badge {
            font-size: 0.75rem;
        }
    }
    
    /* Small mobile devices */
    @media (max-width: 375px) {
        .container-fluid {
            padding-left: 5px;
            padding-right: 5px;
        }
        
        .row.g-2 {
            margin-left: -5px;
            margin-right: -5px;
        }
        
        .row.g-2 > [class*="col-"] {
            padding-left: 5px;
            padding-right: 5px;
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

        // Auto-submit form when filters change (except search)
        document.querySelectorAll('select[name="academic_year"], select[name="status"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
        
        // Adjust table responsiveness on window resize
        function adjustTableLayout() {
            const tableContainer = document.querySelector('.table-responsive');
            if (tableContainer && window.innerWidth < 768) {
                tableContainer.style.overflowX = 'auto';
            }
        }
        
        window.addEventListener('resize', adjustTableLayout);
        adjustTableLayout();
    });
</script>
@endsection