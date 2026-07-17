<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use App\Notifications\TacheRepondueNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendrierController extends Controller
{
    /**
     * "Mon calendrier" — tâches du consultant connecté pour le mois demandé.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user->consultant_id) {
            return redirect('/')->with(
                'error',
                "Votre compte n'est lié à aucun profil consultant — aucun calendrier disponible."
            );
        }

        $ouvrirTacheId = $request->query('tache');

        return view('calendrier', compact('ouvrirTacheId'));
    }

    /**
     * Flux JSON des tâches du consultant connecté pour FullCalendar
     * (bornes start/end envoyées automatiquement par la lib).
     */
    public function events(Request $request)
    {
        $user = auth()->user();

        if (!$user->consultant_id) {
            return response()->json([]);
        }

        $query = Tache::with(['client', 'assignePar'])->where('consultant_id', $user->consultant_id);

        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('date', [
                Carbon::parse($request->query('start'))->toDateString(),
                Carbon::parse($request->query('end'))->toDateString(),
            ]);
        }

        return response()->json(
            $query->get()->map(fn (Tache $tache) => $tache->toCalendarEvent())
        );
    }

    /**
     * Marque une tâche comme lue (AJAX, appelée à l'ouverture du détail).
     */
    public function marquerLue($id)
    {
        $tache = Tache::where('consultant_id', auth()->user()->consultant_id)
            ->findOrFail($id);

        if (!$tache->lu_at) {
            $tache->lu_at = now();

            if ($tache->statut === 'Assignée') {
                $tache->statut = 'Lue';
            }

            $tache->save();
        }

        return response()->json(['success' => true, 'tache' => $tache]);
    }

    /**
     * Marque toutes les notifications non lues de l'utilisateur comme lues (cloche navbar).
     */
    public function marquerNotificationsLues()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Le consultant répond à la tâche (Accepter/Refuser/En cours/Terminée) + commentaire.
     */
    public function repondre(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:Acceptée,Refusée,En cours,Terminée',
            'commentaire' => 'nullable|string',
        ]);

        $tache = Tache::where('consultant_id', auth()->user()->consultant_id)
            ->findOrFail($id);

        $tache->update([
            'statut' => $request->statut,
            'commentaire' => $request->commentaire,
            'reponse_at' => now(),
        ]);

        if ($tache->assignePar) {
            $tache->assignePar->notify(new TacheRepondueNotification($tache));
        }

        return response()->json(['success' => true, 'tache' => $tache]);
    }
}
