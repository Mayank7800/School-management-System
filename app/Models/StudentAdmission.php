<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAdmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'date_of_birth',
        'blood_group',
        'nationality',
        'religion',
        'category',
        'aadhaar_no',
        'mobile_no',
        'alt_mobile_no',
        'email',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
        'country',
        'father_name',
        'father_occupation',
        'father_contact',
        'mother_name',
        'mother_occupation',
        'mother_contact',
        'guardian_name',
        'guardian_relation',
        'guardian_contact',
        'admission_no',
        'admission_date',
        'academic_year',
        'class', // This is course ID
        'section',
        'roll_no',
        'previous_school_name',
        'previous_school_marks',
        'transfer_certificate',
        'admission_fee',
        'tuition_fee',
        'payment_mode',
        'transaction_id',
        'fee_receipt',
        'student_photo',
        'birth_certificate',
        'id_proof',
        'marksheet',
        'caste_certificate',
        'status',
        'remarks',
        'created_by',
        'updated_by',
        'course_name' // This is the actual class name
    ];

    /**
     * Relationship with Course model (using class field as foreign key)
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'class'); // class is the foreign key
    }

    /**
     * Get the class name from course relationship or course_name field
     */
    public function getClassNameAttribute()
    {
        if ($this->course) {
            return $this->course->name;
        }
        return $this->course_name;
    }

    /**
     * Get full name of student
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name);
    }

    /**
     * Get formatted mobile numbers for WhatsApp
     */
    public function getWhatsAppNumbers(): array
    {
        $numbers = [];
        
        // Father's contact
        if (!empty($this->father_contact)) {
            $numbers[] = [
                'number' => $this->formatMobile($this->father_contact),
                'relation' => 'Father',
                'name' => $this->father_name
            ];
        }
        
        // Mother's contact
        if (!empty($this->mother_contact)) {
            $numbers[] = [
                'number' => $this->formatMobile($this->mother_contact),
                'relation' => 'Mother', 
                'name' => $this->mother_name
            ];
        }
        
        // Guardian's contact (if provided)
        if (!empty($this->guardian_contact)) {
            $numbers[] = [
                'number' => $this->formatMobile($this->guardian_contact),
                'relation' => 'Guardian',
                'name' => $this->guardian_name
            ];
        }
        
        // Student's mobile (if provided)
        if (!empty($this->mobile_no)) {
            $numbers[] = [
                'number' => $this->formatMobile($this->mobile_no),
                'relation' => 'Student',
                'name' => $this->full_name
            ];
        }
        
        return $numbers;
    }

    /**
     * Format mobile number for WhatsApp
     */
    private function formatMobile(string $mobile): string
    {
        // Remove any spaces, dashes, or plus signs
        $mobile = preg_replace('/[+\s\-]/', '', $mobile);
        
        // If number starts with 0, replace with 91
        if (substr($mobile, 0, 1) === '0') {
            $mobile = '91' . substr($mobile, 1);
        }
        
        // If number doesn't start with country code, add 91
        if (strlen($mobile) === 10) {
            $mobile = '91' . $mobile;
        }
        
        return $mobile;
    }

    /**
     * Scope for filtering by class name (course_name)
     */
    public function scopeByClassName($query, $className)
    {
        return $query->where('course_name', $className);
    }

    /**
     * Scope for filtering by section
     */
    public function scopeBySection($query, $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Scope for active students only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get all unique class names (from course_name field)
     */
    public static function getClassNames()
    {
        return self::distinct()
                  ->whereNotNull('course_name')
                  ->where('course_name', '!=', '')
                  ->orderBy('course_name')
                  ->pluck('course_name');
    }

    /**
     * Get all unique sections for a class name
     */
    public static function getSectionsByClassName($className)
    {
        return self::where('course_name', $className)
                  ->distinct()
                  ->whereNotNull('section')
                  ->where('section', '!=', '')
                  ->orderBy('section')
                  ->pluck('section');
    }

    /**
     * Accessor for display class information
     */
    public function getClassDisplayAttribute()
    {
        $display = $this->course_name;
        if ($this->section) {
            $display .= ' - ' . $this->section;
        }
        return $display;
    }
}