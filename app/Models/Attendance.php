<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'class_id','student_id','attendance_date',
        'status','remarks','marked_by'
    ];



    public function student()
    {
        return $this->belongsTo(StudentAdmission::class, 'student_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
