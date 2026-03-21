<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PreuveController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'livrable_id' => 'required|integer',
            'projet_id'   => 'required|integer',
            'fichier'     => 'required|file|max:10240',
            'label'       => 'nullable|string|max:255'
        ]);

        try {
            $file         = $request->file('fichier');
            $originalName = $file->getClientOriginalName();
            $mimeType     = $file->getMimeType();
            $sizeKb       = round($file->getSize() / 1024);
            $filename     = time() . '_' . uniqid();

            $uploadedFile = Cloudinary::uploadApi()->upload(
    $file->getRealPath(),
    [
        'folder' => 'lmc/preuves',
        'public_id' => $filename,
        'resource_type' => 'auto',
    ]
);

$cloudinaryUrl = $uploadedFile['secure_url'];
$cloudinaryPublicId = $uploadedFile['public_id'];

            $id = DB::table('livrable_preuves')->insertGetId([
                'projet_id'    => $request->projet_id,
                'livrable_id'  => $request->livrable_id,
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
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], 500);
}
    }

    public function destroy($id)
    {
        try {
            $preuve = DB::table('livrable_preuves')->where('id', $id)->first();
            if (!$preuve) {
                return response()->json(['success' => false, 'message' => 'Preuve non trouvée'], 404);
            }

            if (str_starts_with($preuve->fichier_path, 'lmc/')) {
                Cloudinary::destroy($preuve->fichier_path, ['resource_type' => 'auto']);
            }

            DB::table('livrable_preuves')->where('id', $id)->delete();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}