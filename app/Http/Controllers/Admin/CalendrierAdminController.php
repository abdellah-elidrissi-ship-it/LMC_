<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Consultant;
use App\Models\Tache;
use App\Models\User;
use App\Notifications\TacheAssigneeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendrierAdminController extends Controller
{
    /**
     * Liste des consultants — pour choisir à qui assigner des tâches.
     */
    public function index()
    {
        $consultants = Consultant::orderBy('nom_complet')->get()->map(function ($c) {
            $c->user_id = User::where('consultant_id', $c->id)->value('id');

            $c->taches_a_venir = Tache::where('consultant_id', $c->id)
                ->where('date', '>=', now()->toDateString())
                ->count();

            return $c;
        });

        return view('admin.calendrier-consultants', compact('consultants'));
    }

    /**
     * Calendrier d'un consultant précis (mois demandé) + ses tâches.
     */
    public function show($consultantId)
    {
        $consultant = Consultant::findOrFail($consultantId);
        $clients = Client::orderBy('nom_client')->get();
        $consultants = Consultant::orderBy('nom_complet')->get();

        return view('admin.calendrier-consultant', compact('consultant', 'clients', 'consultants'));
    }

    /**
     * Flux JSON des tâches de ce consultant pour FullCalendar, filtrable
     * par client / statut (query params optionnels).
     */
    public function events(Request $request, $consultantId)
    {
        $query = Tache::with(['client', 'assignePar'])->where('consultant_id', $consultantId);

        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('date', [
                Carbon::parse($request->query('start'))->toDateString(),
                Carbon::parse($request->query('end'))->toDateString(),
            ]);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->query('client_id'));
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->query('statut'));
        }

        return response()->json(
            $query->get()->map(fn (Tache $tache) => $tache->toCalendarEvent())
        );
    }

    /**
     * Assigner une nouvelle tâche à ce consultant.
     */
    public function store(Request $request, $consultantId)
    {
        $consultant = Consultant::findOrFail($consultantId);

        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'titre' => 'required|string|max:255',
            'objectif' => 'nullable|string',
            'date' => 'required|date',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
        ]);

        $tache = Tache::create(array_merge($validated, [
            'consultant_id' => $consultant->id,
            'assigned_by' => auth()->id(),
            'statut' => 'Assignée',
        ]));

        $user = User::where('consultant_id', $consultant->id)->first();

        if ($user) {
            $user->notify(new TacheAssigneeNotification($tache));
        }

        return back()->with('success', 'Tâche assignée avec succès.');
    }

    /**
     * Modifier une tâche existante.
     */
    public function update(Request $request, $id)
    {
        $tache = Tache::findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'titre' => 'required|string|max:255',
            'objectif' => 'nullable|string',
            'date' => 'required|date',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
        ]);

        $tache->update($validated);

        return back()->with('success', 'Tâche modifiée avec succès.');
    }

    /**
     * Supprimer une tâche.
     */
    public function destroy($id)
    {
        Tache::findOrFail($id)->delete();

        return back()->with('success', 'Tâche supprimée avec succès.');
    }

    /**
     * Déplacer/redimensionner une tâche par drag & drop FullCalendar
     * (met à jour uniquement date/heures, pas les autres champs).
     */
    public function deplacer(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
        ]);

        $tache = Tache::findOrFail($id);
        $tache->update($validated);

        return response()->json(['success' => true, 'tache' => $tache]);
    }

    /**
     * Supprime définitivement toutes les tâches (calendrier) de ce
     * consultant — nettoyage manuel, ne touche ni au Consultant ni au
     * compte User lié.
     */
    public function viderCalendrier($consultantId)
    {
        $consultant = Consultant::findOrFail($consultantId);

        $nombreSupprimees = Tache::where('consultant_id', $consultantId)->delete();

        return redirect()
            ->route('admin.calendrier.show', $consultantId)
            ->with('success', "Calendrier de {$consultant->nom_complet} vidé — {$nombreSupprimees} tâche(s) supprimée(s).");
    }
}
