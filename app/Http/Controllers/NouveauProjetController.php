<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Client;
use App\Models\Consultant;
use App\Models\Projet;
use App\Models\ProjetFormation;
use App\Models\Sensibilisation;
use App\Models\SuiviChapitre;
use App\Services\GanttTemplateService;
use App\Services\ProjetAccessNotifier;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NouveauProjetController extends Controller
{
    /**
     * Afficher le formulaire de création d'un projet.
     */
    public function create()
    {
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

        $lastProjet = Projet::latest('id')->first();

        $newNum = $lastProjet
            ? str_pad(
                intval(substr($lastProjet->reference_projet, 4)) + 1,
                3,
                '0',
                STR_PAD_LEFT
            )
            : '001';

        $newReference = 'PRJ-' . $newNum;

        return view('nouveau-projet', compact(
            'consultants',
            'normes',
            'chapitres',
            'formations',
            'newReference',
            'secteurs'
        ));
    }

    /**
     * Enregistrer un nouveau projet.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_projet' => [
                'required',
                'string',
                'max:255',
                'unique:projets,reference_projet',
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

            'statut' => [
                'required',
                'in:Planifié,En cours,En retard,Finalisé',
            ],

            'type_projet' => [
                'required',
                'string',
                'max:255',
            ],

            'chef_projet_id' => [
                'required',
                'integer',
                'exists:consultants,id',
            ],

            'jours_prevus' => [
                'required',
                'integer',
                'min:0',
            ],

            'jours_realises' => [
                'required',
                'integer',
                'min:0',
            ],

            'avancement_percent' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],

            'date_debut' => [
                'nullable',
                'date',
            ],

            'date_fin_prevue' => [
                'nullable',
                'date',
                'after_or_equal:date_debut',
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

            'consultants' => [
                'nullable',
                'array',
            ],

            'chapitres' => [
                'nullable',
                'array',
            ],

            'formations' => [
                'nullable',
                'array',
            ],

            'new_consultants' => [
                'nullable',
                'array',
            ],

            'sensibilisations' => [
                'nullable',
                'array',
            ],

            'sensibilisations.*.theme' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sensibilisations.*.photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | 1. Client
            |--------------------------------------------------------------------------
            */

            $clientName = trim($validated['client_nom']);

            $client = Client::whereRaw(
                'LOWER(nom_client) = ?',
                [mb_strtolower($clientName)]
            )->first();

            if (!$client) {
                $client = new Client();
                $client->nom_client = $clientName;
            }

            if ($request->filled('secteur_activite')) {
                $client->secteur_activite = $validated['secteur_activite'];
            }

            /*
            |--------------------------------------------------------------------------
            | Upload du logo client vers Cloudinary
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('client_logo')) {
                $file = $request->file('client_logo');

                $publicId = 'client_' .
                    str()->slug($clientName) .
                    '_' .
                    time();

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

                $client->logo_path = $uploadedLogo['secure_url'];
            }

            $client->save();

            /*
            |--------------------------------------------------------------------------
            | 2. Projet
            |--------------------------------------------------------------------------
            */

            $projet = Projet::create([
                'reference_projet' => $validated['reference_projet'],
                'client_id' => $client->id,
                'chef_projet_id' => $validated['chef_projet_id'],
                'type_projet' => $validated['type_projet'],
                'statut' => $validated['statut'],
                'jours_prevus' => $validated['jours_prevus'],
                'jours_realises' => $validated['jours_realises'],
                'avancement_percent' => $validated['avancement_percent'],
                'blocage' => $validated['blocage'] ?? null,
                'commentaire' => $validated['commentaire'] ?? null,
                'date_debut' => $validated['date_debut'] ?? null,
                'date_fin_prevue' => $validated['date_fin_prevue'] ?? null,
                'date_fin_reelle' => $validated['date_fin_reelle'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 2bis. Base standard des phases/tâches Gantt (SMI)
            |--------------------------------------------------------------------------
            */

            GanttTemplateService::creerPour($projet->id);

            $chefProjet = Consultant::find($validated['chef_projet_id']);
            if ($chefProjet) {
                ProjetAccessNotifier::notifierAjout(
                    projet: $projet,
                    assignePar: auth()->user(),
                    consultant: $chefProjet,
                    role: 'Chef de projet'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 3. Normes
            |--------------------------------------------------------------------------
            */

            if (!empty($validated['normes'])) {
                $projet->normes()->sync($validated['normes']);
            }

            /*
            |--------------------------------------------------------------------------
            | 4. Affectations consultants
            |--------------------------------------------------------------------------
            */

            if ($request->has('consultants')) {
                foreach ($request->input('consultants', []) as $consData) {
                    if (empty($consData['id'])) {
                        continue;
                    }

                    Affectation::create([
                        'projet_id' => $projet->id,
                        'consultant_id' => $consData['id'],
                        'role_dans_projet' => $consData['role'] ?? 'Consultant',
                        'jours_alloues' => $consData['jours_alloues'] ?? 0,
                        'jours_realises' => $consData['jours_realises'] ?? 0,
                    ]);

                    ProjetAccessNotifier::notifierAjout(
                        projet: $projet,
                        assignePar: auth()->user(),
                        consultant: Consultant::find($consData['id']),
                        role: $consData['role'] ?? 'Consultant'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 5. Suivi des chapitres
            |--------------------------------------------------------------------------
            */

            if ($request->has('chapitres')) {
                foreach ($request->input('chapitres', []) as $chapData) {
                    if (empty($chapData['chapitre_id'])) {
                        continue;
                    }

                    SuiviChapitre::create([
                        'projet_id' => $projet->id,
                        'chapitre_id' => $chapData['chapitre_id'],
                        'avancement_percent' => $chapData['avancement'] ?? 0,
                        'phase' => $chapData['phase'] ?? '⬜ Non démarré',
                        'jours_intervention' => $chapData['jours'] ?? 0,
                        'statut_livrables' => $chapData['livrables'] ?? null,
                        'observations' => $chapData['observations'] ?? null,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 6. Formations
            |--------------------------------------------------------------------------
            */

            if ($request->has('formations')) {
                foreach ($request->input('formations', []) as $formData) {
                    if (empty($formData['id'])) {
                        continue;
                    }

                    ProjetFormation::create([
                        'projet_id' => $projet->id,
                        'formation_id' => $formData['id'],
                        'statut' => $formData['statut'] ?? 'À planifier',
                        'observations' => $formData['observations'] ?? null,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 7. Nouveaux consultants
            |--------------------------------------------------------------------------
            */

            if ($request->has('new_consultants')) {
                foreach ($request->input('new_consultants', []) as $newCons) {
                    if (empty($newCons['nom'])) {
                        continue;
                    }

                    $newConsultant = Consultant::create([
                        'nom_complet' => trim($newCons['nom']),
                        'type_consultant' => 'Interne',
                        'actif' => true,
                    ]);

                    Affectation::create([
                        'projet_id' => $projet->id,
                        'consultant_id' => $newConsultant->id,
                        'role_dans_projet' => $newCons['role'] ?? 'Consultant',
                        'jours_alloues' => $newCons['jours_alloues'] ?? 0,
                        'jours_realises' => $newCons['jours_realises'] ?? 0,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 8. Sensibilisations
            |--------------------------------------------------------------------------
            */

            if ($request->has('sensibilisations')) {
                foreach ($request->input('sensibilisations', []) as $index => $sensData) {
                    $theme = trim($sensData['theme'] ?? '');

                    if ($theme === '') {
                        continue;
                    }

                    $photoPath = null;

                    if ($request->hasFile("sensibilisations.$index.photo")) {
                        $photoFile = $request->file("sensibilisations.$index.photo");

                        $publicId = 'sensibilisation_' .
                            str()->slug($theme) .
                            '_' .
                            time() .
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
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('projets.index')
                ->with(
                    'success',
                    'Projet créé avec succès. Référence : ' .
                    $projet->reference_projet
                );
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Erreur création projet', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Erreur lors de la création du projet : ' .
                    $e->getMessage()
                );
        }
    }
}