<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultant;
use App\Models\Affectation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsultantController extends Controller
{
    public function index()
    {
        $consultants = Consultant::orderBy('nom_complet')->get();
        return view('consultants', compact('consultants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_complet'      => 'required|string|max:255',
            'type_consultant'  => 'required|in:Interne,Freelancer,Externe',
            'specialite'       => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255',
            'telephone'        => 'nullable|string|max:50',
        ]);

        Consultant::create([
            'nom_complet'     => $request->nom_complet,
            'type_consultant' => $request->type_consultant,
            'specialite'      => $request->specialite,
            'email'           => $request->email,
            'telephone'       => $request->telephone,
            'actif'           => true,
        ]);

        return redirect('/consultants')
            ->with('success', '✅ Consultant ajouté avec succès!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_complet'     => 'required|string|max:255',
            'type_consultant' => 'required|in:Interne,Freelancer,Externe',
            'specialite'      => 'nullable|string|max:255',
            'email'           => 'nullable|email|max:255',
            'telephone'       => 'nullable|string|max:50',
            'actif'           => 'boolean',
        ]);

        $consultant = Consultant::findOrFail($id);
        $consultant->update([
            'nom_complet'     => $request->nom_complet,
            'type_consultant' => $request->type_consultant,
            'specialite'      => $request->specialite,
            'email'           => $request->email,
            'telephone'       => $request->telephone,
            'actif'           => $request->has('actif') ? 1 : 0,
        ]);

        return redirect('/consultants')
            ->with('success', '✅ Consultant modifié avec succès!');
    }

    public function destroy($id)
    {
        $consultant = Consultant::findOrFail($id);

        // Vérifier s'il est chef de projet
        $isChef = DB::table('projets')->where('chef_projet_id', $id)->count();
        if ($isChef > 0) {
            return redirect('/consultants')
                ->with('error', '❌ Impossible de supprimer — ce consultant est chef de projet!');
        }

        // Supprimer affectations puis consultant
        Affectation::where('consultant_id', $id)->delete();
        $consultant->delete();

        return redirect('/consultants')
            ->with('success', '✅ Consultant supprimé avec succès!');
    }
}