<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'class_type',
        'description',
        'status'
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }
    
}
