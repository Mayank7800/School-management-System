<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentAdmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentAdmissionController extends Controller
{
    // Show all students
  public function index(Request $request)
{
    $search = $request->input('q');

    $students = StudentAdmission::query()
        ->when($search, function ($query, $search) {
            $query->where('admission_no', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('course_name', 'like', "%{$search}%")
                ->orWhere('section', 'like', "%{$search}%")
                ->orWhere('mobile_no', 'like', "%{$search}%"); // optional
        })
        ->latest()
        ->paginate(10)
        ->appends(['q' => $search]); // keep search value in pagination links

    return view('admissions.index', compact('students'));
}

    // Show form
    public function create()
    {
        $courses= Course::all();
        return view('admissions.create', compact('courses'));
    }

    // Store new admission
  public function store(Request $request)
{
    // Validation rules
    $validated = $request->validate([
        // Personal Details
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'middle_name' => 'nullable|string|max:100',
        'gender' => 'required|in:Male,Female,Other',
        'date_of_birth' => 'required|date|before:today',
        'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'nationality' => 'required|string|max:50',
        
        // Contact & Address
        'mobile_no' => 'required|regex:/^[0-9]{10}$/',
        'alt_mobile_no' => 'nullable|regex:/^[0-9]{10}$/',
        'email' => 'nullable|email|max:100',
        'address_line1' => 'required|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city' => 'required|string|max:50',
        'state' => 'required|string|max:50',
        'pincode' => 'required|regex:/^[0-9]{6}$/',
        'country' => 'required|string|max:50',
        
        // Parents & Guardian
        'father_name' => 'required|string|max:100',
        'father_occupation' => 'nullable|string|max:100',
        'father_contact' => 'required|regex:/^[0-9]{10}$/',
        'mother_name' => 'required|string|max:100',
        'mother_occupation' => 'nullable|string|max:100',
        'mother_contact' => 'nullable|regex:/^[0-9]{10}$/',
        'guardian_name' => 'nullable|string|max:100',
        'guardian_relation' => 'nullable|string|max:50',
        'guardian_contact' => 'nullable|regex:/^[0-9]{10}$/',
        
        // Admission Details
        'admission_no' => 'required|string|unique:student_admissions,admission_no',
        'admission_date' => 'required|date',
        'academic_year' => 'required|string|max:20',
        'class' => 'required|exists:courses,id',
        'section' => 'nullable|string|max:10',
        'roll_no' => 'nullable|string|max:20',
        'admission_fee' => 'nullable|numeric|min:0',
        'tuition_fee' => 'nullable|numeric|min:0',
        'payment_mode' => 'nullable|in:Cash,Card,UPI,Bank Transfer',
        'transaction_id' => 'nullable|string|max:100',
        'fee_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        
        // Documents
        'student_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'id_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'marksheet' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'caste_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'transfer_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'remarks' => 'nullable|string|max:500',
        'status' => 'required|in:Active,Inactive',
    ]);

    try {
        $data = $validated;

        // Set default values for fees if not provided
        $data['admission_fee'] = $request->admission_fee ?? 0;
        $data['tuition_fee'] = $request->tuition_fee ?? 0;
         $course = Course::find($request->class);
        $data['course_name'] = $course->name;

        // Handle file uploads
        $files = [
            'student_photo', 
            'birth_certificate', 
            'id_proof', 
            'marksheet', 
            'caste_certificate', 
            'transfer_certificate', 
            'fee_receipt'
        ];
        
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                // Generate unique filename
                $filename = time() . '_' . $file . '_' . uniqid() . '.' . $request->file($file)->getClientOriginalExtension();
                $data[$file] = $request->file($file)->storeAs('student_docs', $filename, 'public');
            } else {
                $data[$file] = null;
            }
        }

        // Create student admission record
        StudentAdmission::create($data);

        return redirect()->route('admissions.index')->with('success', 'Student Admission created successfully.');

    } catch (\Exception $e) {
        // Log the error
        \Log::error('Student Admission Error: ' . $e->getMessage());
        \Log::error('Error Trace: ' . $e->getTraceAsString());
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create student admission. Please try again.');
    }
}
    // Show a single student
    public function show($id)
    {
        $student = StudentAdmission::findOrFail($id);
        return view('admissions.show', compact('student'));
    }

    // Edit form
  public function edit($id)
{
    try {
        $admission = StudentAdmission::findOrFail($id);
        $courses = Course::where('status', 'active')->orderBy('name')->get();
        
        return view('admissions.edit', compact('admission', 'courses'));
        
    } catch (\Exception $e) {
        \Log::error('Edit Admission Error: ' . $e->getMessage());
        
        return redirect()->route('admissions.index')
            ->with('error', 'Student admission not found.');
    }
}

    // Update existing admission
  public function update(Request $request, $id)
{
    // Validation rules (same as store but with unique ignore for admission_no)
    $validated = $request->validate([
        // Personal Details
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'middle_name' => 'nullable|string|max:100',
        'gender' => 'required|in:Male,Female,Other',
        'date_of_birth' => 'required|date|before:today',
        'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'nationality' => 'required|string|max:50',
        
        // Contact & Address
        'mobile_no' => 'required|regex:/^[0-9]{10}$/',
        'alt_mobile_no' => 'nullable|regex:/^[0-9]{10}$/',
        'email' => 'nullable|email|max:100',
        'address_line1' => 'required|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city' => 'required|string|max:50',
        'state' => 'required|string|max:50',
        'pincode' => 'required|regex:/^[0-9]{6}$/',
        'country' => 'required|string|max:50',
        
        // Parents & Guardian
        'father_name' => 'required|string|max:100',
        'father_occupation' => 'nullable|string|max:100',
        'father_contact' => 'required|regex:/^[0-9]{10}$/',
        'mother_name' => 'required|string|max:100',
        'mother_occupation' => 'nullable|string|max:100',
        'mother_contact' => 'nullable|regex:/^[0-9]{10}$/',
        'guardian_name' => 'nullable|string|max:100',
        'guardian_relation' => 'nullable|string|max:50',
        'guardian_contact' => 'nullable|regex:/^[0-9]{10}$/',
        
        // Admission Details
        'admission_no' => 'required|string|unique:student_admissions,admission_no,' . $id,
        'admission_date' => 'required|date',
        'academic_year' => 'required|string|max:20',
        'class' => 'required|exists:courses,id',
        'section' => 'nullable|string|max:10',
        'roll_no' => 'nullable|string|max:20',
        'admission_fee' => 'nullable|numeric|min:0',
        'tuition_fee' => 'nullable|numeric|min:0',
        'payment_mode' => 'nullable|in:Cash,Card,UPI,Bank Transfer',
        'transaction_id' => 'nullable|string|max:100',
        'fee_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        
        // Documents
        'student_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'id_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'marksheet' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'caste_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'transfer_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'remarks' => 'nullable|string|max:500',
        'status' => 'required|in:Active,Inactive',
    ]);

    try {
        $admission = StudentAdmission::findOrFail($id);
        $data = $validated;

        // Set default values for fees if not provided
        $data['admission_fee'] = $request->admission_fee ?? 0;
        $data['tuition_fee'] = $request->tuition_fee ?? 0;
           $course = Course::find($request->class);
        $data['course_name'] = $course->name; 

        // Handle file uploads - only update if new file is uploaded
        $files = [
            'student_photo', 
            'birth_certificate', 
            'id_proof', 
            'marksheet', 
            'caste_certificate', 
            'transfer_certificate', 
            'fee_receipt'
        ];
        
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                // Delete old file if exists
                if ($admission->$file) {
                    Storage::disk('public')->delete($admission->$file);
                }
                
                // Generate unique filename and store new file
                $filename = time() . '_' . $file . '_' . uniqid() . '.' . $request->file($file)->getClientOriginalExtension();
                $data[$file] = $request->file($file)->storeAs('student_docs', $filename, 'public');
            } else {
                // Keep existing file if no new file uploaded
                $data[$file] = $admission->$file;
            }
        }

        // Update student admission record
        $admission->update($data);

        return redirect()->route('admissions.index')->with('success', 'Student Admission updated successfully.');

    } catch (\Exception $e) {
        // Log the error
        \Log::error('Student Admission Update Error: ' . $e->getMessage());
        \Log::error('Error Trace: ' . $e->getTraceAsString());
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update student admission. Please try again.');
    }
}
    // Delete student admission
    public function destroy($id)
    {
        $student = StudentAdmission::findOrFail($id);

        // Delete uploaded files
        $files = ['student_photo', 'birth_certificate', 'id_proof', 'marksheet', 'caste_certificate', 'transfer_certificate', 'fee_receipt'];
        foreach ($files as $file) {
            if ($student->$file) {
                Storage::disk('public')->delete($student->$file);
            }
        }

        $student->delete();

        return redirect()->route('admissions.index')->with('success', 'Student Admission deleted successfully.');
    }
       
   public function getStudents($classId)
{
    $students = StudentAdmission::where('class', $classId)
        ->get(['id', 'first_name', 'last_name', 'admission_no']);
    
    return response()->json($students);
}
public function search(Request $request)
{
    return app(FeePaymentController::class)->searchStudents($request);
}

public function getStudentFees($id)
{
    return app(FeePaymentController::class)->getStudentFees($id);
}
}
