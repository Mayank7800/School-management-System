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
    Schema::create('fee_payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->foreignId('student_fee_id')->constrained()->onDelete('cascade');
        $table->date('payment_date');
        $table->decimal('amount_paid', 10, 2);
        $table->enum('payment_mode', ['Cash', 'UPI', 'Card', 'Bank', 'Cheque']);
        $table->string('transaction_id')->nullable();
        $table->string('bank_name')->nullable();
        $table->string('cheque_no')->nullable();
        $table->text('remarks')->nullable();
        $table->string('received_by')->nullable();
        $table->string('receipt_file')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
