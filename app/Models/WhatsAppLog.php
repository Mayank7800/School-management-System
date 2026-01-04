<?php
// app/Models/WhatsAppLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppLog extends Model
{
    protected $fillable = [
        'student_id',
        'template_name',
        'message',
        'parameters',
        'status',
        'response'
    ];

    protected $casts = [
        'parameters' => 'array'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(StudentAdmission::class);
    }
}