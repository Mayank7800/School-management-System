<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\Course;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
   public function index()
{
    $query = FeeStructure::with('course');
    
    // Search functionality
    if (request()->has('search') && !empty(request('search'))) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('fee_type', 'like', '%' . $search . '%')
              ->orWhereHas('course', function($q2) use ($search) {
                  $q2->where('name', 'like', '%' . $search . '%');
              });
        });
    }
    
    $feeStructures = $query->latest()->paginate(10);
    
    return view('fee-structures.index', compact('feeStructures'));
}

    public function create()
    {
        $courses = Course::all();
        return view('fee-structures.create', compact('courses') );
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'academic_year' => 'required',
            'fee_type' => 'required',
            'amount' => 'required|numeric',
        ]);

        FeeStructure::create($request->all());
        return redirect()->route('fee-structures.index')->with('success', 'Fee structure added successfully.');
    }

    public function edit(FeeStructure $feeStructure)
    {
        $courses = Course::all();
        return view('fee-structures.edit', compact('feeStructure','courses'));
    }

    public function update(Request $request, FeeStructure $feeStructure)
    {
        $request->validate([
            'course_id' => 'required',
            'academic_year' => 'required',
            'fee_type' => 'required',
            'amount' => 'required|numeric',
        ]);

        $feeStructure->update($request->all());
        return redirect()->route('fee-structures.index')->with('success', 'Fee structure updated successfully.');
    }

    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();
        return back()->with('success', 'Fee structure deleted successfully.');
    }

    public function getFeeStructuresByClass($classId)
{
    $structures = FeeStructure::where('course_id', $classId)
        ->where('status', 'Active')
        ->get(['id', 'fee_type', 'amount']);
    
    return response()->json($structures);
}
}
