<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'capacity',
        'type',
        'floor',
        'building',
        'is_available',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'floor' => 'integer',
        'is_available' => 'boolean',
    ];

    public const TYPES = [
        'classroom' => 'Salle de cours',
        'amphitheater' => 'Amphithéâtre',
        'lab' => 'Laboratoire',
        'conference' => 'Salle de conférence',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
