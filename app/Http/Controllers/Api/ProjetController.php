<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Projet;
use Illuminate\Http\Request;
use App\Services\LivrablesSMI;

class ProjetController extends Controller
{
    /**
     * Page principale — liste des projets (WEB)
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
                $query->whereRaw('1 = 0');
            }
        }

        $projets = $query->orderBy('reference_projet')->get();
        return view('projets', compact('projets'));
    }

    // ──────────────────────────────────────────────────────────────
    // store() — Nouveau projet
    // ──────────────────────────────────────────────────────────────
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

        // ── Livrables SMI ──
        $this->saveLivrables($request, $projet->id);

        return redirect()
            ->route('projet.details', $projet->id)
            ->with('success', '✅ Projet créé avec succès.');
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

    // ──────────────────────────────────────────────────────────────
    // update() — Modifier projet (depuis edit-projet.blade)
    // ──────────────────────────────────────────────────────────────
    public function update(Request $request, $id)
{
    $projet = Projet::findOrFail($id);

    $validated = $request->validate([
        'client_id'          => 'sometimes|exists:clients,id',
        'chef_projet_id'     => 'sometimes|exists:consultants,id',
        'type_projet'        => 'sometimes|string',
        'statut'             => 'sometimes|in:Finalisé,En cours,Planifié,En retard,En pause',
        'jours_prevus'       => 'sometimes|integer',
        'jours_realises'     => 'sometimes|numeric',
        'avancement_percent' => 'sometimes|integer|min:0|max:100',
        'blocage'            => 'nullable|string',
        'commentaire'        => 'nullable|string',
        'date_debut'         => 'nullable|date',
        'date_fin_prevue'    => 'nullable|date',
        'date_fin_reelle'    => 'nullable|date',
        'normes'             => 'sometimes|array',
        'custom_formations'                    => 'nullable|array',
        'custom_formations.*.titre'            => 'required_with:custom_formations|string',
        'custom_formations.*.statut'           => 'nullable|string',
        'custom_formations.*.jours'            => 'nullable|numeric|min:0',
        'custom_formations.*.date_realisation' => 'nullable|date',
        'custom_formations.*.observations'     => 'nullable|string',
        'custom_formations.*.id_original'      => 'nullable|integer',
    ]);

    $projet->update($validated);

    if ($request->has('normes')) {
        $projet->normes()->sync($request->normes);
    }

    $this->saveLivrables($request, $id);

    // ===== FORMATIONS =====
    if ($request->has('custom_formations')) {
        DB::table('projet_formations')->where('projet_id', $id)->delete();

        foreach ($request->custom_formations as $formationData) {
            if (empty($formationData['titre'])) {
                continue;
            }

            if (!empty($formationData['id_original'])) {
                $formation = \App\Models\Formation::find($formationData['id_original']);

                if ($formation) {
                    $formation->update([
                        'titre_formation' => $formationData['titre'],
                    ]);
                } else {
                    $formation = \App\Models\Formation::create([
                        'titre_formation' => $formationData['titre'],
                        'description' => null,
                    ]);
                }
            } else {
                $formation = \App\Models\Formation::create([
                    'titre_formation' => $formationData['titre'],
                    'description' => null,
                ]);
            }

            DB::table('projet_formations')->insert([
                'projet_id'        => $id,
                'formation_id'     => $formation->id,
                'statut'           => $formationData['statut'] ?? 'À planifier',
                'observations'     => $formationData['observations'] ?? null,
                'jours_realises'   => $formationData['jours'] ?? 0,
                'date_realisation' => $formationData['date_realisation'] ?? null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }

    if ($request->expectsJson()) {
        return response()->json(
            $projet->load(['client', 'chefProjet', 'normes', 'formations'])
        );
    }

    return redirect()
        ->route('projet.details', $id)
        ->with('success', '✅ Projet mis à jour avec succès.');
}

    public function destroy($id)
    {

    dd('ANA HNA F UPDATE API CONTROLLER');
        $projet = Projet::findOrFail($id);

        DB::table('affectations')->where('projet_id', $id)->delete();
        DB::table('projet_normes')->where('projet_id', $id)->delete();
        DB::table('suivi_chapitres')->where('projet_id', $id)->delete();
        DB::table('projet_formations')->where('projet_id', $id)->delete();
        DB::table('projet_livrables')->where('projet_id', $id)->delete();

        $projet->delete();

        return redirect('/')->with('success', '✅ Projet supprimé avec succès!');
    }

    // ──────────────────────────────────────────────────────────────
    // saveLivrables() — méthode privée réutilisée par store + update
    // ──────────────────────────────────────────────────────────────
    private function saveLivrables(Request $request, $projetId): void
    {
        if (!$request->has('livrables')) return;

        $now     = now();
        $upserts = [];

        foreach ($request->livrables as $livrableId => $statut) {
            if (!in_array($statut, ['Non commencé', 'En cours', 'Terminé'])) continue;

            $upserts[] = [
                'projet_id'   => $projetId,
                'livrable_id' => (int) $livrableId,
                'statut'      => $statut,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        if (!empty($upserts)) {
            DB::table('projet_livrables')->upsert(
                $upserts,
                ['projet_id', 'livrable_id'],   // clé unique
                ['statut', 'updated_at']          // colonnes à mettre à jour
            );
        }
    }
}