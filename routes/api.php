<?php

use App\Http\Controllers\FeePaymentController;
use Illuminate\Support\Facades\Route;

// Student Search & Fee Payment Routes
Route::prefix('students')->group(function () {
    // Search students
    Route::get('/search', [FeePaymentController::class, 'searchStudents'])->name('api.students.search');
    
    // Get student fee details
    Route::get('/{id}/fees', [FeePaymentController::class, 'getStudentFees'])->name('api.students.fees');
});

// Fee Payment processing
Route::post('/fee-payments', [FeePaymentController::class, 'store'])->name('api.fee-payments.store');

// Receipt generation
Route::get('/fee-payments/{id}/receipt', [FeePaymentController::class, 'generateReceipt'])->name('api.fee-payments.receipt');


use App\Http\Controllers\WhatsAppController;


    Route::prefix('whatsapp')->name('api.whatsapp.')->group(function () {
        // Message sending API endpoints
        Route::post('/send', [WhatsAppController::class, 'sendMessage'])->name('send');
        Route::post('/send-bulk', [WhatsAppController::class, 'sendBulkMessages'])->name('send.bulk');
        Route::post('/send-to-student', [WhatsAppController::class, 'sendToStudent'])->name('send.student');
        Route::post('/send-to-class', [WhatsAppController::class, 'sendToClass'])->name('send.class');
        
        // Data API endpoints
        Route::get('/templates', [WhatsAppController::class, 'getTemplates'])->name('templates');
        Route::get('/students-by-class', [WhatsAppController::class, 'getStudentsByClass'])->name('students.by.class');
        Route::get('/sections-by-class', [WhatsAppController::class, 'getSectionsByClass'])->name('sections.by.class');
        Route::get('/student-details/{id}', [WhatsAppController::class, 'getStudentDetails'])->name('student.details');
    });