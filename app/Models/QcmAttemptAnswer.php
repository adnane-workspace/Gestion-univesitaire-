<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QcmAttemptAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'qcm_attempt_id',
        'question_id',
        'selected_choice_id',
        'is_correct',
    ];

    public function qcmAttempt()
    {
        return $this->belongsTo(QcmAttempt::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedChoice()
    {
        return $this->belongsTo(Choice::class, 'selected_choice_id');
    }
}
