<?php
// app/Http/Controllers/PreuveController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PreuveController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'livrable_id' => 'required|integer',
            'projet_id' => 'required|integer',
            'fichier' => 'required|file|max:10240',
            'label' => 'nullable|string|max:255'
        ]);

        $file = $request->file('fichier');
        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        $sizeKb = round($file->getSize() / 1024);

        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs('preuves', $filename, 'public');

        $id = DB::table('livrable_preuves')->insertGetId([
            'projet_id' => $request->projet_id,
            'livrable_id' => $request->livrable_id,
            'label' => $request->label,
            'fichier_nom' => $originalName,
            'fichier_path' => $filename,
            'mime_type' => $mimeType,
            'taille_kb' => $sizeKb,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'preuve' => [
                'id' => $id,
                'label' => $request->label,
                'fichier_nom' => $originalName,
                'mime_type' => $mimeType,
                'taille_kb' => $sizeKb,
                'url' => asset('storage/preuves/' . $filename)
            ]
        ]);
    }

    public function destroy($id)
    {
        $preuve = DB::table('livrable_preuves')->where('id', $id)->first();
        if (!$preuve) {
            return response()->json(['success' => false, 'message' => 'Preuve non trouvée'], 404);
        }

        Storage::disk('public')->delete('preuves/' . $preuve->fichier_path);
        DB::table('livrable_preuves')->where('id', $id)->delete();

        return response()->json(['success' => true]);
    }
}