<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\FeePayment;
use App\Models\StudentAdmission;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FeePaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = FeePayment::with(['student', 'studentFee']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('receipt_number', 'like', "%$search%")
                  ->orWhereHas('student', function($q) use ($search) {
                      $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('admission_no', 'like', "%$search%");
                  });
        }

        // Date filters
        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }
        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        $feePayments = $query->orderBy('payment_date', 'desc')->paginate(20);
        
        // Summary calculations
        $totalPayments = $feePayments->total();
        $totalAmount = $feePayments->sum('amount_paid');
        $monthAmount = FeePayment::whereYear('payment_date', date('Y'))
                                ->whereMonth('payment_date', date('m'))
                                ->sum('amount_paid');
        
        return view('fee-payments.index', compact('feePayments', 'totalPayments', 'totalAmount', 'monthAmount'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('fee-payments.create', compact('courses'));
    }

 public function show($id)
{
    $payment = FeePayment::with(['student', 'student.course', 'studentFee', 'studentFee.feeStructure'])
                        ->findOrFail($id);
    
    return view('fee-payments.show', compact('payment'));
}

    public function store(Request $request)
{
    \Log::info('Payment Store Request:', $request->all());

    try {
        // Validate the request
        $validator = \Validator::make($request->all(), [
            'student_id' => 'required|exists:student_admissions,id',
            'student_fee_id' => 'required|exists:student_fees,id',
            'payment_date' => 'required|date|before_or_equal:today',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_mode' => 'required|string|in:Cash,Cheque,Online Transfer,UPI,Card',
            'received_by' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if student fee exists
        $studentFee = StudentFee::find($request->student_fee_id);
        if (!$studentFee) {
            return response()->json([
                'success' => false,
                'message' => 'Student fee record not found.'
            ], 404);
        }

        // Check amount validation
        $dueAmount = $studentFee->total_amount - $studentFee->paid_amount;
        if ($request->amount_paid > $dueAmount) {
            return response()->json([
                'success' => false,
                'message' => "Payment amount (₹{$request->amount_paid}) exceeds due amount (₹{$dueAmount})."
            ], 422);
        }

        DB::beginTransaction();

        // Create payment record
        $paymentData = [
            'student_id' => $request->student_id,
            'student_fee_id' => $request->student_fee_id,
            'payment_date' => $request->payment_date,
            'amount_paid' => $request->amount_paid,
            'payment_mode' => $request->payment_mode,
            'transaction_ref' => $request->transaction_ref,
            'bank_name' => $request->bank_name,
            'cheque_no' => $request->cheque_no,
            'received_by' => $request->received_by,
            'remarks' => $request->remarks,
        ];

        // Handle file upload
        if ($request->hasFile('receipt_file')) {
            $paymentData['receipt_file'] = $request->file('receipt_file')->store('receipts', 'public');
        }

        $payment = FeePayment::create($paymentData);

        // Update student fee balance
        $studentFee->paid_amount += $payment->amount_paid;
        $studentFee->balance_amount = $studentFee->total_amount - $studentFee->paid_amount;
        $studentFee->payment_status = $studentFee->balance_amount <= 0 ? 'Paid' : 'Partial';
        $studentFee->save();

        DB::commit();

        // ALWAYS return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully!',
                'payment_id' => $payment->id,
                'redirect_url' => route('fee-payments.index')
            ]);
        }

        // Fallback for non-AJAX requests
        return redirect()->route('fee-payments.index')->with('success', 'Payment recorded successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Payment creation failed:', ['error' => $e->getMessage()]);
        
        $errorMsg = 'Failed to record payment: ' . $e->getMessage();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $errorMsg
            ], 500);
        }
        
        return back()->with('error', $errorMsg)->withInput();
    }
}
   public function edit($id)
{
    $payment = FeePayment::with(['student', 'student.course', 'studentFee', 'studentFee.feeStructure'])
                        ->findOrFail($id);
    
    return view('fee-payments.edit', compact('payment'));
}



