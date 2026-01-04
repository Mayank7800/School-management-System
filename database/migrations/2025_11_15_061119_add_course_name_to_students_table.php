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
    Schema::table('student_admissions', function (Blueprint $table) {
        $table->unsignedBigInteger('course_id')->after('id');
        $table->string('course_name')->after('course_id');
    });
}

public function down()
{
    Schema::table('student_admissions', function (Blueprint $table) {
        $table->dropColumn(['course_id', 'course_name']);
    });
}

};
