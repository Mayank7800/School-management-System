<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'student_fee_id', 'payment_date', 
        'amount_paid', 'payment_mode', 'transaction_id', 
        'bank_name', 'cheque_no', 'remarks', 'received_by', 'receipt_file'
    ];

    public function student() {
        return $this->belongsTo(StudentAdmission::class);
    }

    public function studentFee() {
        return $this->belongsTo(StudentFee::class);
    }
     public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class,'student_fee_id');
    }
     public function course() {
        return $this->belongsTo(Course::class);
    }
     public function section() {
        return $this->belongsTo(Section::class);
    }
   
}
