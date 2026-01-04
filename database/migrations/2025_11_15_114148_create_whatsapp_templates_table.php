<?php
// database/migrations/2024_01_01_create_whatsapp_templates_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // ACADEMIC, ATTENDANCE, FEE, GENERAL, etc.
            $table->string('template_name'); // WhatsApp approved template name
            $table->text('body');
            $table->json('variables'); // Template variables
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('template_name');
            $table->text('message');
            $table->json('parameters')->nullable();
            $table->string('status'); // sent, delivered, read, failed
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('whatsapp_logs');
        Schema::dropIfExists('whatsapp_templates');
    }
};