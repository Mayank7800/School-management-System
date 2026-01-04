<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentFee;
use App\Models\StudentAdmission;
use App\Models\FeeStructure;
use App\Models\Section;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
  public function index(Request $request)
{
    $query = StudentFee::with(['student', 'feeStructure']);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('student', function($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%");
        })->orWhereHas('feeStructure', function($q) use ($search) {
            $q->where('fee_type', 'like', "%$search%");
        });
    }

    $studentFees = $query->orderBy('updated_at', 'desc')->paginate(10);
    return view('student-fees.index', compact('studentFees'));
}


    public function create()
    {
        $students = StudentAdmission::all();
        $structures = FeeStructure::all();
        $courses= Course::all();
        $sections= Section::all();
        return view('student-fees.create', compact('students', 'structures' ,'courses','sections'));
    }

  public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:student_admissions,id',
        'fee_structure_id' => 'required|exists:fee_structures,id',
        'total_amount' => 'required|numeric|min:0',
        'paid_amount' => 'required|numeric|min:0',
        'payment_status' => 'required|in:Unpaid,Partial,Paid',
    ]);

    // Calculate balance amount
    $paidAmount = $request->input('paid_amount', 0);
    $totalAmount = $request->input('total_amount', 0);
    $balanceAmount = $totalAmount - $paidAmount;
    $payment_status = 'Unpaid';
        if ($paidAmount > 0 && $paidAmount < $totalAmount) {
            $payment_status = 'Partial';
        } elseif ($paidAmount >= $totalAmount) {
            $payment_status = 'Paid';
        }

    // Create student fee record
    StudentFee::create([
        'student_id' => $request->student_id,
        'fee_structure_id' => $request->fee_structure_id,
        'total_amount' => $totalAmount,
        'paid_amount' => $paidAmount,
        'balance_amount' => $balanceAmount,
        'remarks' => $request->remarks,
        'due_date' => $request->due_date,
        'payment_status' => $payment_status,
    ]);

    return redirect()->route('student-fees.index')
        ->with('success', 'Student fee record created successfully.');
}


    public function edit(StudentFee $studentFee)
    {
        $students = StudentAdmission::all();
        $structures = FeeStructure::all();
        return view('student-fees.edit', compact('studentFee', 'students', 'structures'));
    }

    public function update(Request $request, StudentFee $studentFee)
    {
        $request->validate([
            'student_id' => 'required',
            'fee_structure_id' => 'required',
            'total_amount' => 'required|numeric',
             'paid_amount' => 'required|numeric',
        ]);

        $studentFee->update($request->all());
        return redirect()->route('student-fees.index')->with('success', 'Student fee record updated successfully.');
    }

    public function destroy(StudentFee $studentFee)
    {
        $studentFee->delete();
        return back()->with('success', 'Student fee deleted successfully.');
    }
}
