<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public function index()
    {
        $consultants = Consultant::with(['projets', 'projetsDiriges'])->get();
        return response()->json($consultants);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_complet' => 'required|string|max:255',
            'type_consultant' => 'required|in:Interne,Freelancer',
            'specialite' => 'nullable|string',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string',
            'actif' => 'boolean'
        ]);

        $consultant = Consultant::create($validated);
        return response()->json($consultant, 201);
    }

    public function show($id)
    {
        $consultant = Consultant::with(['projets', 'projetsDiriges'])->findOrFail($id);
        return response()->json($consultant);
    }

    public function update(Request $request, $id)
    {
        $consultant = Consultant::findOrFail($id);
        
        $validated = $request->validate([
            'nom_complet' => 'sometimes|string|max:255',
            'type_consultant' => 'sometimes|in:Interne,Freelancer',
            'specialite' => 'nullable|string',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string',
            'actif' => 'boolean'
        ]);

        $consultant->update($validated);
        return response()->json($consultant);
    }

    public function destroy($id)
    {
        $consultant = Consultant::findOrFail($id);
        $consultant->delete();
        return response()->json(null, 204);
    }
}
