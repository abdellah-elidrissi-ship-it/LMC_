<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuiviChapitre;
use Illuminate\Http\Request;

class SuiviChapitreController extends Controller
{
    public function index()
    {
        $suivis = SuiviChapitre::with(['projet', 'chapitre'])->get();
        return response()->json($suivis);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'chapitre_id' => 'required|exists:chapitres_smis,id',
            'avancement_percent' => 'integer|min:0|max:100',
            'phase' => 'in:⬜ Non démarré,⏳ Démarré,🔄 En cours,✅ Terminé',
            'jours_intervention' => 'integer',
            'statut_livrables' => 'nullable|string',
            'observations' => 'nullable|string'
        ]);

        $suivi = SuiviChapitre::create($validated);
        return response()->json($suivi, 201);
    }

    public function show($id)
    {
        $suivi = SuiviChapitre::with(['projet', 'chapitre'])->findOrFail($id);
        return response()->json($suivi);
    }

    public function update(Request $request, $id)
    {
        $suivi = SuiviChapitre::findOrFail($id);
        
        $validated = $request->validate([
            'avancement_percent' => 'integer|min:0|max:100',
            'phase' => 'in:⬜ Non démarré,⏳ Démarré,🔄 En cours,✅ Terminé',
            'jours_intervention' => 'integer',
            'statut_livrables' => 'nullable|string',
            'observations' => 'nullable|string'
        ]);

        $suivi->update($validated);
        return response()->json($suivi);
    }

    public function destroy($id)
    {
        $suivi = SuiviChapitre::findOrFail($id);
        $suivi->delete();
        return response()->json(null, 204);
    }
}