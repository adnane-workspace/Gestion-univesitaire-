<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleElement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'coefficient',
        'module_id',
        'professor_id',
    ];

    protected $casts = [
        'coefficient' => 'float',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
