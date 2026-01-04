<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Payment Receipt - {{ $payment->student->admission_no }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
     <link rel="icon" type="image/x-icon" href="{{ asset('public/logokid.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .container {
                max-width: 100% !important;
            }
            .card {
                border: 1px solid #000 !important;
                box-shadow: none !important;
            }
            .btn {
                display: none !important;
            }
            body {
                background: white !important;
                font-size: 12pt;
            }
        }
        
        .receipt-header {
            border-bottom: 3px double #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 120px;
            transform: rotate(-45deg);
            z-index: -1;
            top: 40%;
            left: 10%;
            color: #ccc;
        }
        
        .receipt-body {
            position: relative;
        }
        
        .signature-area {
            margin-top: 80px;
            border-top: 1px dashed #333;
            padding-top: 20px;
        }
        
        .amount-in-words {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        
        .receipt-table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .school-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .school-name {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .school-address {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        
        .receipt-title {
            font-size: 24px;
            font-weight: bold;
            color: #e74c3c;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-4">
        <!-- Print Button -->
        <div class="text-end mb-3 no-print">
            <button class="btn btn-success" onclick="window.print()">
                <i class="bi bi-printer"></i> Print Receipt
            </button>
            <button class="btn btn-secondary" onclick="window.close()">
                <i class="bi bi-x-circle"></i> Close
            </button>
        </div>

        <div class="card shadow-lg">
            <div class="card-body p-4">
                <!-- Watermark -->
                <div class="watermark">OFFICIAL RECEIPT</div>
                
                <!-- School Header -->
                <div class="school-header">
                    <div class="school-name">YOUR SCHOOL NAME</div>
                    <div class="school-address">
                        123 School Street, City, State - 123456<br>
                        Phone: +91 9876543210 | Email: info@school.edu<br>
                        Website: www.school.edu
                    </div>
                </div>

                <!-- Receipt Title -->
                <div class="receipt-title">FEE PAYMENT RECEIPT</div>

                <div class="receipt-header">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Receipt No:</strong></td>
                                    <td>REC{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Date:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Academic Year:</strong></td>
                                    <td>{{ \Carbon\Carbon::now()->format('Y') }}-{{ \Carbon\Carbon::now()->addYear()->format('Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Payment ID:</strong></td>
                                    <td>#{{ $payment->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Generated On:</strong></td>
                                    <td>{{ \Carbon\Carbon::now()->format('d/m/Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td><span class="badge bg-success">PAID</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="receipt-body">
                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <strong><i class="bi bi-person"></i> STUDENT INFORMATION</strong>
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
                                            <td>{{ $payment->student->course_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Section:</strong></td>
                                            <td>{{ $payment->student->section ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Father's Name:</strong></td>
                                            <td>{{ $payment->student->father_name ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <strong><i class="bi bi-credit-card"></i> PAYMENT DETAILS</strong>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td><strong>Payment Method:</strong></td>
                                            <td>{{ $payment->payment_mode }}</td>
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
                                            <td>{{ $payment->received_by }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Details -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <strong><i class="bi bi-wallet2"></i> FEE DETAILS</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0 receipt-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Fee Type</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Academic Fee</td>
                                        <td>{{ $payment->studentFee->feeStructure->fee_type ?? 'Tuition Fee' }}</td>
                                        <td>₹{{ number_format($payment->studentFee->total_amount, 2) }}</td>
                                        <td>₹{{ number_format($payment->studentFee->paid_amount, 2) }}</td>
                                        <td>₹{{ number_format($payment->studentFee->balance_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="amount-in-words">
                                <strong>Amount in Words:</strong><br>
                               
                            </div>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>Current Payment:</strong></td>
                                    <td class="text-end"><strong>₹{{ number_format($payment->amount_paid, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Paid:</strong></td>
                                    <td class="text-end text-success"><strong>₹{{ number_format($payment->studentFee->paid_amount, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Balance Due:</strong></td>
                                    <td class="text-end text-danger"><strong>₹{{ number_format($payment->studentFee->balance_amount, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Remarks -->
                    @if($payment->remarks)
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <strong><i class="bi bi-chat-left-text"></i> REMARKS</strong>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $payment->remarks }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Signatures -->
                    <div class="signature-area">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 10px;">
                                    Student/Parent Signature
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 10px;">
                                    Cashier/Accountant
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 10px;">
                                    School Stamp & Signature
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Note -->
                    <div class="text-center mt-4" style="font-size: 12px; color: #7f8c8d;">
                        <p class="mb-1">
                            <strong>Note:</strong> This is a computer generated receipt. No signature required.
                        </p>
                        <p class="mb-0">
                            Please keep this receipt for future reference. For any queries, contact accounts department.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Instructions -->
        <div class="alert alert-info mt-3 no-print">
            <i class="bi bi-info-circle"></i> 
            <strong>Print Instructions:</strong> Click the "Print Receipt" button above or press Ctrl+P to print this receipt.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-print option (optional)
        window.onload = function() {
            // Uncomment the line below if you want to auto-print when page loads
            // window.print();
        };

        // Add print styles
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                @page {
                    size: A4;
                    margin: 20mm;
                }
                body {
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: none !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>