<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function index(Trainer $trainer)
{
    // return only this trainer's pokemon
    return response()->json($trainer->pokemon);
}

public function store(Request $request, Trainer $trainer)
{
    $validated = $request->validate([
        'pokemon_id' => 'required|integer',
        'nickname'   => 'nullable|string|max:255',
        'level'      => 'nullable|integer|min:1|max:100',
    ]);

    $response = http::get("https://pokeapi.co/api/v2/pokemon/{$validated['pokemon_id']}");

    if ($response->failed()) {
        return response()->json(['error' => 'Invalid pokemon_id'], 422);
    }

    $pokemonData = $response->json();

    // create pokemon belonging to this trainer
    $pokemon = $trainer->pokemon()->create($validated);

    return response()->json([
        'caught_pokemon' => $pokemon,
        'species' => [
            'name' => $pokemonData['name'],
            'types' => collect($pokemonData['types'])->pluck('type.name'),
            'sprite' => $pokemonData['sprites']['front_default'],
        ],
    ], 201);
}

public function show(Trainer $trainer, Pokemon $pokemon)
{
    return response()->json($pokemon);
}

public function update(Request $request, Trainer $trainer, Pokemon $pokemon)
{
    $validated = $request->validate([
        'nickname' => 'sometimes|string|max:255',
        'level'    => 'sometimes|integer|min:1|max:100',
    ]);

    $pokemon->update($validated);
    return response()->json($pokemon);
}

public function destroy(Trainer $trainer, Pokemon $pokemon)
{
    $pokemon->delete();
    return response()->json(null, 204);
}
}
