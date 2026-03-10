<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function index()
    {
        $affectations = Affectation::with(['projet', 'consultant'])->get();
        return response()->json($affectations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'consultant_id' => 'required|exists:consultants,id',
            'role_dans_projet' => 'nullable|string',
            'jours_alloues' => 'numeric',
            'jours_realises' => 'numeric'
        ]);

        $affectation = Affectation::create($validated);
        return response()->json($affectation, 201);
    }

    public function show($id)
    {
        $affectation = Affectation::with(['projet', 'consultant'])->findOrFail($id);
        return response()->json($affectation);
    }

    public function update(Request $request, $id)
    {
        $affectation = Affectation::findOrFail($id);
        
        $validated = $request->validate([
            'role_dans_projet' => 'nullable|string',
            'jours_alloues' => 'numeric',
            'jours_realises' => 'numeric'
        ]);

        $affectation->update($validated);
        return response()->json($affectation);
    }

    public function destroy($id)
    {
        $affectation = Affectation::findOrFail($id);
        $affectation->delete();
        return response()->json(null, 204);
    }
}