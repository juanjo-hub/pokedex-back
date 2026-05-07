<?php

namespace Database\Factories;

use App\Models\Pokemon;
use App\Models\Entrenador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pokemon>
 */
class PokemonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement(['Pikachu', 'Charizard', 'Bulbasaur', 'Squirtle']),
            'tipo'   => fake()->randomElement(['fuego', 'agua', 'planta', 'electrico']),
            'nivel'  => fake()->numberBetween(1, 100),
            'entrenador_id' => Entrenador::factory(),
        ];
    }
}