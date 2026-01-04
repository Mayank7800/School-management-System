<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'fee_structure_id', 'total_amount', 
        'paid_amount', 'balance_amount', 'payment_status', 
        'due_date', 'remarks'
    ];

    public function student() {
        return $this->belongsTo(StudentAdmission::class);
    }

    public function feeStructure() {
        return $this->belongsTo(FeeStructure::class);
    }

    public function payments() {
        return $this->hasMany(FeePayment::class);
    }

     public function class() {
        return $this->hasMany(Course::class, 'class_id');
    } public function section() {
        return $this->hasMany(Section::class, 'section_id');
    }
     public function feeType()
    {
        return $this->belongsTo(FeeStructure::class);
    }
  
}
