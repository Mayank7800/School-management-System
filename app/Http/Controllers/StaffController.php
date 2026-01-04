<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {  
         $validated = $request->validate([
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'mobile' => 'required|digits:10',
        'email' => 'required|email|unique:staff,email',
        'staff_id' => 'required|unique:staff,staff_id',
        'username' => 'required|unique:staff,username',
        'password' => 'required|min:6',
        'aadhaar_number' => 'nullable|digits:12',
        'gender' => 'required|string|in:Male,Female,Other',
        'dob' => 'required|date',
    ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        // Handle file uploads
        foreach (['photo', 'aadhaar_file', 'resume', 'qualification_certificates', 'experience_certificate', 'appointment_letter'] as $file) {
            if ($request->hasFile($file)) {
                $data[$file] = $request->file($file)->store('staff_docs', 'public');
            }
        }

        Staff::create($data);

            return redirect()->route('staff.index')->with('success', 'Staff registered successfully!');

    }
    
    public function index()
{
    $staff = Staff::orderBy('id', 'desc')->paginate(10);

    return view('staff.index', [
        'staff' => $staff,
        'totalStaff' => Staff::count(),
        'activeStaff' => Staff::where('status', 'Active')->count(),
        'inactiveStaff' => Staff::where('status', 'Inactive')->count(),
        'departmentsCount' => Staff::distinct('department')->count('department'),
    ]);
}
 public function show($id)
{
    $staff = Staff::findOrFail($id);
    return view('staff.show', compact('staff'));
}
public function edit($id)
{
    $staff = Staff::findOrFail($id);
    return view('staff.edit', compact('staff'));
}

public function update(Request $request, $id)
{
    $staff = Staff::findOrFail($id);

    // 🧾 Validation Rules
    $validated = $request->validate([
        // Personal Info
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'gender' => 'required|string|in:Male,Female,Other',
        'dob' => 'required|date',
        'blood_group' => 'nullable|string|max:5',
        'marital_status' => 'nullable|string|max:20',
        'nationality' => 'nullable|string|max:100',
        'aadhaar_number' => 'required|digits:12',
        'pan_number' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',

        // Contact Info
        'mobile' => 'required|digits:10',
        'alternate_mobile' => 'nullable|digits:10',
        'email' => 'required|email|max:255',
        'address_line1' => 'nullable|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'pincode' => 'nullable|digits:6',
        'country' => 'nullable|string|max:100',

        // Employment
        'department' => 'nullable|string|max:255',
        'designation' => 'nullable|string|max:255',
        'joining_date' => 'nullable|date',
        'status' => 'nullable|string|max:50',

        // Salary
        'basic_salary' => 'nullable|numeric|min:0',
        'allowances' => 'nullable|numeric|min:0',
        'deductions' => 'nullable|numeric|min:0',

        // Files
        'photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        'aadhaar_file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        'resume' => 'nullable|mimes:pdf,doc,docx|max:4096',
        'qualification_certificates' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        'experience_certificate' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        'appointment_letter' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',

        // Login Info
        'username' => 'nullable|string|max:100',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    // 🧠 Remove password if empty
    $data = collect($validated)->except(['password'])->toArray();

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    // 📁 Handle file uploads with cleanup
    foreach (['photo', 'aadhaar_file', 'resume', 'qualification_certificates', 'experience_certificate', 'appointment_letter'] as $file) {
        if ($request->hasFile($file)) {
            // delete old file if exists
            if ($staff->$file && Storage::disk('public')->exists($staff->$file)) {
                Storage::disk('public')->delete($staff->$file);
            }
            // store new one
            $data[$file] = $request->file($file)->store('staff_files', 'public');
        }
    }

    // ✅ Update record
    $staff->update($data);

    return redirect()
        ->route('staff.show', $staff->id)
        ->with('success', '✅ Staff details updated successfully!');
}


}
