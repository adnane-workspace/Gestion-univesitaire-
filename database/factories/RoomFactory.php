<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'code' => strtoupper($this->faker->unique()->bothify('RM##')),
            'type' => $this->faker->randomElement(['classroom', 'amphi', 'lab']),
            'capacity' => $this->faker->numberBetween(20, 150),
            'building' => 'Bloc ' . $this->faker->randomLetter(),
            'floor' => $this->faker->numberBetween(0, 4),
        ];
    }
}
