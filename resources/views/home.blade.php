@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="container-fluid py-2 py-md-3">
    <!-- ✅ Welcome Header - Mobile Optimized -->
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <div class="card shadow-lg border-0 bg-gradient-primary text-white">
                <div class="card-body py-3 py-md-4">
                    <div class="row align-items-center">
                        <div class="col-8 col-md-8">
                            <h4 class="fw-bold mb-1 mb-md-2">Welcome to School Management</h4>
                            <p class="mb-0 opacity-80 small d-none d-md-block">Here's what's happening today</p>
                        </div>
                        <div class="col-4 col-md-4 text-end">
                            <div class="current-time">
                                <h5 class="mb-0 mb-md-1 fw-bold" id="currentTime">{{ now()->format('h:i A') }}</h5>
                                <p class="mb-0 opacity-80 small d-none d-md-block">{{ now()->format('l, F j, Y') }}</p>
                                <p class="mb-0 opacity-80 small d-md-none">{{ now()->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Statistics Cards - Mobile Grid -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card stats-card bg-primary text-white shadow border-0 h-100">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1 small">Total Students</h6>
                            <h4 class="fw-bold mb-0">{{ \App\Models\StudentAdmission::count() }}</h4>
                            <small class="text-white-50 d-none d-md-block">Registered students</small>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-user-graduate fa-lg opacity-50"></i>
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
                            <h6 class="card-title text-white-50 mb-1 small">Fees Collected</h6>
                            <h4 class="fw-bold mb-0">₹{{ number_format(\App\Models\FeePayment::sum('amount_paid'), 2) }}</h4>
                            <small class="text-white-50 d-none d-md-block">Total revenue</small>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-money-bill-wave fa-lg opacity-50"></i>
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
                            <h6 class="card-title text-white-50 mb-1 small">Pending Fees</h6>
                            <h4 class="fw-bold mb-0">₹{{ number_format(\App\Models\StudentFee::sum('balance_amount'), 2) }}</h4>
                            <small class="text-white-50 d-none d-md-block">Outstanding amount</small>
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
                            <h6 class="card-title text-white-50 mb-1 small">Active Structures</h6>
                            <h4 class="fw-bold mb-0">{{ \App\Models\FeeStructure::where('status', 'Active')->count() }}</h4>
                            <small class="text-white-50 d-none d-md-block">Fee structures</small>
                        </div>
                        <div class="stats-icon ms-2">
                            <i class="fas fa-layer-group fa-lg opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Quick Actions & Recent Payments - Mobile Stack -->
    <div class="row g-3">
        <!-- Quick Actions - Full width on mobile -->
        <div class="col-12 col-lg-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-white py-2 py-md-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body p-2 p-md-3">
                    <div class="row g-2">
                        <div class="col-6 col-md-12">
                            <a href="{{ route('admissions.create') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-start p-2 p-md-3 mb-2">
                                <i class="fas fa-user-plus me-2 me-md-3"></i>
                                <div class="text-start flex-grow-1">
                                    <div class="fw-semibold small">Add Student</div>
                                    <small class="opacity-80 d-none d-md-block">Register new student</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-12">
                            <a href="{{ route('fee-payments.create') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-start p-2 p-md-3 mb-2">
                                <i class="fas fa-money-bill-wave me-2 me-md-3"></i>
                                <div class="text-start flex-grow-1">
                                    <div class="fw-semibold small">Collect Fees</div>
                                    <small class="opacity-80 d-none d-md-block">Record fee payment</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-12">
                            <a href="{{ route('attendance.create') }}" class="btn btn-warning w-100 d-flex align-items-center justify-content-start p-2 p-md-3 mb-2">
                                <i class="fas fa-calendar-check me-2 me-md-3"></i>
                                <div class="text-start flex-grow-1">
                                    <div class="fw-semibold small">Attendance</div>
                                    <small class="opacity-80 d-none d-md-block">Take today's attendance</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-12">
                            <a href="{{ route('staff.create') }}" class="btn btn-info w-100 d-flex align-items-center justify-content-start p-2 p-md-3">
                                <i class="fas fa-users me-2 me-md-3"></i>
                                <div class="text-start flex-grow-1">
                                    <div class="fw-semibold small">Add Staff</div>
                                    <small class="opacity-80 d-none d-md-block">Register new staff</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payments - Full width on mobile -->
        <div class="col-12 col-lg-8">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-white py-2 py-md-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-history me-2 text-primary"></i>
                            Recent Payments
                        </h5>
                        <a href="{{ route('fee-payments.index') }}" class="btn btn-sm btn-outline-primary d-none d-md-inline-flex">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                        <a href="{{ route('fee-payments.index') }}" class="btn btn-sm btn-outline-primary d-md-none">
                            <i class="fas fa-list"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light d-none d-md-table-header-group">
                                <tr>
                                    <th class="ps-4" width="15%">
                                        <i class="fas fa-calendar me-1 text-muted"></i>Date
                                    </th>
                                    <th width="25%">
                                        <i class="fas fa-user me-1 text-muted"></i>Student
                                    </th>
                                    <th width="20%">
                                        <i class="fas fa-money-bill me-1 text-muted"></i>Amount
                                    </th>
                                    <th width="20%">
                                        <i class="fas fa-credit-card me-1 text-muted"></i>Payment Mode
                                    </th>
                                    <th width="20%">
                                        <i class="fas fa-user-check me-1 text-muted"></i>Received By
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\FeePayment::with('student')->latest()->take(6)->get() as $payment)
                                <tr class="payment-row">
                                    <!-- Desktop View -->
                                    <td class="ps-4 d-none d-md-table-cell">
                                        <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($payment->payment_date)->format('h:i A') }}</small>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="d-flex align-items-center">
                                            <div class="student-avatar me-3">
                                                <div class="avatar-placeholder bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">
                                                    {{ $payment->student->first_name ?? 'N/A' }} 
                                                    {{ $payment->student->last_name ?? '' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $payment->student->admission_no ?? 'No ID' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="fw-bold text-success">
                                            ₹{{ number_format($payment->amount_paid, 2) }}
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-{{ getPaymentModeIcon($payment->payment_mode) }} me-1"></i>
                                            {{ $payment->payment_mode ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-tie me-2 text-muted"></i>
                                            {{ ucwords($payment->received_by ?? 'System') }}
                                        </div>
                                    </td>
                                    
                                    <!-- Mobile View -->
                                    <td class="d-md-none p-3">
                                        <div class="mobile-payment-card">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="student-avatar me-2">
                                                        <div class="avatar-placeholder bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-user text-primary small"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-dark small">
                                                            {{ $payment->student->first_name ?? 'N/A' }} 
                                                            {{ $payment->student->last_name ?? '' }}
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ $payment->student->admission_no ?? 'No ID' }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <span class="fw-bold text-success">
                                                    ₹{{ number_format($payment->amount_paid, 2) }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="badge bg-light text-dark small">
                                                        <i class="fas fa-{{ getPaymentModeIcon($payment->payment_mode) }} me-1"></i>
                                                        {{ $payment->payment_mode ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                <div class="text-muted small">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    {{ ucwords($payment->received_by ?? 'System') }}
                                                </div>
                                            </div>
                                            <div class="mt-2 text-muted small">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-money-bill-slash fa-2x text-muted mb-3"></i>
                                            <h6 class="text-muted">No Recent Payments</h6>
                                            <p class="text-muted mb-0 small">No payments have been recorded yet.</p>
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
    </div>

    <!-- ✅ Additional Stats Row - Stack on mobile -->
    <div class="row g-3 mt-2">
        <div class="col-12 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-2 py-md-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Monthly Collection Trend
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="text-center py-3 py-md-4">
                        <i class="fas fa-chart-line fa-2x fa-3x-md text-muted mb-2 mb-md-3"></i>
                        <h6 class="text-muted small">Collection Analytics Coming Soon</h6>
                        <p class="text-muted mb-0 small">Monthly fee collection charts will be displayed here.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-2 py-md-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-bell me-2 text-primary"></i>
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="text-center py-3 py-md-4">
                        <i class="fas fa-list-alt fa-2x fa-3x-md text-muted mb-2 mb-md-3"></i>
                        <h6 class="text-muted small">Activity Feed Coming Soon</h6>
                        <p class="text-muted mb-0 small">Recent system activities will be shown here.</p>
                    </div>
                </div>
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

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

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

    /* Mobile First Table Styles */
    .table th {
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        background-color: #f8f9fa;
        padding: 0.75rem;
    }

    .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transition: all 0.2s ease;
    }

    .student-avatar .avatar-placeholder {
        width: 35px;
        height: 35px;
        background: rgba(102, 126, 234, 0.1);
    }

    .btn {
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .badge {
        font-weight: 500;
        padding: 0.4rem 0.6rem;
    }

    .empty-state {
        padding: 1.5rem 1rem;
    }

    .bg-light-primary {
        background-color: rgba(102, 126, 234, 0.1) !important;
    }

    /* Mobile Payment Card */
    .mobile-payment-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem;
    }

    /* Responsive Typography */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
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
            padding: 0.5rem 0.75rem;
        }
        
        .stats-card .card-body {
            padding: 0.75rem;
        }
    }

    /* Touch-friendly improvements */
    @media (max-width: 576px) {
        .btn {
            min-height: 44px; /* Minimum touch target size */
        }
        
        .table-responsive {
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .mobile-payment-card {
            margin: 0.25rem 0;
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

    /* Custom scrollbar for tables */
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
    .payment-row {
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

    /* Quick action buttons mobile optimization */
    @media (max-width: 768px) {
        .btn-lg {
            padding: 0.75rem 1rem;
            text-align: left;
        }
        
        .stats-card h4 {
            font-size: 1.1rem;
        }
        
        .stats-card h6 {
            font-size: 0.75rem;
        }
    }

    /* Hide table headers on mobile */
    @media (max-width: 767.98px) {
        .d-md-table-header-group {
            display: none !important;
        }
        
        .d-md-table-cell {
            display: none !important;
        }
        
        .d-md-none {
            display: block !important;
        }
    }

    /* Show desktop elements on larger screens */
    @media (min-width: 768px) {
        .d-md-none {
            display: none !important;
        }
    }
</style>

<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: true 
        });
        const dateString = now.toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        const shortDateString = now.toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric' 
        });
        
        document.getElementById('currentTime').textContent = timeString;
    }

    // Update time immediately and then every minute
    updateTime();
    setInterval(updateTime, 60000);

    // Add hover effects to cards (only on non-touch devices)
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.stats-card');
        
        // Check if device supports hover
        if (window.matchMedia('(hover: hover)').matches) {
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        }
        
        // Improve touch experience
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
        }
    });
</script>

<?php
// Helper function to get payment mode icons
function getPaymentModeIcon($mode) {
    $icons = [
        'Cash' => 'money-bill',
        'Card' => 'credit-card',
        'UPI' => 'mobile-alt',
        'Bank Transfer' => 'university',
        'Cheque' => 'file-invoice-dollar'
    ];
    return $icons[$mode] ?? 'money-bill';
}
?>
@endsection