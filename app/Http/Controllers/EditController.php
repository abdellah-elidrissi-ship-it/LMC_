<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Client;
use App\Models\Consultant;
use App\Models\Affectation;
use App\Models\SuiviChapitre;
use App\Models\ProjetFormation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditController extends Controller
{
    /**
     * Afficher les détails d'un projet
     */
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

        return view('details-projet', compact('projet'));
    }

    public function edit($id)
    {
        $projet = Projet::with([
            'client',
            'chefProjet',
            'normes',
            'affectations.consultant',
            'suiviChapitres.chapitre',
            'formations'
        ])->findOrFail($id);

        $clients     = Client::orderBy('nom_client')->get();
        $consultants = Consultant::where('actif', true)->orderBy('nom_complet')->get();
        $normes      = DB::table('normes')->orderBy('code_norme')->get();
        $chapitres   = DB::table('chapitres_smis')->orderBy('ordre')->get();
        $formations  = DB::table('formations')->orderBy('titre_formation')->get();

        $secteurs = [
            'Industrie',
            'BTP & Construction',
            'Agroalimentaire',
            'Santé & Pharmaceutique',
            'Services',
            'Commerce & Distribution',
            'Transport & Logistique',
            'Énergie',
            'Environnement',
            'Autre'
        ];

        return view('edit-projet', compact(
            'projet',
            'clients',
            'consultants',
            'normes',
            'chapitres',
            'formations',
            'secteurs'
        ));
    }

    public function update(Request $request, $id)
{
    $projet = Projet::findOrFail($id);

    $request->validate([
        'reference_projet'   => 'required|unique:projets,reference_projet,' . $id,
        'client_nom'         => 'required|string|max:255',
        'chef_projet_id'     => 'required|exists:consultants,id',
        'statut'             => 'required|in:Planifié,En cours,En retard,Finalisé',
        'type_projet'        => 'required|string',
        'jours_prevus'       => 'required|integer|min:0',
        'date_debut'         => 'nullable|date',
        'date_fin_prevue'    => 'nullable|date',
        'date_fin_reelle'    => 'nullable|date',
        'blocage'            => 'nullable|string',
        'commentaire'        => 'nullable|string',
        'secteur_activite'   => 'nullable|string|max:100',
        'normes'             => 'array',

        'custom_formations'                    => 'nullable|array',
        'custom_formations.*.titre'            => 'required_with:custom_formations|string',
        'custom_formations.*.statut'           => 'nullable|string',
        'custom_formations.*.jours'            => 'nullable|numeric|min:0',
        'custom_formations.*.date_realisation' => 'nullable|date',
        'custom_formations.*.observations'     => 'nullable|string',
        'custom_formations.*.id_original'      => 'nullable|integer'
    ]);

    DB::beginTransaction();

    try {
        // ===== CLIENT =====
        $client = Client::find($projet->client_id);
        if ($client) {
            $updateData = ['nom_client' => $request->client_nom];
            if ($request->filled('secteur_activite')) {
                $updateData['secteur_activite'] = $request->secteur_activite;
            }
            $client->update($updateData);
        } else {
            $client = Client::create([
                'nom_client'       => $request->client_nom,
                'secteur_activite' => $request->secteur_activite,
            ]);
        }

        // ===== PROJET (SANS CALCULS) =====
        $projet->update([
            'reference_projet'   => $request->reference_projet,
            'client_id'          => $client->id,
            'chef_projet_id'     => $request->chef_projet_id,
            'type_projet'        => $request->type_projet,
            'statut'             => $request->statut,
            'jours_prevus'       => $request->jours_prevus,
            'jours_realises'     => 0, // sera recalculé
            'avancement_percent' => 0, // sera recalculé
            'blocage'            => $request->blocage ?? '',
            'commentaire'        => $request->commentaire ?? '',
            'date_debut'         => $request->date_debut,
            'date_fin_prevue'    => $request->date_fin_prevue,
            'date_fin_reelle'    => $request->date_fin_reelle,
        ]);

        // ===== NORMES =====
        $projet->normes()->sync($request->normes ?? []);

        // ===== CONSULTANTS =====
        if ($request->has('deleted_consultants')) {
            Affectation::whereIn('consultant_id', $request->deleted_consultants)
                ->where('projet_id', $projet->id)
                ->delete();
        }

        if ($request->has('consultants')) {
            foreach ($request->consultants as $consData) {
                if (!empty($consData['id']) && is_numeric($consData['id'])) {
                    Affectation::updateOrCreate(
                        ['projet_id' => $projet->id, 'consultant_id' => $consData['id']],
                        [
                            'role_dans_projet' => $consData['role'] ?? 'Consultant',
                            'jours_alloues'    => $consData['jours_alloues'] ?? 0,
                            'jours_realises'   => $consData['jours_realises'] ?? 0,
                        ]
                    );
                }
            }
        }

        // ===== CHAPITRES =====
        if ($request->has('chapitres')) {
            foreach ($request->chapitres as $chapData) {
                if (!empty($chapData['id']) && is_numeric($chapData['id'])) {
                    SuiviChapitre::where('id', $chapData['id'])
                        ->where('projet_id', $projet->id)
                        ->update([
                            'avancement_percent' => $chapData['avancement'] ?? 0,
                            'phase'              => $chapData['phase'] ?? '⬜ Non démarré',
                            'jours_intervention' => $chapData['jours'] ?? 0,
                            'statut_livrables'   => $chapData['livrables'] ?? null,
                            'observations'       => $chapData['observations'] ?? null,
                        ]);
                }
            }
        }

        // ===== FORMATIONS =====
        if ($request->has('custom_formations')) {
            DB::table('projet_formations')
                ->where('projet_id', $projet->id)
                ->delete();

            foreach ($request->custom_formations as $formationData) {
                if (empty($formationData['titre'])) continue;

                if (!empty($formationData['id_original'])) {
                    $formation = \App\Models\Formation::find($formationData['id_original']);
                    if ($formation) {
                        $formation->update(['titre_formation' => $formationData['titre']]);
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
                    'projet_id'        => $projet->id,
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

        // ===== LIVRABLES =====
        if ($request->has('livrables')) {
            $now = now();
            $upserts = [];

            foreach ($request->livrables as $livrableId => $statut) {
                if (!in_array($statut, ['Non commencé', 'En cours', 'Terminé'])) continue;

                $upserts[] = [
                    'projet_id'   => $projet->id,
                    'livrable_id' => (int)$livrableId,
                    'statut'      => $statut,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }

            if (!empty($upserts)) {
                DB::table('projet_livrables')->upsert(
                    $upserts,
                    ['projet_id', 'livrable_id'],
                    ['statut', 'updated_at']
                );
            }
        }

        // ===== CALCUL FINAL GLOBAL =====

        // Jours réalisés
        $joursChapitres = DB::table('suivi_chapitres')
            ->where('projet_id', $projet->id)
            ->sum('jours_intervention');

        $joursFormations = DB::table('projet_formations')
            ->where('projet_id', $projet->id)
            ->sum('jours_realises');

        $totalJours = $joursChapitres + $joursFormations;

        // Avancement
        $totalLivrables = DB::table('projet_livrables')
            ->where('projet_id', $projet->id)
            ->count();

        $livrablesTermines = DB::table('projet_livrables')
            ->where('projet_id', $projet->id)
            ->where('statut', 'Terminé')
            ->count();

        $avancement = $totalLivrables > 0
            ? round(($livrablesTermines / $totalLivrables) * 100)
            : 0;

        // Update final
        $projet->update([
            'jours_realises'     => $totalJours,
            'avancement_percent' => $avancement
        ]);

        DB::commit();

        return redirect()->route('projet.details', $id)
            ->with('success', '✅ Projet mis à jour avec succès!');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Erreur update projet: ' . $e->getMessage());

        return back()->with('error', '❌ Erreur: ' . $e->getMessage())->withInput();
    }
}

    public function destroy($id)
    {
        $projet   = Projet::findOrFail($id);
        $clientId = $projet->client_id;

        DB::table('affectations')->where('projet_id', $id)->delete();
        DB::table('projet_normes')->where('projet_id', $id)->delete();
        DB::table('suivi_chapitres')->where('projet_id', $id)->delete();
        DB::table('projet_formations')->where('projet_id', $id)->delete();
        DB::table('projet_livrables')->where('projet_id', $id)->delete();

        $projet->delete();

        $clientUsedElsewhere = DB::table('projets')->where('client_id', $clientId)->count();
        if ($clientUsedElsewhere === 0) {
            DB::table('clients')->where('id', $clientId)->delete();
        }

        return redirect('/')->with('success', '✅ Projet et client supprimés avec succès!');
    }
}
