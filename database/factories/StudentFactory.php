<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'etudiant'])->id,
            'filiere_id' => Filiere::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'student_id_number' => 'STU-' . strtoupper($this->faker->bothify('??####')),
            'birth_date' => $this->faker->date('Y-m-d', '-18 years'),
            'address' => $this->faker->address(),
        ];
    }
}
