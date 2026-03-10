<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Norme;
use Illuminate\Http\Request;

class NormeController extends Controller
{
    public function index()
    {
        $normes = Norme::with('projets')->get();
        return response()->json($normes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_norme' => 'required|string|unique:normes',
            'description' => 'nullable|string'
        ]);

        $norme = Norme::create($validated);
        return response()->json($norme, 201);
    }

    public function show($id)
    {
        $norme = Norme::with('projets')->findOrFail($id);
        return response()->json($norme);
    }

    public function update(Request $request, $id)
    {
        $norme = Norme::findOrFail($id);
        
        $validated = $request->validate([
            'code_norme' => 'sometimes|string|unique:normes,code_norme,' . $id,
            'description' => 'nullable|string'
        ]);

        $norme->update($validated);
        return response()->json($norme);
    }

    public function destroy($id)
    {
        $norme = Norme::findOrFail($id);
        $norme->delete();
        return response()->json(null, 204);
    }
}