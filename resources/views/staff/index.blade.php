@extends('layouts.app')

@section('title', 'Staff List')

@section('content')
<div class="container-fluid py-2 py-md-4">
    <!-- ✅ Header Section - Mobile Optimized -->
    <div class="card shadow-lg border-0 mb-3 mb-md-4">
        <div class="card-header bg-gradient-primary text-white py-3 py-md-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <i class="fas fa-users fa-lg fa-2x-md me-2 me-md-3"></i>
                    <div>
                        <h4 class="mb-1 fw-bold d-md-none">Staff Management</h4>
                        <h2 class="mb-1 fw-bold d-none d-md-block">Staff Management</h2>
                        <p class="mb-0 opacity-80 small d-none d-md-block">Manage all staff members and their information</p>
                        <p class="mb-0 opacity-80 small d-md-none">Manage staff members</p>
                    </div>
                </div>
                <a href="{{ route('staff.create') }}" class="btn btn-light btn-sm btn-md-lg w-100 w-md-auto">
                    <i class="fas fa-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Add New Staff</span>
                    <span class="d-md-none">Add Staff</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ✅ Summary Cards - Mobile Grid -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card stats-card bg-primary text-white shadow border-0 h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1 small">Total Staff</h6>
                            <h4 class="fw-bold mb-0">{{ $totalStaff ?? 0 }}</h4>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-users fa-lg opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-xl-3">
            <div class="card stats-card bg-success text-white shadow border-0 h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1 small">Active Staff</h6>
                            <h4 class="fw-bold mb-0">{{ $activeStaff ?? 0 }}</h4>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-user-check fa-lg opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-xl-3">
            <div class="card stats-card bg-warning text-white shadow border-0 h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1 small">Inactive Staff</h6>
                            <h4 class="fw-bold mb-0">{{ $inactiveStaff ?? 0 }}</h4>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-user-slash fa-lg opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-xl-3">
            <div class="card stats-card bg-info text-white shadow border-0 h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1 small">Departments</h6>
                            <h4 class="fw-bold mb-0">{{ $departmentsCount ?? 0 }}</h4>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-building fa-lg opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Staff Table -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white py-2 py-md-3 border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-primary"></i>
                    <span class="d-none d-md-inline">All Staff Members</span>
                    <span class="d-md-none">Staff Members</span>
                </h5>
                <div class="d-flex gap-2 w-100 w-md-auto">
                    <div class="input-group input-group-sm flex-grow-1 flex-md-grow-0" style="min-width: 200px; max-width: 100%;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search staff..." id="searchInput">
                        <button class="btn btn-outline-secondary d-md-none" type="button" onclick="resetSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary d-none d-md-flex" onclick="resetSearch()">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Desktop Table View -->
            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="staffTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="5%">#</th>
                                <th width="10%">Photo</th>
                                <th width="15%">Name</th>
                                <th width="15%">Department</th>
                                <th width="15%">Designation</th>
                                <th width="12%">Mobile</th>
                                <th width="15%">Email</th>
                                <th width="8%">Status</th>
                                <th width="10%">Joined</th>
                                <th width="15%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($staff as $member)
                            <tr class="staff-row">
                                <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="staff-avatar">
                                        @if($member->photo)
                                            <img src="{{ asset('storage/app/public/' . $member->photo) }}" alt="Photo" class="rounded-circle">
                                        @else
                                            <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ ucwords($member->first_name) }} {{ ucwords($member->last_name) }}</div>
                                    <small class="text-muted">ID: {{ $member->id }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark fs-7">
                                        <i class="fas fa-building me-1"></i>
                                        {{ ucwords($member->department ?? 'Not assigned') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light-primary text-primary fs-7">
                                        {{ ucwords($member->designation ?? 'Not assigned') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-mobile-alt me-2 text-muted"></i>
                                        {{ $member->mobile }}
                                    </div>
                                </td>
                                <td>
                                    @if($member->email)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-envelope me-2 text-muted"></i>
                                            <span class="text-truncate" style="max-width: 150px;">{{ $member->email }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">Not provided</span>
                                    @endif
                                </td>
                                <td>
                                    @if($member->status == 'Active')
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
                                    <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($member->joining_date)->format('d M Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($member->joining_date)->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('staff.show', $member->id) }}" 
                                           class="btn btn-sm btn-outline-info d-flex align-items-center"
                                           data-bs-toggle="tooltip" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('staff.edit', $member->id) }}" 
                                           class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                           data-bs-toggle="tooltip" title="Edit Staff">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('staff.destroy', $member->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                    data-bs-toggle="tooltip" title="Delete Staff"
                                                    onclick="return confirm('Are you sure you want to delete {{ $member->first_name }}? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                                        <h4 class="text-muted">No Staff Members Found</h4>
                                        <p class="text-muted mb-4">Get started by adding your first staff member.</p>
                                        <a href="{{ route('staff.create') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-plus-circle me-2"></i>Add First Staff
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
                <div class="staff-mobile-list">
                    @forelse ($staff as $member)
                        <div class="staff-mobile-card">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">
                                    <!-- Header Section -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="staff-avatar-mobile me-3">
                                                @if($member->photo)
                                                    <img src="{{ asset('storage/app/public/' . $member->photo) }}" alt="Photo" class="rounded-circle">
                                                @else
                                                    <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold text-dark">{{ ucwords($member->first_name) }} {{ ucwords($member->last_name) }}</h6>
                                                <div class="d-flex flex-wrap gap-1 mb-2">
                                                    <span class="badge bg-light text-dark fs-8">
                                                        <i class="fas fa-building me-1"></i>
                                                        {{ ucwords($member->department ?? 'Not assigned') }}
                                                    </span>
                                                    <span class="badge bg-light-primary text-primary fs-8">
                                                        {{ ucwords($member->designation ?? 'Not assigned') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-2">
                                            @if($member->status == 'Active')
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

                                    <!-- Contact Information -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div class="bg-light rounded p-2">
                                                <small class="text-muted d-block">Mobile</small>
                                                <div class="fw-semibold text-dark small">
                                                    <i class="fas fa-mobile-alt me-1 text-muted"></i>
                                                    {{ $member->mobile }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-light rounded p-2">
                                                <small class="text-muted d-block">Email</small>
                                                <div class="fw-semibold text-dark small text-truncate">
                                                    @if($member->email)
                                                        <i class="fas fa-envelope me-1 text-muted"></i>
                                                        {{ $member->email }}
                                                    @else
                                                        <span class="text-muted fst-italic">Not provided</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Joining Date -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <small class="text-muted">Joined</small>
                                            <div class="fw-semibold text-dark small">
                                                {{ \Carbon\Carbon::parse($member->joining_date)->format('d M Y') }}
                                            </div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($member->joining_date)->diffForHumans() }}</small>
                                        </div>
                                        <small class="text-muted">ID: {{ $member->id }}</small>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-1 flex-grow-1">
                                            <a href="{{ route('staff.show', $member->id) }}" 
                                               class="btn btn-sm btn-outline-info flex-fill d-flex align-items-center justify-content-center py-2">
                                                <i class="fas fa-eye me-1 d-none d-sm-inline"></i>
                                                <span>View</span>
                                            </a>
                                            <a href="{{ route('staff.edit', $member->id) }}" 
                                               class="btn btn-sm btn-outline-warning flex-fill d-flex align-items-center justify-content-center py-2">
                                                <i class="fas fa-edit me-1 d-none d-sm-inline"></i>
                                                <span>Edit</span>
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
                                                    <form action="{{ route('staff.destroy', $member->id) }}" method="POST" class="d-inline w-100">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="dropdown-item text-danger"
                                                                onclick="return confirm('Are you sure you want to delete {{ $member->first_name }}?')">
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
                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Staff Members Found</h5>
                                <p class="text-muted mb-4 small">Get started by adding your first staff member.</p>
                                <a href="{{ route('staff.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Add First Staff
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($staff->hasPages())
                <div class="card-footer bg-light py-2 py-md-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small">
                            Showing {{ $staff->firstItem() }} to {{ $staff->lastItem() }} of {{ $staff->total() }} entries
                        </div>
                        <nav>
                            {{ $staff->onEachSide(1)->links('pagination::bootstrap-5') }}
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

    /* Stats Cards */
    .stats-card {
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12) !important;
    }

    .stats-icon {
        opacity: 0.8;
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

    .staff-avatar img,
    .staff-avatar .avatar-placeholder {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    .staff-avatar .avatar-placeholder {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Mobile Card Styles */
    .staff-mobile-card .card {
        border-radius: 10px;
        margin-bottom: 0.75rem;
    }

    .staff-avatar-mobile img,
    .staff-avatar-mobile .avatar-placeholder {
        width: 45px;
        height: 45px;
        object-fit: cover;
    }

    .staff-avatar-mobile .avatar-placeholder {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .badge {
        font-weight: 500;
    }

    .bg-light-primary {
        background-color: rgba(102, 126, 234, 0.1) !important;
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
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }

    .form-control {
        border-radius: 0 8px 8px 0;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
    .staff-row, .staff-mobile-card {
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
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
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
                const desktopRows = document.querySelectorAll('.staff-row');
                desktopRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
                
                // Search in mobile cards
                const mobileCards = document.querySelectorAll('.staff-mobile-card');
                mobileCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }
    });

    function resetSearch() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.value = '';
            
            // Show all desktop rows
            const desktopRows = document.querySelectorAll('.staff-row');
            desktopRows.forEach(row => row.style.display = '');
            
            // Show all mobile cards
            const mobileCards = document.querySelectorAll('.staff-mobile-card');
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