<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjetPreuveController extends Controller
{
    /**
     * Upload d'une nouvelle preuve pour le projet
     */
    public function upload(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'projet_id' => 'required|integer|exists:projets,id',
            'fichier' => 'required|file|max:10240', // 10 MB max
            'label' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('fichier');
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $sizeKb = round($file->getSize() / 1024);
            $extension = $file->getClientOriginalExtension();

            // Générer un nom unique pour le fichier
            $filename = time() . '_' . uniqid() . '.' . $extension;
            
            // Stocker le fichier dans le dossier 'preuves_projet'
            $path = $file->storeAs('preuves_projet', $filename, 'public');

            // Insérer dans la base de données
            $id = DB::table('projet_preuves')->insertGetId([
                'projet_id' => $request->projet_id,
                'label' => $request->label,
                'fichier_nom' => $originalName,
                'fichier_path' => $filename,
                'mime_type' => $mimeType,
                'taille_kb' => $sizeKb,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Retourner les données de la preuve créée
            return response()->json([
                'success' => true,
                'preuve' => [
                    'id' => $id,
                    'label' => $request->label,
                    'fichier_nom' => $originalName,
                    'mime_type' => $mimeType,
                    'taille_kb' => $sizeKb,
                    'url' => asset('storage/preuves_projet/' . $filename)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'upload : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une preuve du projet
     */
    public function destroy($id)
    {
        try {
            // Récupérer la preuve
            $preuve = DB::table('projet_preuves')->where('id', $id)->first();

            if (!$preuve) {
                return response()->json([
                    'success' => false,
                    'message' => 'Preuve non trouvée'
                ], 404);
            }

            // Vérifier les permissions (optionnel)
            // if (!auth()->user()->hasPermission('modifier_projets')) {
            //     return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
            // }

            // Supprimer le fichier physique
            if (Storage::disk('public')->exists('preuves_projet/' . $preuve->fichier_path)) {
                Storage::disk('public')->delete('preuves_projet/' . $preuve->fichier_path);
            }

            // Supprimer de la base de données
            DB::table('projet_preuves')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Preuve supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupérer toutes les preuves d'un projet
     */
    public function index($projetId)
    {
        try {
            $preuves = DB::table('projet_preuves')
                ->where('projet_id', $projetId)
                ->orderBy('created_at', 'desc')
                ->get();

            // Ajouter l'URL complète pour chaque preuve
            foreach ($preuves as $preuve) {
                $preuve->url = asset('storage/preuves_projet/' . $preuve->fichier_path);
            }

            return response()->json([
                'success' => true,
                'preuves' => $preuves
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Télécharger une preuve
     */
    public function download($id)
    {
        try {
            $preuve = DB::table('projet_preuves')->where('id', $id)->first();

            if (!$preuve) {
                abort(404, 'Preuve non trouvée');
            }

            $path = storage_path('app/public/preuves_projet/' . $preuve->fichier_path);

            if (!file_exists($path)) {
                abort(404, 'Fichier non trouvé');
            }

            return response()->download($path, $preuve->fichier_nom);

        } catch (\Exception $e) {
            abort(500, 'Erreur lors du téléchargement');
        }
    }

    /**
     * Mettre à jour le label d'une preuve
     */
    public function updateLabel(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::table('projet_preuves')
                ->where('id', $id)
                ->update([
                    'label' => $request->label,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Label mis à jour'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage()
            ], 500);
        }
    }
}