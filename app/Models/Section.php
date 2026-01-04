<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'class_name',
        'name',
        'teacher_incharge',
        'capacity',
    ];

    // each section belongs to one course (class)
    public function course()
    {
        return $this->belongsTo(Course::class, 'class_id');
    }

    // each section can have many attendance records
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'section_id');
    }

    // each section can have many students
    public function students()
    {
        return $this->hasMany(StudentAdmission::class, 'section', 'name');
        // if student_admissions.section stores section name like "A" or "B"
    }
}
