<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProjetPreuveController extends Controller
{
    public function upload(Request $request)
    {
        try {
            Log::info('Upload projet preuve - début', $request->all());

            $validator = Validator::make($request->all(), [
                'projet_id' => 'required|integer|exists:projets,id',
                'fichier'   => 'required|file|max:10240',
                'label'     => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $file = $request->file('fichier');
            $originalName = $file->getClientOriginalName();
            $sizeKb = round($file->getSize() / 1024, 2);
            $mimeType = $file->getMimeType();

            $fileName = time() . '_' . uniqid();

            $resourceType = $mimeType === 'application/pdf' ? 'raw' : 'auto';

            $uploadedFile = Cloudinary::uploadApi()->upload(
                $file->getRealPath(),
                [
                    'folder' => 'lmc/preuves_projet',
                    'public_id' => $fileName,
                    'resource_type' => $resourceType,
                ]
            );

            $cloudinaryUrl = $uploadedFile['secure_url'];

            $id = DB::table('projet_preuves')->insertGetId([
                'projet_id'    => $request->projet_id,
                'label'        => $request->label ?? '',
                'fichier_nom'  => $originalName,
                'fichier_path' => $cloudinaryUrl,
                'mime_type'    => $mimeType,
                'taille_kb'    => $sizeKb,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            Log::info('Upload projet preuve - succès', ['id' => $id]);

            return response()->json([
                'success' => true,
                'preuve'  => [
                    'id'          => $id,
                    'label'       => $request->label ?? '',
                    'fichier_nom' => $originalName,
                    'mime_type'   => $mimeType,
                    'taille_kb'   => $sizeKb,
                    'url'         => $cloudinaryUrl,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Upload projet preuve - erreur', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
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
            $preuve = DB::table('projet_preuves')->where('id', $id)->first();

            if (!$preuve) {
                return response()->json([
                    'success' => false,
                    'message' => 'Preuve non trouvée',
                ], 404);
            }

            DB::table('projet_preuves')->where('id', $id)->delete();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Delete projet preuve - erreur', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function index($projetId)
    {
        try {
            $preuves = DB::table('projet_preuves')
                ->where('projet_id', $projetId)
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($preuves as $preuve) {
                $preuve->url = $preuve->fichier_path;
            }

            return response()->json([
                'success' => true,
                'preuves' => $preuves,
            ]);

        } catch (\Exception $e) {
            Log::error('Index projet preuve - erreur', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}