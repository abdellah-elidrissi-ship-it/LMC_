<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjetFormation;
use Illuminate\Http\Request;

class ProjetFormationController extends Controller
{
    public function index()
    {
        $projetFormations = ProjetFormation::with(['projet', 'formation'])->get();
        return response()->json($projetFormations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'formation_id' => 'required|exists:formations,id',
            'statut' => 'required|in:Finalisée,Réalisée,À planifier,En cours',
            'observations' => 'nullable|string'
        ]);

        $projetFormation = ProjetFormation::create($validated);
        return response()->json($projetFormation, 201);
    }

    public function show($id)
    {
        $projetFormation = ProjetFormation::with(['projet', 'formation'])->findOrFail($id);
        return response()->json($projetFormation);
    }

    public function update(Request $request, $id)
    {
        $projetFormation = ProjetFormation::findOrFail($id);
        
        $validated = $request->validate([
            'statut' => 'sometimes|in:Finalisée,Réalisée,À planifier,En cours',
            'observations' => 'nullable|string'
        ]);

        $projetFormation->update($validated);
        return response()->json($projetFormation);
    }

    public function destroy($id)
    {
        $projetFormation = ProjetFormation::findOrFail($id);
        $projetFormation->delete();
        return response()->json(null, 204);
    }
}