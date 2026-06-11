<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index() 
    {
        return response()->json(Trainer::all());
    }
    public function store(Request $request) {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:trainers',
        ]);

        $trainer = Trainer::create($validated);

        return response()->json($trainer, 201);
    }

    public function show(Trainer $trainer) {

        return response()->json($trainer);
    }

    public function update(Request $request, Trainer $trainer) {

        $validated = $request->validate([
            'name' => 'string|max:255',
            'phone_number' => 'string|max:20|unique:trainers',
            
        ]);

        $trainer->update($validated);

        return response()->json($trainer);
    }
    public function destroy(Trainer $trainer) {
        $trainer->delete();

        return response()->json(null, 204);
    }
    public function summary(Trainer $trainer)
    {
        $trainer = Trainer::withCount('pokemon')->findOrFail($trainer->id);
        // Fetch the pokemon using the relationship, ordered alphabetically by nickname
        $orderedPokemon = $trainer->pokemon()->orderBy('level', 'desc')->get();

        // Return a nice summary payload
        return response()->json([
            'trainer_name' => $trainer->name,
            'total_pokemon' => $trainer->pokemon_count,
            'roster' => $orderedPokemon
        ]);
    }
}
