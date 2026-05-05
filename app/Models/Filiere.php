<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'duration_years',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_years' => 'integer',
    ];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
