<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with('projets')->get();
        return response()->json($formations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre_formation' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $formation = Formation::create($validated);
        return response()->json($formation, 201);
    }

    public function show($id)
    {
        $formation = Formation::with('projets')->findOrFail($id);
        return response()->json($formation);
    }

    public function update(Request $request, $id)
    {
        $formation = Formation::findOrFail($id);
        
        $validated = $request->validate([
            'titre_formation' => 'sometimes|string',
            'description' => 'nullable|string'
        ]);

        $formation->update($validated);
        return response()->json($formation);
    }

    public function destroy($id)
    {
        $formation = Formation::findOrFail($id);
        $formation->delete();
        return response()->json(null, 204);
    }
}