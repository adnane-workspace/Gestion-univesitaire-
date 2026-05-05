<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'module_element_id',
        'score',
        'session',
        'academic_year',
        'observation',
    ];

    protected $casts = [
        'score' => 'float',
    ];

    public const SESSIONS = [
        'normal' => 'Normale',
        'retake' => 'Rattrapage',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function moduleElement()
    {
        return $this->belongsTo(ModuleElement::class);
    }
}
