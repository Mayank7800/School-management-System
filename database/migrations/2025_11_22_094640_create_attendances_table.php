<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('class_id'); // from courses table
        $table->unsignedBigInteger('student_id'); // from studentadmissions
        $table->date('attendance_date');
        $table->enum('status', ['Present','Absent','Late','Excused']);
        $table->string('remarks')->nullable();
        $table->string('marked_by')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
