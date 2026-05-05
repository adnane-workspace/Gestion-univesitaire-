<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'credits',
        'hours',
        'semester',
        'filiere_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credits' => 'integer',
        'hours' => 'integer',
        'semester' => 'integer',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function moduleElements()
    {
        return $this->hasMany(ModuleElement::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'professor_module')
            ->withPivot('academic_year')
            ->withTimestamps();
    }
}
