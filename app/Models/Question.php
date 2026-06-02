<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'text',
        'explanation',
        'difficulty',
        'ai_generated',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
