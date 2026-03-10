<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Projet;
use App\Models\Client;
use App\Models\Consultant;
use App\Models\Affectation;
use App\Models\SuiviChapitre;
use App\Models\ProjetFormation;

class NouveauProjetController extends Controller
{
    public function create()
    {
        $consultants = Consultant::where('actif', true)
            ->orderBy('nom_complet')
            ->get();

        $normes     = DB::table('normes')->orderBy('code_norme')->get();
        $chapitres  = DB::table('chapitres_smis')->orderBy('ordre')->get();
        $formations = DB::table('formations')->orderBy('titre_formation')->get();
        
        // ✅ Secteurs d'activité pour le nouveau champ
        $secteurs = [
            'Industrie', 'BTP & Construction', 'Agroalimentaire',
            'Santé & Pharmaceutique', 'Services', 'Commerce & Distribution',
            'Transport & Logistique', 'Énergie', 'Environnement', 'Autre'
        ];

        $lastProjet = Projet::latest('id')->first();
        $newNum     = $lastProjet
            ? str_pad(intval(substr($lastProjet->reference_projet, 4)) + 1, 3, '0', STR_PAD_LEFT)
            : '001';
        $newReference = 'PRJ-' . $newNum;

        return view('nouveau-projet', compact(
            'consultants', 'normes', 'chapitres', 'formations', 'newReference', 'secteurs'
        ));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'reference_projet'   => 'required|unique:projets',
            'client_nom'         => 'required|string|max:255',
            'statut'             => 'required|in:Planifié,En cours,En retard,Finalisé',
            'type_projet'        => 'required|string',
            'jours_prevus'       => 'required|integer|min:0',
            'jours_realises'     => 'required|integer|min:0',
            'avancement_percent' => 'required|integer|min:0|max:100',
            'date_debut'         => 'nullable|date',
            'date_fin_prevue'    => 'nullable|date',
            'date_fin_reelle'    => 'nullable|date',
            'blocage'            => 'nullable|string',
            'commentaire'        => 'nullable|string',
            'secteur_activite'   => 'nullable|string|max:100',
            'normes'             => 'array',
            'consultants'        => 'array',
            'chapitres'          => 'array',
            'formations'         => 'array',
        ]);

        if (!$request->filled('chef_projet_id')) {
            return back()
                ->with('error', 'Veuillez sélectionner un chef de projet')
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // 1. Client
            $client = Client::firstOrCreate(
                ['nom_client' => $request->client_nom],
                ['secteur_activite' => $request->secteur_activite]
            );
            
            // ✅ Si client existant, mettre à jour secteur si fourni
            if ($request->filled('secteur_activite')) {
                $client->update(['secteur_activite' => $request->secteur_activite]);
            }

            // 2. Projet
            $projet = Projet::create([
                'reference_projet'   => $request->reference_projet,
                'client_id'          => $client->id,
                'chef_projet_id'     => $request->chef_projet_id,
                'type_projet'        => $request->type_projet,
                'statut'             => $request->statut,
                'jours_prevus'       => $request->jours_prevus,
                'jours_realises'     => $request->jours_realises,
                'avancement_percent' => $request->avancement_percent,
                'blocage'            => $request->blocage,
                'commentaire'        => $request->commentaire,
                'date_debut'         => $request->date_debut,
                'date_fin_prevue'    => $request->date_fin_prevue,
                'date_fin_reelle'    => $request->date_fin_reelle,
            ]);

            // 3. Normes
            if ($request->filled('normes')) {
                $projet->normes()->sync($request->normes);
            }

            // 4. Affectations
            if ($request->has('consultants')) {
                foreach ($request->consultants as $consData) {
                    if (!empty($consData['id'])) {
                        Affectation::create([
                            'projet_id'        => $projet->id,
                            'consultant_id'    => $consData['id'],
                            'role_dans_projet' => $consData['role'] ?? 'Consultant',
                            'jours_alloues'    => $consData['jours_alloues'] ?? 0,
                            'jours_realises'   => $consData['jours_realises'] ?? 0,
                        ]);
                    }
                }
            }

            // 5. Chapitres
            if ($request->has('chapitres')) {
                foreach ($request->chapitres as $chapData) {
                    if (!empty($chapData['chapitre_id'])) {
                        SuiviChapitre::create([
                            'projet_id'          => $projet->id,
                            'chapitre_id'        => $chapData['chapitre_id'],
                            'avancement_percent' => $chapData['avancement'] ?? 0,
                            'phase'              => $chapData['phase'] ?? '⬜ Non démarré',
                            'jours_intervention' => $chapData['jours'] ?? 0,
                            'statut_livrables'   => $chapData['livrables'] ?? null,
                            'observations'       => $chapData['observations'] ?? null,
                        ]);
                    }
                }
            }

            // 6. Formations
            if ($request->has('formations')) {
                foreach ($request->formations as $formData) {
                    if (!empty($formData['id'])) {
                        ProjetFormation::create([
                            'projet_id'    => $projet->id,
                            'formation_id' => $formData['id'],
                            'statut'       => $formData['statut'] ?? 'À planifier',
                            'observations' => $formData['observations'] ?? null,
                        ]);
                    }
                }
            }

            // 7. Nouveaux consultants
            if ($request->has('new_consultants')) {
                foreach ($request->new_consultants as $newCons) {
                    if (!empty($newCons['nom'])) {
                        $newConsultant = Consultant::create([
                            'nom_complet'     => $newCons['nom'],
                            'type_consultant' => 'Interne',
                            'actif'           => true,
                        ]);
                        Affectation::create([
                            'projet_id'        => $projet->id,
                            'consultant_id'    => $newConsultant->id,
                            'role_dans_projet' => $newCons['role'] ?? 'Consultant',
                            'jours_alloues'    => $newCons['jours_alloues'] ?? 0,
                            'jours_realises'   => $newCons['jours_realises'] ?? 0,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect('/')
                ->with('success', '✅ Projet créé avec succès! Référence: ' . $projet->reference_projet);

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', '❌ Erreur: ' . $e->getMessage())
                ->withInput();
        }
    }
}