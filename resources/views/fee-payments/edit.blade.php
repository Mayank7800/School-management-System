@extends('layouts.app')

@section('title', 'Edit Payment')
@section('page_title', 'Edit Fee Payment')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Payment Record</h5>
                </div>
                <div class="card-body">
                    {{-- Student Info --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-person-circle"></i> Student Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
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
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td><strong>Section:</strong></td>
                                            <td>{{ $payment->student->section ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Father:</strong></td>
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
                    </div>

                    {{-- Current Fee Status --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-wallet2"></i> Current Fee Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-1">Total Fees</h6>
                                    <h4 class="text-primary">₹{{ number_format($payment->studentFee->total_amount, 2) }}</h4>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-1">Paid Amount</h6>
                                    <h4 class="text-success">₹{{ number_format($payment->studentFee->paid_amount, 2) }}</h4>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-1">Due Amount</h6>
                                    <h4 class="text-danger">₹{{ number_format($payment->studentFee->balance_amount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Form --}}
                    <form action="{{ route('fee-payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bi bi-credit-card"></i> Payment Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                                            <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" 
                                                value="{{ old('payment_date', \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')) }}" required max="{{ date('Y-m-d') }}">
                                            @error('payment_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Amount Paid (₹) <span class="text-danger">*</span></label>
                                            <input type="number" name="amount_paid" step="0.01" class="form-control @error('amount_paid') is-invalid @enderror" 
                                                value="{{ old('amount_paid', $payment->amount_paid) }}" min="1" required>
                                            @error('amount_paid')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">
                                                Current due amount: ₹{{ number_format($payment->studentFee->total_amount - ($payment->studentFee->paid_amount - $payment->amount_paid), 2) }}
                                            </small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                            <select name="payment_mode" class="form-select @error('payment_mode') is-invalid @enderror" required>
                                                <option value="">-- Select Method --</option>
                                                <option value="Cash" {{ old('payment_mode', $payment->payment_mode) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="Cheque" {{ old('payment_mode', $payment->payment_mode) == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                                <option value="Online Transfer" {{ old('payment_mode', $payment->payment_mode) == 'Online Transfer' ? 'selected' : '' }}>Online Transfer</option>
                                                <option value="UPI" {{ old('payment_mode', $payment->payment_mode) == 'UPI' ? 'selected' : '' }}>UPI</option>
                                                <option value="Card" {{ old('payment_mode', $payment->payment_mode) == 'Card' ? 'selected' : '' }}>Card</option>
                                            </select>
                                            @error('payment_mode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bi bi-info-circle"></i> Additional Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Transaction Reference</label>
                                            <input type="text" name="transaction_ref" class="form-control @error('transaction_ref') is-invalid @enderror" 
                                                value="{{ old('transaction_ref', $payment->transaction_ref) }}" placeholder="Cheque no, UTR, Transaction ID">
                                            @error('transaction_ref')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Bank Name</label>
                                            <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" 
                                                value="{{ old('bank_name', $payment->bank_name) }}" placeholder="Bank name (if applicable)">
                                            @error('bank_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Cheque No.</label>
                                            <input type="text" name="cheque_no" class="form-control @error('cheque_no') is-invalid @enderror" 
                                                value="{{ old('cheque_no', $payment->cheque_no) }}" placeholder="Cheque number">
                                            @error('cheque_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Received By <span class="text-danger">*</span></label>
                                            <input type="text" name="received_by" class="form-control @error('received_by') is-invalid @enderror" 
                                                value="{{ old('received_by', $payment->received_by) }}" placeholder="Staff name" required>
                                            @error('received_by')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bi bi-file-earmark"></i> Receipt File</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Current Receipt</label>
                                            @if($payment->receipt_file)
                                                <div class="mb-2">
                                                    <a href="{{ Storage::url($payment->receipt_file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-eye"></i> View Current Receipt
                                                    </a>
                                                </div>
                                            @else
                                                <p class="text-muted">No receipt uploaded</p>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Update Receipt (optional)</label>
                                            <input type="file" name="receipt_file" class="form-control @error('receipt_file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                            @error('receipt_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Max size: 5MB, Formats: PDF, JPG, JPEG, PNG</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bi bi-chat-left-text"></i> Remarks</h6>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="4" 
                                            placeholder="Any additional notes or remarks...">{{ old('remarks', $payment->remarks) }}</textarea>
                                        @error('remarks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('fee-payments.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to List
                                </a>
                                <a href="{{ route('fee-payments.show', $payment->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i> View Details
                                </a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check-circle"></i> Update Payment
                                </button>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Delete Form --}}
                    <form id="deleteForm" action="{{ route('fee-payments.destroy', $payment->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
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
        padding: 0.3rem 0;
    }
</style>

<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this payment record? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}

// Show/hide fields based on payment method
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethod = document.querySelector('select[name="payment_mode"]');
    const transactionRef = document.querySelector('input[name="transaction_ref"]');
    const bankName = document.querySelector('input[name="bank_name"]');
    const chequeNo = document.querySelector('input[name="cheque_no"]');

    function toggleFields() {
        if (paymentMethod.value === 'Cash') {
            transactionRef.required = false;
            bankName.required = false;
            chequeNo.required = false;
        } else if (paymentMethod.value === 'Cheque') {
            bankName.required = true;
            chequeNo.required = true;
            transactionRef.required = false;
        } else {
            transactionRef.required = true;
            bankName.required = false;
            chequeNo.required = false;
        }
    }

    paymentMethod.addEventListener('change', toggleFields);
    toggleFields(); // Initial call
});
</script>
@endsection