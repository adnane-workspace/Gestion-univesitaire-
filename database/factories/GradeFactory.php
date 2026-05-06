<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Student;
use App\Models\ModuleElement;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    protected $model = Grade::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'module_element_id' => ModuleElement::factory(),
            'score' => $this->faker->randomFloat(2, 0, 20),
            'academic_year' => '2024-2025',
            'session' => 'normal',
        ];
    }
}
