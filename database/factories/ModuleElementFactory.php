<?php

namespace Database\Factories;

use App\Models\ModuleElement;
use App\Models\Module;
use App\Models\Professor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleElementFactory extends Factory
{
    protected $model = ModuleElement::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'code' => strtoupper($this->faker->unique()->bothify('EL##')),
            'coefficient' => 1.0,
            'module_id' => Module::factory(),
            'professor_id' => Professor::factory(),
        ];
    }
}