public function update(Request $request, $id)
{
    $payment = FeePayment::with(['studentFee'])->findOrFail($id);

    $request->validate([
        'payment_date' => 'required|date|before_or_equal:today',
        'amount_paid' => 'required|numeric|min:0.01',
        'payment_mode' => 'required|string|in:Cash,Cheque,Online Transfer,UPI,Card',
        'transaction_ref' => 'nullable|string|max:100',
        'bank_name' => 'nullable|string|max:100',
        'cheque_no' => 'nullable|string|max:50',
        'received_by' => 'required|string|max:100',
        'receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        'remarks' => 'nullable|string|max:500',
    ]);

    // Calculate the difference in amount
    $oldAmount = $payment->amount_paid;
    $newAmount = $request->amount_paid;
    $amountDifference = $newAmount - $oldAmount;

    // Check if the new amount is valid
    $studentFee = $payment->studentFee;
    $currentDueAmount = $studentFee->total_amount - ($studentFee->paid_amount - $oldAmount);
    
    if ($newAmount > $currentDueAmount + $oldAmount) {
        return back()->with('error', "Payment amount (₹{$newAmount}) exceeds due amount (₹{$currentDueAmount}).");
    }

    DB::beginTransaction();

    try {
        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('receipt_file')) {
            // Delete old file if exists
            if ($payment->receipt_file && Storage::disk('public')->exists($payment->receipt_file)) {
                Storage::disk('public')->delete($payment->receipt_file);
            }
            $data['receipt_file'] = $request->file('receipt_file')->store('receipts', 'public');
        }

        $payment->update($data);

        // Update student fee balance
        $studentFee->paid_amount += $amountDifference;
        $studentFee->balance_amount = $studentFee->total_amount - $studentFee->paid_amount;
        $studentFee->payment_status = $studentFee->balance_amount <= 0 ? 'Paid' : 
                                    ($studentFee->paid_amount > 0 ? 'Partial' : 'Unpaid');
        $studentFee->save();

        DB::commit();

        return redirect()->route('fee-payments.show', $payment->id)
            ->with('success', 'Payment updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error updating payment: ' . $e->getMessage());
    }
}


    public function destroy($id)
    {
        $payment = FeePayment::findOrFail($id);
        
        // Delete file if exists
        if ($payment->receipt_file && Storage::disk('public')->exists($payment->receipt_file)) {
            Storage::disk('public')->delete($payment->receipt_file);
        }

        // Adjust student fee when deleting payment
        $studentFee = $payment->studentFee;
        $studentFee->paid_amount -= $payment->amount_paid;
        $studentFee->balance_amount = $studentFee->total_amount - $studentFee->paid_amount;
        $studentFee->payment_status = $studentFee->balance_amount <= 0 ? 'Paid' : 
                                    ($studentFee->paid_amount > 0 ? 'Partial' : 'Unpaid');
        $studentFee->save();

        $payment->delete();

        return redirect()->route('fee-payments.index')
            ->with('success', 'Payment record deleted successfully.');
    }

    public function getStudentFees($studentId)
    {
        try {
            $student = StudentAdmission::find($studentId);
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            $studentFees = StudentFee::with(['feeStructure'])
                ->where('student_id', $studentId)
                ->get();

            if ($studentFees->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No fee structure assigned'
                ], 404);
            }

            // Calculate summary
            $totalFees = $studentFees->sum('total_amount');
            $paidAmount = $studentFees->sum('paid_amount');
            $dueAmount = $totalFees - $paidAmount;

            $paymentStatus = 'Unpaid';
            if ($paidAmount >= $totalFees) {
                $paymentStatus = 'Paid';
            } elseif ($paidAmount > 0) {
                $paymentStatus = 'Partial';
            }

            return response()->json([
                'success' => true,
                'feeSummary' => [
                    'total_fees' => floatval($totalFees),
                    'paid_amount' => floatval($paidAmount),
                    'due_amount' => floatval($dueAmount),
                    'payment_status' => $paymentStatus
                ],
                'feeStructureId' => $studentFees->first()->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading fee details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function searchStudents(Request $request)
    {
        try {
            $type = $request->get('type');
            $value = $request->get('value');

            $query = StudentAdmission::with(['course']);

            switch ($type) {
                case 'admission_no':
                    $query->where('admission_no', 'like', "%{$value}%");
                    break;
                case 'class':
                    $query->where('class', $value);
                    break;
            }

            $students = $query->where('status', 'Active')->get();

            return response()->json([
                'success' => true,
                'students' => $students->map(function($student) {
                    return [
                        'id' => $student->id,
                        'first_name' => $student->first_name,
                        'last_name' => $student->last_name,
                        'admission_no' => $student->admission_no,
                        'class_name' => $student->course_name ?? 'N/A',
                        'section' => $student->section,
                        'father_name' => $student->father_name,
                        'mobile' => $student->mobile_no
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching students: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateReceipt($id)
    {
        try {
            $payment = FeePayment::with([
                'student', 
                'student.course',
                'studentFee',
                'studentFee.feeStructure'
            ])->findOrFail($id);

            // For now, return receipt view - you can implement PDF generation later
            return view('fee-payments.receipt', compact('payment'));
            
        } catch (\Exception $e) {
            return redirect()->route('fee-payments.index')
                ->with('error', 'Error generating receipt.');
        }
    }

    // For fee reminders (optional - if you have WhatsApp service)
    public function sendReminders()
    {
        // This method requires WhatsApp service implementation
        $students = StudentAdmission::whereHas('feeRecords', function($query) {
            $query->where('due_date', '<=', now()->addDays(3))
                  ->where('status', 'pending');
        })->get();

        foreach ($students as $student) {
            $dueAmount = $student->pendingFees()->sum('amount');
            $dueDate = $student->pendingFees()->min('due_date');
            
            // Uncomment if you have WhatsApp service
            // $this->whatsappService->sendFeeReminder($student, $dueAmount, $dueDate);
        }
        
        return back()->with('success', 'Fee reminders sent successfully.');
    }

      private function convertNumberToWords($number)
    {
        $number = round($number, 2);
        $whole = floor($number);
        $fraction = round(($number - $whole) * 100);
        
        $words = $this->convertToWords($whole);
        
        if ($fraction > 0) {
            $words .= ' and ' . $this->convertToWords($fraction) . ' Paise';
        }
        
        return ucfirst($words);
    }

    private function convertToWords($number)
    {
        $ones = array(
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen'
        );
        
        $tens = array(
            2 => 'Twenty',
            3 => 'Thirty',
            4 => 'Forty',
            5 => 'Fifty',
            6 => 'Sixty',
            7 => 'Seventy',
            8 => 'Eighty',
            9 => 'Ninety'
        );
        
        if ($number == 0) {
            return 'Zero';
        }
        
        if ($number < 20) {
            return $ones[$number];
        }
        
        if ($number < 100) {
            return $tens[floor($number / 10)] . ' ' . $ones[$number % 10];
        }
        
        if ($number < 1000) {
            return $ones[floor($number / 100)] . ' Hundred ' . $this->convertToWords($number % 100);
        }
        
        if ($number < 100000) {
            return $this->convertToWords(floor($number / 1000)) . ' Thousand ' . $this->convertToWords($number % 1000);
        }
        
        if ($number < 10000000) {
            return $this->convertToWords(floor($number / 100000)) . ' Lakh ' . $this->convertToWords($number % 100000);
        }
        
        return $this->convertToWords(floor($number / 10000000)) . ' Crore ' . $this->convertToWords($number % 10000000);
    }

    // Make the method available to views
    public function __call($method, $parameters)
    {
        if ($method === 'convertNumberToWords') {
            return $this->convertNumberToWords(...$parameters);
        }
        
        return parent::__call($method, $parameters);
    }
}