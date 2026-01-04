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
    Schema::create('fee_structures', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained()->onDelete('cascade');
        $table->string('academic_year');
        $table->string('semester')->nullable();
        $table->string('fee_type');
        $table->decimal('amount', 10, 2);
        $table->date('due_date')->nullable();
        $table->text('remarks')->nullable();
        $table->enum('status', ['Active', 'Inactive'])->default('Active');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
