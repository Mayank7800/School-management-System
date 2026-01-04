<?php

namespace App\Http\Controllers;

use App\Models\StudentAdmission;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Mail\Mailer;

class EmailController extends Controller
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Show email form
     */
    public function showForm()
    {
        $students = StudentAdmission::active()
            ->orderBy('course_name')
            ->orderBy('first_name')
            ->get();
        
        $classes = StudentAdmission::getClassNames();
        
        return view('emails.form', compact('students', 'classes'));
    }

    /**
     * Send single email
     */
    public function sendEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'subject' => 'required|string|min:1',
            'message' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->emailService->sendEmail(
            $request->email,
            $request->subject,
            $request->message,
            $request->cc ?? [],
            $request->bcc ?? [],
            $request->attachments ?? []
        );

        return response()->json($result);
    }

    /**
     * Send email to student
     */
    public function sendToStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student_admissions,id',
            'subject' => 'required|string|min:1',
            'message' => 'required|string|min:1',
            'send_to' => 'required|in:father,mother,guardian,student,all'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $student = StudentAdmission::findOrFail($request->student_id);
        $result = $this->emailService->sendToStudent(
            $student,
            $request->subject,
            $request->message,
            $request->send_to
        );

        return response()->json($result);
    }

    /**
     * Send email to class
     */
    public function sendToClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class' => 'required|string',
            'section' => 'nullable|string',
            'subject' => 'required|string|min:1',
            'message' => 'required|string|min:1',
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

        $result = $this->emailService->sendToClass(
            $students,
            $request->subject,
            $request->message,
            $request->send_to
        );

        return response()->json($result);
    }

    /**
     * Send bulk emails
     */
    public function sendBulkEmails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emails' => 'required|array|min:1',
            'emails.*' => 'required|email',
            'subject' => 'required|string|min:1',
            'message' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->emailService->sendBulkEmails(
            $request->emails,
            $request->subject,
            $request->message
        );

        return response()->json($result);
    }

    /**
     * Test email configuration
     */
    public function testEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->emailService->testEmail($request->email);

        return response()->json($result);
    }
}