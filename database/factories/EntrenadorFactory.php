<?php

namespace Database\Factories;

use App\Models\Entrenador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entrenador>
 */
class EntrenadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
    'nombre' => fake()->firstName(),
    'ciudad' => fake()->randomElement(['Pueblo Paleta','Ciudad Verde','Ciudad Plateada']),
    'edad'   => fake()->numberBetween(10, 40),
];

    }
}
