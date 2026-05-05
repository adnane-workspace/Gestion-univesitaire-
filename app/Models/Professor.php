<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'speciality',
        'hire_date',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'professor_module')
            ->withPivot('academic_year')
            ->withTimestamps();
    }

    public function moduleElements()
    {
        return $this->hasMany(ModuleElement::class, 'professor_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'professor_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
