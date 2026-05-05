<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'module_id',
        'room_id',
        'day',
        'start_time',
        'end_time',
        'type',
        'group',
        'academic_year',
    ];

    public const TYPES = [
        'lecture' => 'Cours',
        'tp' => 'Travaux Pratiques (TP)',
        'td' => 'Travaux Dirigés (TD)',
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
