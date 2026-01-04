@extends('layouts.app')

@section('title', 'Payment Details')
@section('page_title', 'Payment Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-eye"></i> Payment Details</h5>
                    <div>
                        <a href="{{ route('fee-payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button onclick="generateReceipt({{ $payment->id }})" class="btn btn-success btn-sm">
                            <i class="bi bi-receipt"></i> Receipt
                        </button>
                        <a href="{{ route('fee-payments.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Payment Summary --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white text-center">
                                <div class="card-body py-3">
                                    <h6>Amount Paid</h6>
                                    <h3>₹{{ number_format($payment->amount_paid, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white text-center">
                                <div class="card-body py-3">
                                    <h6>Payment Date</h6>
                                    <h4>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-dark text-center">
                                <div class="card-body py-3">
                                    <h6>Payment ID</h6>
                                    <h4>#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{-- Student Information --}}
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-person-badge"></i> Student Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $payment->student->first_name }} {{ $payment->student->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Admission No:</strong></td>
                                            <td>{{ $payment->student->admission_no }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Class:</strong></td>
                                            <td>{{ $payment->student->course->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Section:</strong></td>
                                            <td>{{ $payment->student->section ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Father's Name:</strong></td>
                                            <td>{{ $payment->student->father_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mobile:</strong></td>
                                            <td>{{ $payment->student->mobile_no ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Payment Information --}}
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-credit-card"></i> Payment Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td><strong>Payment Method:</strong></td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $payment->payment_mode }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Transaction Ref:</strong></td>
                                            <td>{{ $payment->transaction_ref ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Bank Name:</strong></td>
                                            <td>{{ $payment->bank_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cheque No:</strong></td>
                                            <td>{{ $payment->cheque_no ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Received By:</strong></td>
                                            <td>{{ $payment->received_by ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At:</strong></td>
                                            <td>{{ $payment->created_at->format('d/m/Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated At:</strong></td>
                                            <td>{{ $payment->updated_at->format('d/m/Y h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Fee Structure Information --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-wallet2"></i> Fee Structure Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <h6 class="text-muted mb-1">Fee Type</h6>
                                    <h5>{{ $payment->studentFee->feeStructure->fee_type ?? 'N/A' }}</h5>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted mb-1">Total Amount</h6>
                                    <h5 class="text-primary">₹{{ number_format($payment->studentFee->total_amount, 2) }}</h5>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted mb-1">Paid Amount</h6>
                                    <h5 class="text-success">₹{{ number_format($payment->studentFee->paid_amount, 2) }}</h5>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted mb-1">Balance</h6>
                                    <h5 class="text-danger">₹{{ number_format($payment->studentFee->balance_amount, 2) }}</h5>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                @php
                                    $paymentStatus = $payment->studentFee->payment_status ?? 'Unknown';
                                    $statusClass = [
                                        'Paid' => 'bg-success',
                                        'Partial' => 'bg-warning',
                                        'Unpaid' => 'bg-danger'
                                    ][$paymentStatus] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }} fs-6">{{ $paymentStatus }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Receipt Section --}}
                    @if($payment->receipt_file)
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-file-earmark"></i> Receipt</h6>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ Storage::url($payment->receipt_file) }}" target="_blank" class="btn btn-primary">
                                <i class="bi bi-download"></i> Download Receipt
                            </a>
                            <button onclick="generateReceipt({{ $payment->id }})" class="btn btn-success">
                                <i class="bi bi-receipt"></i> Generate New Receipt
                            </button>
                        </div>
                    </div>
                    @endif

                    {{-- Remarks --}}
                    @if($payment->remarks)
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-chat-left-text"></i> Remarks</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $payment->remarks }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
    }
    .table-borderless td {
        padding: 0.4rem 0;
        border: none;
    }
    .badge {
        font-size: 0.9em;
    }
</style>

<script>
function generateReceipt(paymentId) {
    window.open(`/sms/fee-payments/${paymentId}/receipt`, '_blank');
}
</script>
@endsection