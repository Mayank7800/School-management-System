@extends('layouts.app')

@section('title', 'Student Fee Records')
@section('page_title', 'Student Fee Management')

@section('content')
<div class="container-fluid py-2 py-md-4">
    <!-- ✅ Header Section - Mobile Optimized -->
    <div class="card shadow-lg border-0 mb-3 mb-md-4">
        <div class="card-header bg-gradient-success text-white py-3 py-md-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <i class="fas fa-money-check-alt fa-lg fa-2x-md me-2 me-md-3"></i>
                    <div>
                        <h4 class="mb-1 fw-bold d-md-none">Fee Management</h4>
                        <h2 class="mb-1 fw-bold d-none d-md-block">Student Fee Management</h2>
                        <p class="mb-0 opacity-80 small d-none d-md-block">Manage student fee allocations and payment records</p>
                        <p class="mb-0 opacity-80 small d-md-none">Manage fee allocations</p>
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2 w-100 w-md-auto">
                    <span class="badge bg-white text-success fs-6 me-0 me-md-3 mb-2 mb-md-0 text-center">
                        <i class="fas fa-receipt me-1"></i>
                        {{ $studentFees->total() }} Records
                    </span>
                    <a href="{{ route('student-fees.create') }}" class="btn btn-light btn-sm btn-md-lg w-100 w-md-auto">
                        <i class="fas fa-plus-circle me-1 me-md-2"></i>
                        <span class="d-none d-md-inline">Assign New Fee</span>
                        <span class="d-md-none">Assign Fee</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Search & Filters - Mobile Collapsible -->
    <div class="card shadow-sm border-0 mb-3 mb-md-4">
        <div class="card-header bg-white py-2 py-md-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-filter me-2 text-success"></i>
                    Search & Filter
                </h5>
                <button class="btn btn-sm btn-outline-success d-md-none" 
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
                <form method="GET" action="{{ route('student-fees.index') }}">
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6 col-xl-4">
                            <label class="form-label fw-semibold small">Search</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       class="form-control border-start-0" 
                                       placeholder="Search student, fee type...">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <label class="form-label fw-semibold small">Payment Status</label>
                            <select name="payment_status" class="form-select form-select-sm">
                                <option value="">All Status</option>
                                <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Partial" {{ request('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                                <option value="Unpaid" {{ request('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <label class="form-label fw-semibold small">Class</label>
                            <select name="class_id" class="form-select form-select-sm">
                                <option value="">All Classes</option>
                                @foreach($classes ?? [] as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-xl-2">
                            <label class="form-label fw-semibold small d-md-none d-xl-block">&nbsp;</label>
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-success btn-sm flex-grow-1">
                                    <i class="fas fa-search me-1 d-none d-md-inline"></i>
                                    <span class="d-none d-md-inline">Search</span>
                                    <span class="d-md-none">Apply</span>
                                </button>
                                <a href="{{ route('student-fees.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                @if(request()->has('search') && !empty(request('search')))
                    <div class="alert alert-info mt-2 mt-md-3 d-flex align-items-center py-2">
                        <i class="fas fa-info-circle me-2"></i>
                        <div class="flex-grow-1 small">
                            Results for: "<strong>{{ request('search') }}</strong>"
                        </div>
                        <a href="{{ route('student-fees.index') }}" class="text-decoration-none small">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ✅ Quick Stats - Mobile Grid -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card stats-card bg-primary text-white shadow border-0 h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1 small">Total Fees</h6>
                            <h4 class="fw-bold mb-0">₹{{ number_format($studentFees->sum('total_amount'), 2) }}</h4>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-money-bill-wave fa-lg opacity-50"></i>
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
                            <h6 class="card-title text-white-50 mb-1 small">Total Paid</h6>
                            <h4 class="fw-bold mb-0">₹{{ number_format($studentFees->sum('paid_amount'), 2) }}</h4>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-check-circle fa-lg opacity-50"></i>
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
                            <h6 class="card-title text-white-50 mb-1 small">Total Balance</h6>
                            <h4 class="fw-bold mb-0">₹{{ number_format($studentFees->sum('total_amount') - $studentFees->sum('paid_amount'), 2) }}</h4>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-clock fa-lg opacity-50"></i>
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
                            <h6 class="card-title text-white-50 mb-1 small">Paid Records</h6>
                            <h4 class="fw-bold mb-0">{{ $studentFees->where('payment_status', 'Paid')->count() }}</h4>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-user-check fa-lg opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Fee Records Table -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white py-2 py-md-3 border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-list me-2 text-success"></i>
                    <span class="d-none d-md-inline">Student Fee Records</span>
                    <span class="d-md-none">Fee Records</span>
                </h5>
                <div class="text-muted small">
                    Showing {{ $studentFees->firstItem() }} to {{ $studentFees->lastItem() }} of {{ $studentFees->total() }}
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
                                <th class="ps-4" width="5%">#</th>
                                <th width="20%">
                                    <i class="fas fa-user-graduate me-1 text-muted"></i>Student
                                </th>
                                <th width="15%">
                                    <i class="fas fa-tag me-1 text-muted"></i>Fee Type
                                </th>
                                <th width="12%">
                                    <i class="fas fa-money-bill me-1 text-muted"></i>Total
                                </th>
                                <th width="12%">
                                    <i class="fas fa-check-circle me-1 text-muted"></i>Paid
                                </th>
                                <th width="12%">
                                    <i class="fas fa-clock me-1 text-muted"></i>Balance
                                </th>
                                <th width="10%">
                                    <i class="fas fa-circle me-1 text-muted"></i>Status
                                </th>
                                <th width="14%">
                                    <i class="fas fa-calendar me-1 text-muted"></i>Updated
                                </th>
                                <th width="10%" class="text-center">
                                    <i class="fas fa-cogs me-1 text-muted"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($studentFees as $key => $record)
                                <tr class="fee-record-row">
                                    <td class="ps-4 fw-semibold text-muted">{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="student-avatar me-3">
                                                <div class="avatar-placeholder bg-light-success rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user text-success"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">
                                                    {{ ucwords($record->student->first_name ?? '—') }} 
                                                    {{ ucwords($record->student->last_name ?? '') }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $record->student->admission_no ?? 'No ID' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark fs-7">
                                            <i class="fas fa-receipt me-1"></i>
                                            {{ ucwords($record->feeStructure->fee_type ?? '—') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark fs-6">
                                            ₹{{ number_format($record->total_amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success fs-6">
                                            ₹{{ number_format($record->paid_amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $balance = $record->total_amount - $record->paid_amount;
                                        @endphp
                                        <span class="fw-bold {{ $balance > 0 ? 'text-danger' : 'text-success' }} fs-6">
                                            ₹{{ number_format($balance, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($record->payment_status == 'Paid')
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i>Paid
                                            </span>
                                        @elseif($record->payment_status == 'Partial')
                                            <span class="badge bg-warning rounded-pill px-3 py-2">
                                                <i class="fas fa-clock me-1"></i>Partial
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                                <i class="fas fa-times-circle me-1"></i>Unpaid
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-start">
                                            <div class="fw-semibold text-dark small">
                                                {{ $record->updated_at->format('d M Y') }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $record->updated_at->format('h:i A') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('student-fees.edit', $record->id) }}" 
                                               class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                               data-bs-toggle="tooltip" title="Edit Record">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('student-fees.destroy', $record->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                        data-bs-toggle="tooltip" title="Delete Record"
                                                        onclick="return confirm('Are you sure you want to delete this fee record? This action cannot be undone.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-money-bill-wave fa-4x text-muted mb-3"></i>
                                            <h4 class="text-muted">No Fee Records Found</h4>
                                            <p class="text-muted mb-4">
                                                @if(request()->anyFilled(['search', 'payment_status', 'class_id']))
                                                    No records match your current filters.
                                                @else
                                                    Get started by assigning fees to students.
                                                @endif
                                            </p>
                                            <a href="{{ route('student-fees.create') }}" class="btn btn-success btn-lg">
                                                <i class="fas fa-plus-circle me-2"></i>Assign First Fee
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
                <div class="fee-mobile-list">
                    @forelse ($studentFees as $key => $record)
                        @php
                            $balance = $record->total_amount - $record->paid_amount;
                        @endphp
                        <div class="fee-mobile-card">
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">
                                    <!-- Header Section -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="student-avatar-mobile me-3">
                                                <div class="avatar-placeholder bg-light-success rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user text-success"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold text-dark">
                                                    {{ ucwords($record->student->first_name ?? '—') }} 
                                                    {{ ucwords($record->student->last_name ?? '') }}
                                                </h6>
                                                <div class="d-flex flex-wrap gap-1 mb-2">
                                                    <span class="badge bg-light text-dark fs-8">
                                                        <i class="fas fa-receipt me-1"></i>
                                                        {{ ucwords($record->feeStructure->fee_type ?? '—') }}
                                                    </span>
                                                    <span class="badge bg-secondary fs-8">
                                                        {{ $record->student->admission_no ?? 'No ID' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-2">
                                            @if($record->payment_status == 'Paid')
                                                <span class="badge bg-success rounded-pill px-2 py-1">
                                                    <i class="fas fa-check-circle me-1"></i>Paid
                                                </span>
                                            @elseif($record->payment_status == 'Partial')
                                                <span class="badge bg-warning rounded-pill px-2 py-1">
                                                    <i class="fas fa-clock me-1"></i>Partial
                                                </span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-2 py-1">
                                                    <i class="fas fa-times-circle me-1"></i>Unpaid
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Amount Information -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-4">
                                            <div class="bg-light rounded p-2 text-center">
                                                <small class="text-muted d-block">Total</small>
                                                <div class="fw-bold text-dark small">
                                                    ₹{{ number_format($record->total_amount, 0) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bg-light rounded p-2 text-center">
                                                <small class="text-muted d-block">Paid</small>
                                                <div class="fw-bold text-success small">
                                                    ₹{{ number_format($record->paid_amount, 0) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bg-light rounded p-2 text-center">
                                                <small class="text-muted d-block">Balance</small>
                                                <div class="fw-bold {{ $balance > 0 ? 'text-danger' : 'text-success' }} small">
                                                    ₹{{ number_format($balance, 0) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Last Updated -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            Updated: {{ $record->updated_at->format('d M, h:i A') }}
                                        </small>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-1 flex-grow-1">
                                            <a href="{{ route('student-fees.edit', $record->id) }}" 
                                               class="btn btn-sm btn-outline-warning flex-fill d-flex align-items-center justify-content-center py-2">
                                                <i class="fas fa-edit me-1"></i>
                                                <span class="d-none d-sm-inline">Edit</span>
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
                                                    <form action="{{ route('student-fees.destroy', $record->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="dropdown-item text-danger"
                                                                onclick="return confirm('Are you sure you want to delete this fee record?')">
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
                                <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Fee Records Found</h5>
                                <p class="text-muted mb-4 small">
                                    @if(request()->anyFilled(['search', 'payment_status', 'class_id']))
                                        No records match your current filters.
                                    @else
                                        Get started by assigning fees to students.
                                    @endif
                                </p>
                                <a href="{{ route('student-fees.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus-circle me-2"></i>Assign First Fee
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($studentFees->hasPages())
                <div class="card-footer bg-light py-2 py-md-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small">
                            Page {{ $studentFees->currentPage() }} of {{ $studentFees->lastPage() }}
                        </div>
                        <nav>
                            {{ $studentFees->onEachSide(1)->links('pagination::bootstrap-5') }}
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

    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
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
        background-color: rgba(40, 167, 69, 0.05);
        transition: all 0.2s ease;
    }

    .student-avatar .avatar-placeholder {
        width: 40px;
        height: 40px;
        background: rgba(40, 167, 69, 0.1);
    }

    /* Mobile Card Styles */
    .fee-mobile-card .card {
        border-radius: 10px;
        margin-bottom: 0.75rem;
    }

    .student-avatar-mobile .avatar-placeholder {
        width: 35px;
        height: 35px;
        background: rgba(40, 167, 69, 0.1);
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
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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

    .alert {
        border-radius: 8px;
        border: none;
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
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
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
    .fee-record-row, .fee-mobile-card {
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

        // Auto-submit form when filters change (except search)
        document.querySelectorAll('select[name="payment_status"], select[name="class_id"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });

        // Auto-expand filter on mobile when filters are applied
        const urlParams = new URLSearchParams(window.location.search);
        if (window.innerWidth < 768 && (urlParams.has('search') || urlParams.has('payment_status') || urlParams.has('class_id'))) {
            const filterCollapse = document.getElementById('filterCollapse');
            if (filterCollapse) {
                new bootstrap.Collapse(filterCollapse, { show: true });
            }
        }
    });

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