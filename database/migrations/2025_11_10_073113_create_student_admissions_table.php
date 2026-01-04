<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_admissions', function (Blueprint $table) {
            $table->id();
            
            // Personal Info
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('blood_group')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('category')->nullable();
            $table->string('aadhaar_no')->nullable();

            // Contact Info
            $table->string('mobile_no');
            $table->string('alt_mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->text('address_line1');
            $table->text('address_line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('country')->default('India');

            // Parent/Guardian Info
            $table->string('father_name');
            $table->string('father_occupation')->nullable();
            $table->string('father_contact')->nullable();
            $table->string('mother_name');
            $table->string('mother_occupation')->nullable();
            $table->string('mother_contact')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_contact')->nullable();

            // Academic Info
            $table->string('admission_no')->unique();
            $table->date('admission_date');
            $table->string('academic_year');
            $table->string('class');
            $table->string('section')->nullable();
            $table->string('roll_no')->nullable();
            $table->string('previous_school_name')->nullable();
            $table->string('previous_school_marks')->nullable();
            $table->string('transfer_certificate')->nullable();

            // Fee Info
            $table->decimal('admission_fee', 10, 2)->default(0);
            $table->decimal('tuition_fee', 10, 2)->default(0);
            $table->string('payment_mode')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('fee_receipt')->nullable();

            // Documents
            $table->string('student_photo')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('marksheet')->nullable();
            $table->string('caste_certificate')->nullable();

            // Meta
            $table->string('status')->default('Active');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_admissions');
    }
};
