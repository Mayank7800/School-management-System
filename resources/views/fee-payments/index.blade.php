@extends('layouts.app')

@section('title', 'Fee Payments')
@section('page_title', 'Fee Payments Management')

@section('content')
<div class="container-fluid py-2 py-md-3">
    <div class="card shadow-sm border-0">
        <!-- Header Section - Mobile Optimized -->
        <div class="card-header bg-primary text-white py-3 py-md-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-credit-card me-2 me-md-3 fs-4 fs-md-3"></i>
                    <div>
                        <h4 class="mb-0 d-md-none">Fee Payments</h4>
                        <h5 class="mb-0 d-none d-md-block">Fee Payments History</h5>
                        <p class="mb-0 opacity-80 small d-none d-md-block">Manage and track all fee payments</p>
                    </div>
                </div>
                <a href="{{ route('fee-payments.create') }}" class="btn btn-light btn-sm btn-md-lg w-100 w-md-auto">
                    <i class="bi bi-plus-circle me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Record New Payment</span>
                    <span class="d-md-none">New Payment</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Filters - Mobile Collapsible --}}
            <div class="card border-0 bg-light mb-4">
                <div class="card-header bg-transparent py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-funnel me-2"></i>Filters
                        </h6>
                        <button class="btn btn-sm btn-outline-primary d-md-none" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#filterCollapse"
                                aria-expanded="false" 
                                aria-controls="filterCollapse">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse d-md-block" id="filterCollapse">
                    <div class="card-body py-2 py-md-3">
                        <div class="row g-2 g-md-3">
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small fw-semibold">Date From</label>
                                <input type="date" class="form-control form-control-sm" id="dateFrom" value="{{ date('Y-m-01') }}">
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small fw-semibold">Date To</label>
                                <input type="date" class="form-control form-control-sm" id="dateTo" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small fw-semibold">Payment Method</label>
                                <select class="form-select form-select-sm" id="paymentMethod">
                                    <option value="">All Methods</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Online Transfer">Online Transfer</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Card">Card</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small fw-semibold">Status</label>
                                <select class="form-select form-select-sm" id="paymentStatus">
                                    <option value="">All Status</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Failed">Failed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary Cards - Mobile Grid --}}
            <div class="row g-2 g-md-3 mb-4">
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body p-2 p-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title small mb-1 opacity-80">Total Payments</h6>
                                    <h4 class="mb-0 fw-bold" id="totalPayments">0</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-wallet2 fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body p-2 p-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title small mb-1 opacity-80">Total Amount</h6>
                                    <h4 class="mb-0 fw-bold" id="totalAmount">₹0.00</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-currency-rupee fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body p-2 p-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title small mb-1 opacity-80">This Month</h6>
                                    <h4 class="mb-0 fw-bold" id="monthAmount">₹0.00</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-calendar-month fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="card bg-warning text-dark h-100">
                        <div class="card-body p-2 p-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title small mb-1 opacity-80">Pending</h6>
                                    <h4 class="mb-0 fw-bold" id="pendingPayments">0</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-clock-history fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payments Table --}}
            <div class="card border-0">
                <div class="card-header bg-transparent py-2 py-md-3 border-bottom">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-list-ul me-2"></i>
                        <span class="d-none d-md-inline">Payment Records</span>
                        <span class="d-md-none">Payments</span>
                    </h6>
                </div>
                
                <!-- Desktop Table View -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0" id="paymentsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Admission No</th>
                                    <th>Class</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Received By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feePayments as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $payment->student->first_name }} {{ $payment->student->last_name }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $payment->student->admission_no }}</td>
                                    <td>{{ $payment->student->course_name ?? 'N/A' }}</td>
                                    <td class="fw-bold text-success">₹{{ number_format($payment->amount_paid, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $payment->payment_mode }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $payment->status == 'Completed' ? 'bg-success' : ($payment->status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $payment->status }}
                                        </span>
                                    </td>
                                    <td>{{ ucwords($payment->received_by ?? 'N/A') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('fee-payments.show', $payment->id) }}" class="btn btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('fee-payments.edit', $payment->id) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-info" onclick="generateReceipt({{ $payment->id }})" title="Receipt">
                                                <i class="bi bi-receipt"></i>
                                            </button>
                                            <form action="{{ route('fee-payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this payment?')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="bi bi-credit-card-2-front fs-1"></i>
                                        <h5 class="mt-2">No Payments Found</h5>
                                        <p class="mb-3">No fee payments have been recorded yet.</p>
                                        <a href="{{ route('fee-payments.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Record First Payment
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="d-md-none">
                    <div class="payments-mobile-list">
                        @forelse($feePayments as $payment)
                            <div class="payment-mobile-card mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <!-- Header Section -->
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-center flex-grow-1">
                                                <div class="avatar-sm-mobile bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold text-dark">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</h6>
                                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                                        <span class="badge bg-secondary fs-8">{{ $payment->student->admission_no }}</span>
                                                        <span class="badge bg-light text-dark fs-8">{{ $payment->student->course_name ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ms-2">
                                                <span class="badge {{ $payment->status == 'Completed' ? 'bg-success' : ($payment->status == 'Pending' ? 'bg-warning' : 'bg-danger') }} fs-8">
                                                    {{ $payment->status }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Payment Details -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <div class="bg-light rounded p-2 text-center">
                                                    <small class="text-muted d-block">Amount</small>
                                                    <div class="fw-bold text-success fs-6">
                                                        ₹{{ number_format($payment->amount_paid, 0) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-light rounded p-2 text-center">
                                                    <small class="text-muted d-block">Method</small>
                                                    <div class="fw-semibold text-dark small">
                                                        {{ $payment->payment_mode }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Info -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <small class="text-muted">Date</small>
                                                <div class="fw-semibold text-dark small">
                                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted">Received By</small>
                                                <div class="fw-semibold text-dark small">
                                                    {{ ucwords($payment->received_by ?? 'N/A') }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex gap-1 flex-grow-1">
                                                <a href="{{ route('fee-payments.show', $payment->id) }}" 
                                                   class="btn btn-sm btn-outline-primary flex-fill d-flex align-items-center justify-content-center py-2">
                                                    <i class="bi bi-eye me-1 d-none d-sm-inline"></i>
                                                    <span>View</span>
                                                </a>
                                                <a href="{{ route('fee-payments.edit', $payment->id) }}" 
                                                   class="btn btn-sm btn-outline-warning flex-fill d-flex align-items-center justify-content-center py-2">
                                                    <i class="bi bi-pencil me-1 d-none d-sm-inline"></i>
                                                    <span>Edit</span>
                                                </a>
                                            </div>
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" onclick="generateReceipt({{ $payment->id }})">
                                                            <i class="bi bi-receipt me-2"></i>Receipt
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('fee-payments.destroy', $payment->id) }}" method="POST" class="d-inline w-100">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="dropdown-item text-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this payment?')">
                                                                <i class="bi bi-trash me-2"></i>Delete
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
                                <i class="bi bi-credit-card-2-front fs-1 text-muted"></i>
                                <h5 class="mt-2 text-muted">No Payments Found</h5>
                                <p class="text-muted mb-4 small">No fee payments have been recorded yet.</p>
                                <a href="{{ route('fee-payments.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Record First Payment
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Pagination --}}
                @if($feePayments->hasPages())
                    <div class="card-footer bg-light py-2 py-md-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                            <div class="text-muted small">
                                Showing {{ $feePayments->firstItem() }} to {{ $feePayments->lastItem() }} of {{ $feePayments->total() }} entries
                            </div>
                            <nav>
                                {{ $feePayments->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    </div>
                @endif
            </div>
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

    /* Mobile Card Styles */
    .payment-mobile-card .card {
        border-radius: 10px;
        margin-bottom: 0.75rem;
    }

    .avatar-sm-mobile {
        font-size: 1rem;
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

    /* Table Styles */
    .table th {
        border-top: none;
        font-weight: 600;
        padding: 0.75rem;
    }

    .table td {
        padding: 0.75rem;
        vertical-align: middle;
    }

    .btn-group .btn {
        border-radius: 6px;
        margin: 0 1px;
    }

    /* Form Styles */
    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    /* Mobile Optimizations */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        h4, h5, h6 {
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

    /* Animation for cards */
    .payment-mobile-card {
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
    // Filter functionality
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const paymentMethod = document.getElementById('paymentMethod');
    const paymentStatus = document.getElementById('paymentStatus');

    [dateFrom, dateTo, paymentMethod, paymentStatus].forEach(element => {
        element.addEventListener('change', filterPayments);
    });

    function filterPayments() {
        const filters = {
            date_from: dateFrom.value,
            date_to: dateTo.value,
            payment_mode: paymentMethod.value,
            status: paymentStatus.value
        };

        // You can implement AJAX filtering here
        console.log('Filters:', filters);
        // For now, we'll just reload the page with filters
        const url = new URL(window.location.href);
        Object.keys(filters).forEach(key => {
            if (filters[key]) {
                url.searchParams.set(key, filters[key]);
            } else {
                url.searchParams.delete(key);
            }
        });
        window.location.href = url.toString();
    }

    // Generate receipt
    window.generateReceipt = function(paymentId) {
        window.open(`/sms/fee-payments/${paymentId}/receipt`, '_blank');
    };

    // Calculate summary
    function calculateSummary() {
        document.getElementById('totalPayments').textContent = '{{ $feePayments->count() }}';
        document.getElementById('totalAmount').textContent = '₹{{ number_format($feePayments->sum('amount_paid'), 2) }}';
        
        const thisMonthTotal = {{ $feePayments->where('payment_date', '>=', now()->startOfMonth())->sum('amount_paid') }};
        document.getElementById('monthAmount').textContent = '₹' + thisMonthTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
        
        const pendingCount = {{ $feePayments->where('status', 'Pending')->count() }};
        document.getElementById('pendingPayments').textContent = pendingCount;
    }

    calculateSummary();

    // Auto-expand filter on mobile when filters are applied
    const urlParams = new URLSearchParams(window.location.search);
    if (window.innerWidth < 768 && (urlParams.has('date_from') || urlParams.has('date_to') || urlParams.has('payment_mode') || urlParams.has('status'))) {
        const filterCollapse = document.getElementById('filterCollapse');
        if (filterCollapse) {
            new bootstrap.Collapse(filterCollapse, { show: true });
        }
    }
});
</script>
@endsection