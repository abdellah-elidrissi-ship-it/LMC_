<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChapitreSmi;
use Illuminate\Http\Request;

class ChapitreSmiController extends Controller
{
    public function index()
    {
        $chapitres = ChapitreSmi::with('suivis')->ordered()->get();
        return response()->json($chapitres);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_chapitre' => 'required|string',
            'titre_chapitre' => 'required|string',
            'exigences_cles' => 'nullable|string',
            'ordre' => 'integer'
        ]);

        $chapitre = ChapitreSmi::create($validated);
        return response()->json($chapitre, 201);
    }

    public function show($id)
    {
        $chapitre = ChapitreSmi::with('suivis.projet')->findOrFail($id);
        return response()->json($chapitre);
    }

    public function update(Request $request, $id)
    {
        $chapitre = ChapitreSmi::findOrFail($id);
        
        $validated = $request->validate([
            'code_chapitre' => 'sometimes|string',
            'titre_chapitre' => 'sometimes|string',
            'exigences_cles' => 'nullable|string',
            'ordre' => 'integer'
        ]);

        $chapitre->update($validated);
        return response()->json($chapitre);
    }

    public function destroy($id)
    {
        $chapitre = ChapitreSmi::findOrFail($id);
        $chapitre->delete();
        return response()->json(null, 204);
    }
}