<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Client;
use App\Models\Consultant;
use App\Models\Projet;
use App\Models\Sensibilisation;
use App\Models\SuiviChapitre;
use App\Services\AffectationChargeService;
use App\Services\ProjetAccessNotifier;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EditController extends Controller
{
    /**
     * Afficher les détails d'un projet.
     */
    public function show($id)
    {
        $projet = Projet::with([
            'client',
            'chefProjet',
            'normes',
            'affectations.consultant',
            'suiviChapitres.chapitre',
            'formations',
            'sensibilisations',
        ])->findOrFail($id);

        return view('details-projet', compact('projet'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit($id)
    {
        $projet = Projet::with([
            'client',
            'chefProjet',
            'normes',
            'affectations.consultant',
            'suiviChapitres.chapitre',
            'formations',
            'sensibilisations',
        ])->findOrFail($id);

        $clients = Client::orderBy('nom_client')->get();

        $consultants = Consultant::where('actif', true)
            ->orderBy('nom_complet')
            ->get();

        $normes = DB::table('normes')
            ->orderBy('code_norme')
            ->get();

        $chapitres = DB::table('chapitres_smis')
            ->orderBy('ordre')
            ->get();

        $formations = DB::table('formations')
            ->orderBy('titre_formation')
            ->get();

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
            'Autre',
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

    /**
     * Mettre à jour le projet.
     */
    public function update(Request $request, $id)
    {
        $projet = Projet::with('client')->findOrFail($id);

        $request->validate([
            'reference_projet' => [
                'required',
                'string',
                'max:255',
                'unique:projets,reference_projet,' . $id,
            ],

            'client_nom' => [
                'required',
                'string',
                'max:255',
            ],

            'client_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'chef_projet_id' => [
                'required',
                'exists:consultants,id',
            ],

            'statut' => [
                'required',
                'in:Planifié,En cours,En retard,Finalisé',
            ],

            'type_projet' => [
                'required',
                'string',
                'max:255',
            ],

            'jours_prevus' => [
                'required',
                'integer',
                'min:0',
            ],

            'jours_realises' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'date_debut' => [
                'nullable',
                'date',
            ],

            'date_fin_prevue' => [
                'nullable',
                'date',
            ],

            'date_fin_reelle' => [
                'nullable',
                'date',
            ],

            'blocage' => [
                'nullable',
                'string',
            ],

            'commentaire' => [
                'nullable',
                'string',
            ],

            'secteur_activite' => [
                'nullable',
                'string',
                'max:100',
            ],

            'normes' => [
                'nullable',
                'array',
            ],

            'normes.*' => [
                'integer',
                'exists:normes,id',
            ],

            'custom_formations' => [
                'nullable',
                'array',
            ],

            'custom_formations.*.titre' => [
                'required_with:custom_formations',
                'string',
                'max:255',
            ],

            'custom_formations.*.statut' => [
                'nullable',
                'string',
                'max:100',
            ],

            'custom_formations.*.jours' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'custom_formations.*.date_realisation' => [
                'nullable',
                'date',
            ],

            'custom_formations.*.observations' => [
                'nullable',
                'string',
            ],

            'custom_formations.*.id_original' => [
                'nullable',
                'integer',
            ],
        ]);

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | CLIENT
            |--------------------------------------------------------------------------
            */

            $client = $projet->client;

            if (!$client) {
                $client = new Client();
            }

            $client->nom_client = $request->client_nom;
            $client->secteur_activite = $request->secteur_activite;

            /*
            |--------------------------------------------------------------------------
            | MODIFICATION DU LOGO CLIENT SUR CLOUDINARY
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('client_logo')) {
                $file = $request->file('client_logo');

                $publicId = 'client_' .
                    Str::slug($request->client_nom) .
                    '_' .
                    now()->format('YmdHis');

                $uploadedLogo = Cloudinary::uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder' => 'lmc/clients/logos',
                        'public_id' => $publicId,
                        'resource_type' => 'image',
                        'overwrite' => true,
                        'invalidate' => true,
                    ]
                );

                $secureUrl = $uploadedLogo['secure_url'] ?? null;

                if (!$secureUrl) {
                    throw new \RuntimeException(
                        'Cloudinary n’a pas retourné de lien sécurisé pour le logo.'
                    );
                }

                $client->logo_path = $secureUrl;
            }

            /*
             * Si aucun nouveau logo n'est sélectionné,
             * logo_path n'est pas modifié.
             */

            $client->save();

            /*
            |--------------------------------------------------------------------------
            | PROJET
            |--------------------------------------------------------------------------
            */

            $ancienChefProjetId = $projet->chef_projet_id;

            $projet->update([
                'reference_projet' => $request->reference_projet,
                'client_id' => $client->id,
                'chef_projet_id' => $request->chef_projet_id,
                'type_projet' => $request->type_projet,
                'statut' => $request->statut,
                'jours_prevus' => $request->jours_prevus,

                // Jours réalisés : saisi manuellement désormais (n'est plus recalculé
                // depuis chapitres/formations, voir recalculerAvancement() plus bas).
                'jours_realises' => $request->jours_realises ?? 0,

                // Recalculé à la fin (voir recalculerAvancement() plus bas).
                'avancement_percent' => 0,

                'blocage' => $request->blocage ?? '',
                'commentaire' => $request->commentaire ?? '',
                'date_debut' => $request->date_debut,
                'date_fin_prevue' => $request->date_fin_prevue,
                'date_fin_reelle' => $request->date_fin_reelle,
            ]);

            if ($ancienChefProjetId != $request->chef_projet_id) {
                if ($ancienChefProjetId) {
                    ProjetAccessNotifier::notifierRetrait(
                        projet: $projet,
                        retirePar: auth()->user(),
                        consultant: Consultant::find($ancienChefProjetId)
                    );
                }

                ProjetAccessNotifier::notifierAjout(
                    projet: $projet,
                    assignePar: auth()->user(),
                    consultant: Consultant::find($request->chef_projet_id),
                    role: 'Chef de projet'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | NORMES
            |--------------------------------------------------------------------------
            */

            $projet->normes()->sync($request->normes ?? []);

            /*
            |--------------------------------------------------------------------------
            | CONSULTANTS SUPPRIMÉS
            |--------------------------------------------------------------------------
            */

            if ($request->filled('deleted_consultants')) {
                $consultantsRetires = Consultant::whereIn(
                    'id',
                    $request->input('deleted_consultants', [])
                )->get();

                Affectation::where('projet_id', $projet->id)
                    ->whereIn(
                        'consultant_id',
                        $request->input('deleted_consultants', [])
                    )
                    ->delete();

                foreach ($consultantsRetires as $consultantRetire) {
                    ProjetAccessNotifier::notifierRetrait(
                        projet: $projet,
                        retirePar: auth()->user(),
                        consultant: $consultantRetire
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | CONSULTANTS AJOUTÉS OU MODIFIÉS
            |--------------------------------------------------------------------------
            */

            if ($request->filled('consultants')) {
                foreach ($request->input('consultants', []) as $consData) {
                    $consultantId = $consData['id'] ?? null;

                    if (!$consultantId || !is_numeric($consultantId)) {
                        continue;
                    }

                    $affectation = Affectation::updateOrCreate(
                        [
                            'projet_id' => $projet->id,
                            'consultant_id' => (int) $consultantId,
                        ],
                        [
                            'role_dans_projet' =>
                                $consData['role'] ?? 'Consultant',

                            'jours_alloues' =>
                                $consData['jours_alloues'] ?? 0,

                            // jours_realises n'est plus saisi manuellement — recalculé
                            // ci-dessous depuis les tâches Gantt (App\Services\AffectationChargeService).
                        ]
                    );

                    if ($affectation->wasRecentlyCreated) {
                        ProjetAccessNotifier::notifierAjout(
                            projet: $projet,
                            assignePar: auth()->user(),
                            consultant: Consultant::find($consultantId),
                            role: $consData['role'] ?? 'Consultant'
                        );
                    }
                }

                AffectationChargeService::recalculerPourProjet($projet->id);
            }

            /*
            |--------------------------------------------------------------------------
            | CHAPITRES
            |--------------------------------------------------------------------------
            */

            if ($request->filled('chapitres')) {
                foreach ($request->input('chapitres', []) as $chapData) {
                    $chapitreSuiviId = $chapData['id'] ?? null;

                    if (
                        !$chapitreSuiviId ||
                        !is_numeric($chapitreSuiviId)
                    ) {
                        continue;
                    }

                    SuiviChapitre::where('id', $chapitreSuiviId)
                        ->where('projet_id', $projet->id)
                        ->update([
                            'avancement_percent' =>
                                $chapData['avancement'] ?? 0,

                            'phase' =>
                                $chapData['phase'] ?? '⬜ Non démarré',

                            'jours_intervention' =>
                                $chapData['jours'] ?? 0,

                            'statut_livrables' =>
                                $chapData['livrables'] ?? null,

                            'observations' =>
                                $chapData['observations'] ?? null,
                        ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | FORMATIONS
            |--------------------------------------------------------------------------
            */

            if ($request->has('custom_formations')) {
                DB::table('projet_formations')
                    ->where('projet_id', $projet->id)
                    ->delete();

                foreach (
                    $request->input('custom_formations', [])
                    as $formationData
                ) {
                    $titre = trim($formationData['titre'] ?? '');

                    if ($titre === '') {
                        continue;
                    }

                    $formation = null;

                    if (!empty($formationData['id_original'])) {
                        $formation = \App\Models\Formation::find(
                            $formationData['id_original']
                        );
                    }

                    if ($formation) {
                        $formation->update([
                            'titre_formation' => $titre,
                        ]);
                    } else {
                        $formation = \App\Models\Formation::create([
                            'titre_formation' => $titre,
                            'description' => null,
                        ]);
                    }

                    DB::table('projet_formations')->insert([
                        'projet_id' => $projet->id,
                        'formation_id' => $formation->id,
                        'statut' =>
                            $formationData['statut'] ?? 'À planifier',

                        'observations' =>
                            $formationData['observations'] ?? null,

                        'jours_realises' =>
                            $formationData['jours'] ?? 0,

                        'date_realisation' =>
                            $formationData['date_realisation'] ?? null,

                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | SENSIBILISATION
            |--------------------------------------------------------------------------
            */

            if ($request->has('sensibilisations')) {
                Sensibilisation::where('projet_id', $projet->id)->delete();

                foreach ($request->input('sensibilisations', []) as $index => $sensData) {
                    $theme = trim($sensData['theme'] ?? '');

                    if ($theme === '') {
                        continue;
                    }

                    $photoPath = $sensData['existing_photo_path'] ?? null;

                    if ($request->hasFile("sensibilisations.$index.photo")) {
                        $photoFile = $request->file("sensibilisations.$index.photo");

                        $publicId = 'sensibilisation_' .
                            Str::slug($theme) .
                            '_' .
                            now()->format('YmdHis') .
                            '_' .
                            $index;

                        $uploadedPhoto = Cloudinary::uploadApi()->upload(
                            $photoFile->getRealPath(),
                            [
                                'folder' => 'lmc/sensibilisations',
                                'public_id' => $publicId,
                                'resource_type' => 'image',
                                'overwrite' => true,
                                'invalidate' => true,
                            ]
                        );

                        $photoPath = $uploadedPhoto['secure_url'];
                    }

                    Sensibilisation::create([
                        'projet_id' => $projet->id,
                        'theme' => $theme,
                        'photo_path' => $photoPath,
                        'jours_prevus' => $sensData['jours_prevus'] ?? 0,
                        'date_realisation' => $sensData['date_realisation'] ?? null,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | LIVRABLES
            |--------------------------------------------------------------------------
            */

            if ($request->filled('livrables')) {
                $now = now();
                $upserts = [];

                foreach (
                    $request->input('livrables', [])
                    as $livrableId => $statut
                ) {
                    if (
                        !in_array(
                            $statut,
                            ['Non commencé', 'En cours', 'Terminé'],
                            true
                        )
                    ) {
                        continue;
                    }

                    $upserts[] = [
                        'projet_id' => $projet->id,
                        'livrable_id' => (int) $livrableId,
                        'statut' => $statut,
                        'created_at' => $now,
                        'updated_at' => $now,
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

            /*
            |--------------------------------------------------------------------------
            | CALCUL FINAL DE L'AVANCEMENT (jours_realises est désormais manuel,
            | voir $projet->update() plus haut — ne plus appeler
            | recalculerJoursEtAvancement() qui l'écraserait avec chapitres+formations)
            |--------------------------------------------------------------------------
            */

            \App\Services\ProjetProgressService::recalculerAvancement($projet->id);

            DB::commit();

            $message = '✅ Projet mis à jour avec succès.';

            if ($request->hasFile('client_logo')) {
                $message .= ' Le logo du client a également été modifié.';
            }

            return redirect()
                ->route('projet.details', $id)
                ->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Erreur lors de la mise à jour du projet', [
                'projet_id' => $id,
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return back()
                ->with(
                    'error',
                    '❌ Erreur lors de la mise à jour : ' .
                    $e->getMessage()
                )
                ->withInput();
        }
    }

    /**
     * Supprimer un projet.
     */
    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);
        $clientId = $projet->client_id;

        DB::transaction(function () use ($id, $projet) {
            DB::table('affectations')
                ->where('projet_id', $id)
                ->delete();

            DB::table('projet_normes')
                ->where('projet_id', $id)
                ->delete();

            DB::table('suivi_chapitres')
                ->where('projet_id', $id)
                ->delete();

            DB::table('projet_formations')
                ->where('projet_id', $id)
                ->delete();

            DB::table('projet_livrables')
                ->where('projet_id', $id)
                ->delete();

            $projet->delete();
        });

        $clientUsedElsewhere = DB::table('projets')
            ->where('client_id', $clientId)
            ->exists();

        if (!$clientUsedElsewhere) {
            DB::table('clients')
                ->where('id', $clientId)
                ->delete();
        }

        return redirect('/')
            ->with(
                'success',
                '✅ Projet et client supprimés avec succès.'
            );
    }
}