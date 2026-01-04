<?php

namespace App\Http\Controllers;

use App\Models\StudentAdmission;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhatsAppController extends Controller
{
    private $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Show WhatsApp messaging form with student data
     */
    public function showForm()
    {
        $templates = $this->whatsappService->getMessageTemplates();
        
        // Get students for dropdown - using course_name for display
        $students = StudentAdmission::active()
            ->orderBy('course_name')
            ->orderBy('first_name')
            ->get();
        
        // Get unique class names for filtering
        $classes = StudentAdmission::getClassNames();
        
        return view('whatsapp.form', compact('templates', 'students', 'classes'));
    }

    /**
     * Send message to specific student
     */
    public function sendToStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:student_admissions,id',
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
        $whatsappNumbers = $student->getWhatsAppNumbers();
        
        $numbers = [];
        $selectedRelations = [];

        switch ($request->send_to) {
            case 'father':
                $selectedRelations = ['Father'];
                break;
            case 'mother':
                $selectedRelations = ['Mother'];
                break;
            case 'guardian':
                $selectedRelations = ['Guardian'];
                break;
            case 'student':
                $selectedRelations = ['Student'];
                break;
            case 'all':
                $selectedRelations = ['Father', 'Mother', 'Guardian', 'Student'];
                break;
        }

        foreach ($whatsappNumbers as $contact) {
            if (in_array($contact['relation'], $selectedRelations)) {
                $numbers[] = $contact['number'];
            }
        }

        if (empty($numbers)) {
            return response()->json([
                'success' => false,
                'error' => 'No valid mobile numbers found for the selected contacts'
            ], 400);
        }

        $results = [];
        foreach ($numbers as $number) {
            $result = $this->whatsappService->sendMessage($number, $request->message);
            $results[] = [
                'number' => $number,
                'success' => $result['success'],
                'response' => $result['data'] ?? null,
                'error' => $result['error'] ?? null
            ];
            
            // Small delay between messages
            usleep(500000); // 0.5 seconds
        }

        $successful = count(array_filter($results, fn($r) => $r['success']));

        return response()->json([
            'success' => $successful > 0,
            'data' => $results,
            'student' => [
                'name' => $student->full_name,
                'class' => $student->course_name, // Use course_name instead of class
                'section' => $student->section,
                'admission_no' => $student->admission_no
            ],
            'message' => "Sent {$successful} message(s) to {$student->full_name}'s contacts"
        ]);
    }

    /**
     * Send message to entire class
     */
    public function sendToClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class' => 'required|string',
            'section' => 'nullable|string',
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

        $allNumbers = [];
        $selectedRelations = [];

        switch ($request->send_to) {
            case 'father':
                $selectedRelations = ['Father'];
                break;
            case 'mother':
                $selectedRelations = ['Mother'];
                break;
            case 'guardian':
                $selectedRelations = ['Guardian'];
                break;
            case 'student':
                $selectedRelations = ['Student'];
                break;
            case 'all':
                $selectedRelations = ['Father', 'Mother', 'Guardian', 'Student'];
                break;
        }

        foreach ($students as $student) {
            $whatsappNumbers = $student->getWhatsAppNumbers();
            
            foreach ($whatsappNumbers as $contact) {
                if (in_array($contact['relation'], $selectedRelations)) {
                    $allNumbers[] = $contact['number'];
                }
            }
        }

        $allNumbers = array_unique($allNumbers); // Remove duplicates

        if (empty($allNumbers)) {
            return response()->json([
                'success' => false,
                'error' => 'No valid mobile numbers found for the selected class'
            ], 400);
        }

        $results = $this->whatsappService->sendBulkMessages($allNumbers, $request->message);

        $successful = count(array_filter($results, fn($r) => $r['success']));

        return response()->json([
            'success' => $successful > 0,
            'data' => $results,
            'summary' => [
                'total_students' => $students->count(),
                'total_numbers' => count($allNumbers),
                'successful' => $successful,
                'failed' => count($results) - $successful
            ],
            'message' => "Sent {$successful} message(s) to contacts of {$students->count()} students in Class {$request->class}"
        ]);
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
                    'class' => $student->course_name, // Use course_name for display
                    'section' => $student->section,
                    'father_name' => $student->father_name,
                    'father_contact' => $student->father_contact,
                    'mother_name' => $student->mother_name,
                    'mother_contact' => $student->mother_contact,
                    'guardian_name' => $student->guardian_name,
                    'guardian_contact' => $student->guardian_contact,
                    'mobile_no' => $student->mobile_no
                ],
                'whatsapp_numbers' => $student->getWhatsAppNumbers()
            ]
        ]);
    }

    /**
     * Get sections by class (AJAX)
     */
    public function getSectionsByClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $sections = StudentAdmission::getSectionsByClassName($request->class);

        return response()->json([
            'success' => true,
            'data' => $sections
        ]);
    }

    /**
     * Send single message
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string|min:10',
            'message' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->whatsappService->sendMessage(
            $request->mobile, 
            $request->message
        );

        return response()->json($result);
    }

    /**
     * Send bulk messages
     */
    public function sendBulkMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numbers' => 'required|array|min:1',
            'numbers.*' => 'required|string|min:10',
            'message' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $results = $this->whatsappService->sendBulkMessages(
            $request->numbers, 
            $request->message
        );

        $successful = count(array_filter($results, fn($r) => $r['success']));
        $failed = count(array_filter($results, fn($r) => !$r['success']));

        return response()->json([
            'success' => $failed === 0, // Overall success if no failures
            'data' => $results,
            'summary' => [
                'total' => count($results),
                'successful' => $successful,
                'failed' => $failed
            ],
            'message' => "Sent {$successful} messages successfully, {$failed} failed"
        ]);
    }

    /**
     * Test API connection
     */
    public function testConnection()
    {
        $result = $this->whatsappService->testConnection();
        
        return response()->json([
            'success' => $result['success'],
            'data' => $result,
            'message' => $result['success'] ? 'API connection test successful' : 'API connection test failed'
        ]);
    }

    /**
     * Send template message
     */
    public function sendTemplateMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string|min:10',
            'template_type' => 'required|string',
            'template_key' => 'required|string',
            'template_data' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $templates = $this->whatsappService->getMessageTemplates();
        
        if (!isset($templates[$request->template_type][$request->template_key])) {
            return response()->json([
                'success' => false,
                'error' => 'Template not found'
            ], 404);
        }

        $template = $templates[$request->template_type][$request->template_key];
        $message = $this->whatsappService->parseTemplate($template, $request->template_data);

        $result = $this->whatsappService->sendMessage($request->mobile, $message);

        return response()->json($result);
    }

    /**
     * Get available templates
     */
    public function getTemplates()
    {
        $templates = $this->whatsappService->getMessageTemplates();
        
        return response()->json([
            'success' => true,
            'data' => $templates
        ]);
    }
}