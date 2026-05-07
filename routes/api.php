<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\PokemonController;

Route::apiResource('entrenadores', EntrenadorController::class);
Route::apiResource('pokemons', PokemonController::class);