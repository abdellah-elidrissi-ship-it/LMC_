<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PreuveController extends Controller
{
    public function upload(Request $request)
    {
        try {
            Log::info('Upload preuve - début', $request->all());

            $request->validate([
                'livrable_id' => 'required|integer',
                'projet_id'   => 'required|integer',
                'fichier'     => 'required|file|max:10240',
                'label'       => 'nullable|string|max:255',
            ]);

            $file = $request->file('fichier');
            $originalName = $file->getClientOriginalName();
            $sizeKb = round($file->getSize() / 1024, 2);
            $mimeType = $file->getMimeType();

            $fileName = time() . '_' . uniqid();

            $uploadedFile = Cloudinary::uploadApi()->upload(
                $file->getRealPath(),
                [
                    'folder' => 'lmc/preuves_livrables',
                    'public_id' => $fileName,
                    'resource_type' => 'raw',
                ]
            );

            $cloudinaryUrl = $uploadedFile['secure_url'];

            $id = DB::table('livrable_preuves')->insertGetId([
                'projet_id'    => $request->projet_id,
                'livrable_id'  => $request->livrable_id,
                'label'        => $request->label ?? '',
                'fichier_nom'  => $originalName,
                'fichier_path' => $cloudinaryUrl,
                'mime_type'    => $mimeType,
                'taille_kb'    => $sizeKb,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            Log::info('Upload preuve - succès', ['id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Preuve ajoutée avec succès',
                'preuve'  => [
                    'id'          => $id,
                    'label'       => $request->label ?? '',
                    'fichier_nom' => $originalName,
                    'mime_type'   => $mimeType,
                    'taille_kb'   => $sizeKb,
                    'url'         => $cloudinaryUrl,
                ],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Upload preuve - erreur', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $preuve = DB::table('livrable_preuves')->where('id', $id)->first();

            if (!$preuve) {
                return response()->json([
                    'success' => false,
                    'message' => 'Preuve non trouvée',
                ], 404);
            }

            DB::table('livrable_preuves')->where('id', $id)->delete();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Delete preuve - erreur', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}