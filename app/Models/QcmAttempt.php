<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcmAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'module_id',
        'score',
        'max_score',
        'correct_count',
        'question_count',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function answers()
    {
        return $this->hasMany(QcmAttemptAnswer::class);
    }
}
