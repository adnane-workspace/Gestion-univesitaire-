<?php

namespace Database\Factories;

use App\Models\Module;
use App\Models\Filiere;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    protected $model = Module::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'code' => strtoupper($this->faker->unique()->bothify('MOD##')),
            'credits' => $this->faker->numberBetween(2, 8),
            'hours' => $this->faker->numberBetween(20, 60),
            'semester' => $this->faker->numberBetween(1, 6),
            'filiere_id' => Filiere::factory(),
            'is_active' => true,
        ];
    }
}
