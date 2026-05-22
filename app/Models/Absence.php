<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'schedule_id',
        'date',
        'reason',
        'excused',
    ];

    protected $casts = [
        'date' => 'date',
        'excused' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
