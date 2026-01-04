<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'gender', 'dob', 'blood_group', 'marital_status', 'nationality',
        'aadhaar_number', 'pan_number', 'mobile', 'alternate_mobile', 'email', 'address_line1', 'address_line2',
        'city', 'state', 'pincode', 'country', 'staff_id', 'joining_date', 'department', 'designation',
        'qualification', 'experience', 'specialization', 'employment_type', 'shift_timing', 'reporting_to',
        'basic_salary', 'allowances', 'deductions', 'net_salary', 'payment_mode', 'bank_name', 'account_number',
        'ifsc_code', 'photo', 'aadhaar_file', 'resume', 'qualification_certificates', 'experience_certificate',
        'appointment_letter', 'username', 'password', 'role', 'status', 'remarks'
    ];

    protected $hidden = ['password'];
}
