<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentAdmissionController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\StudentFeeController;
use App\Http\Controllers\FeePaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SMSController;

Route::middleware('auth')->group(function () {

Route::get('/home', [HomeController::class, 'create'])->name('home');
Route::resource('staff', StaffController::class);
Route::resource('admissions', StudentAdmissionController::class);


Route::resource('courses', CourseController::class);
Route::resource('fee-structures', FeeStructureController::class);
Route::resource('student-fees', StudentFeeController::class);
Route::resource('fee-payments', FeePaymentController::class);

Route::get('/reports/export/{table}', [ReportController::class, 'export'])->name('reports.export');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');


Route::get('/attendance/mark', [AttendanceController::class, 'index'])->name('attendance.create');
Route::get('/attendance', [AttendanceController::class, 'attendanceIndex'])->name('attendance.index');
Route::get('/attendance/class/{classId}', [AttendanceController::class, 'getAttendanceByClass']);
Route::get('/attendance/students/{classId}', [AttendanceController::class, 'getStudents']);
Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Add this route to your web.php file
Route::get('/fee-payments/get-class-fees/{className}/{studentId}', [FeePaymentController::class, 'getClassFees'])
    ->name('fee-payments.get-class-fees');
// routes/web.php

// Make sure you're using the correct resource route

// Or if you want to be explicit, define all routes manually:
Route::get('/syllabus', [SyllabusController::class, 'index'])->name('syllabus.index');
Route::get('/syllabus/create', [SyllabusController::class, 'create'])->name('syllabus.create');
Route::post('/syllabus', [SyllabusController::class, 'store'])->name('syllabus.store');
Route::get('/syllabus/{id}/edit', [SyllabusController::class, 'edit'])->name('syllabus.edit');
Route::put('/syllabus/{id}', [SyllabusController::class, 'update'])->name('syllabus.update');
Route::delete('/syllabus/{id}', [SyllabusController::class, 'destroy'])->name('syllabus.destroy');

Route::get('syllabus/{syllabus}/download', [SyllabusController::class, 'download'])->name('syllabus.download');
Route::get('syllabus/{syllabus}/view', [SyllabusController::class, 'view'])->name('syllabus.view');
Route::get('get-sections/{classId}', [SyllabusController::class, 'getSections'])->name('get.sections');


// Add these routes for AJAX calls
Route::get('/get-sections/{classId}', [StudentAdmissionController::class, 'getSections'])->name('get.sections');
Route::get('/get-students/{classId}', [StudentAdmissionController::class, 'getStudents'])->name('get.students');
Route::get('/get-fee-structures/{classId}', [FeeStructureController::class, 'getFeeStructuresByClass'])->name('get.fee-structures.by-class');
Route::get('/search-students', [FeePaymentController::class, 'searchStudents'])->name('search.students');
Route::get('/student-fees-payment/{id}', [FeePaymentController::class, 'getStudentFees'])->name('student.fees');
Route::get('/fee-payments/{id}/receipt', [FeePaymentController::class, 'generateReceipt'])->name('fee-payments.receipt');


Route::get('/attendance/sections/{class}', [AttendanceController::class, 'getSections']);
Route::get('/attendance/students/{class}/{section}', [AttendanceController::class, 'getStudentsByClassAndSection']);
});

// routes/web.php



// Public routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// routes/web.php
Route::middleware(['auth'])->group(function () {
   
});

 Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
        // Main form route
        Route::get('/', [WhatsAppController::class, 'showForm'])->name('form');
        
        // Message sending routes
        Route::post('/send-message', [WhatsAppController::class, 'sendMessage'])->name('send.message');
        Route::post('/send-bulk', [WhatsAppController::class, 'sendBulkMessages'])->name('send.bulk');
        Route::post('/send-to-student', [WhatsAppController::class, 'sendToStudent'])->name('send.student');
        Route::post('/send-to-class', [WhatsAppController::class, 'sendToClass'])->name('send.class');
        Route::post('/send-template', [WhatsAppController::class, 'sendTemplateMessage'])->name('send.template');
        
        // Data fetching routes (AJAX)
        Route::get('/templates', [WhatsAppController::class, 'getTemplates'])->name('templates');
        Route::get('/students-by-class', [WhatsAppController::class, 'getStudentsByClass'])->name('students.by.class');
        Route::get('/sections-by-class', [WhatsAppController::class, 'getSectionsByClass'])->name('sections.by.class');
        Route::get('/student-details/{id}', [WhatsAppController::class, 'getStudentDetails'])->name('student.details');
        
        // Test route (optional - for debugging)
        Route::get('/test', [WhatsAppController::class, 'testConnection'])->name('test');
    });


Route::get('/test-student-data', function() {
    $student = App\Models\StudentAdmission::first();
    
    if (!$student) {
        return "No student found";
    }
    
    $whatsappService = new App\Services\WhatsAppService();
    $studentData = $whatsappService->testStudentData($student);
    
    return response()->json([
        'student' => $studentData,
        'all_attributes' => $student->toArray()
    ]);


    // Test route for WhatsApp API debugging
Route::get('/whatsapp/test', function () {
    $whatsappService = new App\Services\WhatsAppService();
    
    // Test connection
    $result = $whatsappService->testConnection();
    
    return response()->json([
        'test_result' => $result,
        'api_key' => config('services.whatsapp.api_key'),
        'environment' => app()->environment()
    ]);
});
});


// Email Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('email')->name('email.')->group(function () {
        Route::get('/', [EmailController::class, 'showForm'])->name('form');
        Route::post('/send', [EmailController::class, 'sendEmail'])->name('send');
        Route::post('/send-bulk', [EmailController::class, 'sendBulkEmails'])->name('send.bulk');
        Route::post('/send-to-student', [EmailController::class, 'sendToStudent'])->name('send.student');
        Route::post('/send-to-class', [EmailController::class, 'sendToClass'])->name('send.class');
        Route::get('/test', [EmailController::class, 'testEmail'])->name('test');
    });
});


// SMS Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('sms')->name('sms.')->group(function () {
        Route::get('/', [SMSController::class, 'showForm'])->name('form');
        Route::post('/send', [SMSController::class, 'sendSMS'])->name('send');
        Route::post('/send-bulk', [SMSController::class, 'sendBulkSMS'])->name('send.bulk');
        Route::post('/send-to-student', [SMSController::class, 'sendToStudent'])->name('send.student');
        Route::post('/send-to-class', [SMSController::class, 'sendToClass'])->name('send.class');
        Route::get('/test', [SMSController::class, 'testConnection'])->name('test');
        Route::get('/balance', [SMSController::class, 'checkBalance'])->name('balance');
        Route::get('/students-by-class', [SMSController::class, 'getStudentsByClass'])->name('students.by.class');
        Route::get('/student-details/{id}', [SMSController::class, 'getStudentDetails'])->name('student.details');
    });
});