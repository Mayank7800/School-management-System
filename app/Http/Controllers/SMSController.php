<?php

namespace App\Http\Controllers;

use App\Models\StudentAdmission;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SMSController extends Controller
{
    private $smsService;

    public function __construct(SMSService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Show SMS messaging form
     */
    public function showForm()
    {
        $students = StudentAdmission::active()
            ->orderBy('course_name')
            ->orderBy('first_name')
            ->get();
        
        $classes = StudentAdmission::getClassNames();
        
        return view('sms.form', compact('students', 'classes'));
    }

    /**
     * Send single SMS
     */
    public function sendSMS(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string|min:10',
            'message' => 'required|string|min:1|max:160' // SMS length limit
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->smsService->sendSMS(
            $request->mobile, 
            $request->message
        );

        return response()->json($result);
    }

    /**
     * Send SMS to student
     */
    public function sendToStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student_admissions,id',
            'message' => 'required|string|min:1|max:160',
            'send_to' => 'required|in:father,mother,guardian,student,all'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $student = StudentAdmission::findOrFail($request->student_id);
        $result = $this->smsService->sendToStudent(
            $student,
            $request->message,
            $request->send_to
        );

        return response()->json($result);
    }

    /**
     * Send SMS to class
     */
    public function sendToClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class' => 'required|string',
            'section' => 'nullable|string',
            'message' => 'required|string|min:1|max:160',
            'send_to' => 'required|in:father,mother,guardian,student,all'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $query = StudentAdmission::active()->byClassName($request->class);
        
        if ($request->section) {
            $query->bySection($request->section);
        }

        $students = $query->get();
        
        if ($students->isEmpty()) {
            return response()->json([
                'success' => false,
                'error' => 'No students found for the selected class/section'
            ], 404);
        }

        $result = $this->smsService->sendToClass(
            $students,
            $request->message,
            $request->send_to
        );

        return response()->json($result);
    }

    /**
     * Send bulk SMS
     */
    public function sendBulkSMS(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numbers' => 'required|array|min:1',
            'numbers.*' => 'required|string|min:10',
            'message' => 'required|string|min:1|max:160'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->smsService->sendBulkSMS(
            $request->numbers, 
            $request->message
        );

        return response()->json($result);
    }

    /**
     * Test SMS connection
     */
    public function testConnection()
    {
        $result = $this->smsService->testConnection();
        
        return response()->json([
            'success' => $result['success'],
            'data' => $result,
            'message' => $result['success'] ? 'SMS connection test successful' : 'SMS connection test failed'
        ]);
    }

    /**
     * Check SMS balance
     */
    public function checkBalance()
    {
        $result = $this->smsService->checkBalance();
        
        return response()->json($result);
    }

    /**
     * Get students by class (AJAX)
     */
    public function getStudentsByClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class' => 'required|string',
            'section' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $query = StudentAdmission::active()->byClassName($request->class);
        
        if ($request->section) {
            $query->bySection($request->section);
        }

        $students = $query->orderBy('first_name')
                         ->get(['id', 'first_name', 'middle_name', 'last_name', 'admission_no', 'section', 'course_name']);

        // Add full name to each student
        $students->transform(function ($student) {
            $student->full_name = $student->full_name;
            return $student;
        });

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Get student details (AJAX)
     */
    public function getStudentDetails($id)
    {
        $student = StudentAdmission::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'student' => [
                    'id' => $student->id,
                    'full_name' => $student->full_name,
                    'admission_no' => $student->admission_no,
                    'class' => $student->course_name,
                    'section' => $student->section,
                    'father_name' => $student->father_name,
                    'father_contact' => $student->father_contact,
                    'mother_name' => $student->mother_name,
                    'mother_contact' => $student->mother_contact,
                    'guardian_name' => $student->guardian_name,
                    'guardian_contact' => $student->guardian_contact,
                    'mobile_no' => $student->mobile_no
                ]
            ]
        ]);
    }
}