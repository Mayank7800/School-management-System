<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'academic_year', 'semester', 'fee_type', 
        'amount', 'due_date', 'remarks', 'status'
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
