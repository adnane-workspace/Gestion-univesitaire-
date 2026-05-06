<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'filiere_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'student_id_number',
        'address',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Calcule la moyenne pondérée de l'étudiant.
     */
    public function calculateGPA(): float
    {
        $grades = $this->grades()->with('moduleElement')->get();
        
        if ($grades->isEmpty()) {
            return 0.0;
        }

        $totalWeightedScore = 0;
        $totalCoefficients = 0;

        foreach ($grades as $grade) {
            $coeff = $grade->moduleElement->coefficient ?? 1.0;
            $totalWeightedScore += ($grade->score * $coeff);
            $totalCoefficients += $coeff;
        }

        return $totalCoefficients > 0 ? round($totalWeightedScore / $totalCoefficients, 2) : 0.0;
    }
}
