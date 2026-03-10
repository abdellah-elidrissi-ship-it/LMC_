<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    /**
     * Page principale — liste des projets (WEB)
     * Filtre automatique selon le rôle de l'utilisateur connecté
     */
    
    public function index()
{
    /** @var \App\Models\User $user */
    $user = auth()->user();

    $query = Projet::with(['client','chefProjet','normes','affectations.consultant']);

    if (!$user->isSuperAdmin()) {
        if ($user->consultant_id) {
            $query->where(function($q) use ($user) {
                $q->where('chef_projet_id', $user->consultant_id)
                  ->orWhereIn('id', function($sub) use ($user) {
                      $sub->select('projet_id')
                          ->from('affectations')
                          ->where('consultant_id', $user->consultant_id);
                  });
            });
        } else {
            // User sans consultant lié — yma3ndosh projets
            $query->whereRaw('1 = 0');
        }
    }

    $projets = $query->orderBy('reference_projet')->get();
    return view('projets', compact('projets'));
}

    // ──────────────────────────────────────────────
    // API METHODS (JSON) — utilisés par les autres controllers
    // ──────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_projet'   => 'required|string|unique:projets',
            'client_id'          => 'required|exists:clients,id',
            'chef_projet_id'     => 'required|exists:consultants,id',
            'type_projet'        => 'required|string',
            'statut'             => 'required|in:Finalisé,En cours,Planifié,En retard,En pause',
            'jours_prevus'       => 'required|integer',
            'jours_realises'     => 'required|integer',
            'avancement_percent' => 'required|integer|min:0|max:100',
            'blocage'            => 'nullable|string',
            'commentaire'        => 'nullable|string',
            'date_debut'         => 'nullable|date',
            'date_fin_prevue'    => 'nullable|date',
            'date_fin_reelle'    => 'nullable|date',
            'normes'             => 'sometimes|array',
        ]);

        $projet = Projet::create($validated);

        if ($request->has('normes')) {
            $projet->normes()->sync($request->normes);
        }

        return response()->json(
            $projet->load(['client', 'chefProjet', 'normes']),
            201
        );
    }

    public function show($id)
    {
        $projet = Projet::with([
            'client',
            'chefProjet',
            'normes',
            'affectations.consultant',
            'suiviChapitres.chapitre',
            'formations'
        ])->findOrFail($id);

        return response()->json($projet);
    }

    public function update(Request $request, $id)
    {
        $projet = Projet::findOrFail($id);

        $validated = $request->validate([
            'client_id'          => 'sometimes|exists:clients,id',
            'chef_projet_id'     => 'sometimes|exists:consultants,id',
            'type_projet'        => 'sometimes|string',
            'statut'             => 'sometimes|in:Finalisé,En cours,Planifié,En retard,En pause',
            'jours_prevus'       => 'sometimes|integer',
            'jours_realises'     => 'sometimes|integer',
            'avancement_percent' => 'sometimes|integer|min:0|max:100',
            'blocage'            => 'nullable|string',
            'commentaire'        => 'nullable|string',
            'date_debut'         => 'nullable|date',
            'date_fin_prevue'    => 'nullable|date',
            'date_fin_reelle'    => 'nullable|date',
            'normes'             => 'sometimes|array',
        ]);

        $projet->update($validated);

        if ($request->has('normes')) {
            $projet->normes()->sync($request->normes);
        }

        return response()->json(
            $projet->load(['client', 'chefProjet', 'normes'])
        );
    }

    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);

        DB::table('affectations')->where('projet_id', $id)->delete();
        DB::table('projet_normes')->where('projet_id', $id)->delete();
        DB::table('suivi_chapitres')->where('projet_id', $id)->delete();
        DB::table('projet_formations')->where('projet_id', $id)->delete();

        $projet->delete();

        return redirect('/')->with('success', '✅ Projet supprimé avec succès!');
    }
}