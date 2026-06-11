<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\PokemonController;

Route::apiResource('trainers', TrainerController::class);
Route::apiResource('trainers.pokemon', PokemonController::class);
Route::get('trainers/{trainer}/summary', [TrainerController::class, 'summary']);