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
            return redirect()->back()
                ->with('error', '❌ Impossible de supprimer — ce consultant est chef de projet!');
        }

        $user = \App\Models\User::where('consultant_id', $id)->first();

        if ($user) {
            if ($user->id === auth()->id()) {
                return redirect()->back()
                    ->with('error', '❌ Vous ne pouvez pas supprimer votre propre compte.');
            }

            if ($user->role === 'super_admin' && \App\Models\User::where('role', 'super_admin')->count() <= 1) {
                return redirect()->back()
                    ->with('error', '❌ Impossible de supprimer — ce compte est le seul Super Admin.');
            }
        }

        $nom = $consultant->nom_complet;

        DB::transaction(function () use ($id, $consultant, $user) {
            Affectation::where('consultant_id', $id)->delete();
            \App\Models\Tache::where('consultant_id', $id)->delete();
            $user?->delete();
            $consultant->delete();
        });

        return redirect('/consultants')
            ->with('success', "✅ Consultant {$nom} supprimé avec succès (compte utilisateur et tâches associées inclus).");
    }
}