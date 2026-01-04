<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();

            // Personal Info
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->string('pan_number')->nullable();

            // Contact Info
            $table->string('mobile');
            $table->string('alternate_mobile')->nullable();
            $table->string('email')->unique();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('country')->nullable();

            // Employment
            $table->string('staff_id')->unique();
            $table->date('joining_date')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('qualification')->nullable();
            $table->integer('experience')->nullable();
            $table->string('specialization')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('shift_timing')->nullable();
            $table->string('reporting_to')->nullable();

            // Salary
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->decimal('allowances', 10, 2)->nullable();
            $table->decimal('deductions', 10, 2)->nullable();
            $table->decimal('net_salary', 10, 2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();

            // Documents
            $table->string('photo')->nullable();
            $table->string('aadhaar_file')->nullable();
            $table->string('resume')->nullable();
            $table->string('qualification_certificates')->nullable();
            $table->string('experience_certificate')->nullable();
            $table->string('appointment_letter')->nullable();

            // System
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('Teacher');
            $table->string('status')->default('Active');
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
