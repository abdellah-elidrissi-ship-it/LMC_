<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProjetPreuveController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'projet_id' => 'required|integer|exists:projets,id',
            'fichier'   => 'required|file|max:10240',
            'label'     => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file         = $request->file('fichier');
            $originalName = $file->getClientOriginalName();
            $mimeType     = $file->getMimeType();
            $sizeKb       = round($file->getSize() / 1024);
            $filename     = time() . '_' . uniqid();

            $uploadedFile = Cloudinary::uploadApi()->upload(
                $file->getRealPath(),
                [
                    'folder' => 'lmc/preuves_projet',
                    'public_id' => $filename,
                    'resource_type' => 'auto'
                ]
            );

            $cloudinaryUrl = $uploadedFile['secure_url'];

            $id = DB::table('projet_preuves')->insertGetId([
                'projet_id'    => $request->projet_id,
                'label'        => $request->label,
                'fichier_nom'  => $originalName,
                'fichier_path' => $cloudinaryUrl,
                'mime_type'    => $mimeType,
                'taille_kb'    => $sizeKb,
                'created_at'   => now(),
                'updated_at'   => now()
            ]);

            return response()->json([
                'success' => true,
                'preuve'  => [
                    'id'          => $id,
                    'label'       => $request->label,
                    'fichier_nom' => $originalName,
                    'mime_type'   => $mimeType,
                    'taille_kb'   => $sizeKb,
                    'url'         => $cloudinaryUrl
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
                    'message' => 'Preuve non trouvée'
                ], 404);
            }

            DB::table('projet_preuves')->where('id', $id)->delete();

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
                'preuves' => $preuves
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}