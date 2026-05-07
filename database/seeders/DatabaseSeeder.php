<?php

namespace Database\Seeders;

use App\Models\Entrenador;
use App\Models\Pokemon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Entrenador::factory()
            ->count(3)
            ->has(Pokemon::factory()->count(3), 'pokemons')
            ->create();
    }
}