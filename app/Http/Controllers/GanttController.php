<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Projet;
use Carbon\Carbon;

class GanttController extends Controller
{
    // ── Afficher le Gantt d'un projet ────────────────────────────────
    public function show($id)
    {
        // Vérifier la permission
        if (!auth()->user()->hasPermission('voir_gantt')) {
            abort(403, 'Accès non autorisé à la page Gantt');
        }
        
        $projet = DB::selectOne("
            SELECT p.*, c.nom_client, cons.nom_complet AS chef_nom
            FROM projets p
            LEFT JOIN clients c    ON p.client_id       = c.id
            LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
            WHERE p.id = ?
        ", [$id]);

        if (!$projet) abort(404);

        $taches = DB::select(
            "SELECT * FROM gantt_taches WHERE projet_id = ? ORDER BY numero ASC",
            [$id]
        );

        return view('Gantt', compact('projet', 'taches'));
    }

    // ── Ajouter une tâche manuellement ────────────────────────────────
    public function storeTache(Request $request, $id)
    {
        // Vérifier la permission
        if (!auth()->user()->hasPermission('modifier_projets')) {
            abort(403, 'Action non autorisée');
        }
        
        $request->validate(['designation' => 'required|string|max:255']);

        $dernier = DB::table('gantt_taches')->where('projet_id', $id)->max('numero') ?? 0;
        $delai   = max((int)($request->delai_jours ?? 1), 1);
        $debut   = $request->date_debut ?: null;
        $fin     = $debut ? Carbon::parse($debut)->addDays($delai - 1)->format('Y-m-d') : null;

        DB::table('gantt_taches')->insert([
            'projet_id'         => $id,
            'numero'            => $dernier + 1,
            'designation'       => trim($request->designation),
            'unite'             => $request->unite ?? 'H/J',
            'responsable'       => $request->responsable ?? null,
            'ct_prevue'         => (float)($request->ct_prevue  ?? 0),
            'ct_realisee'       => (float)($request->ct_realisee ?? 0),
            'avancement'        => min(max((float)($request->avancement ?? 0) / 100, 0), 1),
            'date_debut'        => $debut,
            'delai_jours'       => $delai,
            'date_fin_initiale' => $fin,
            'date_fin_calculee' => $fin,
            'delai_sup'         => 0,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche ajoutée !');
    }

    // ── Modifier une tâche ────────────────────────────────────────────
    public function updateTache(Request $request, $id, $tacheId)
    {
        // Vérifier la permission
        if (!auth()->user()->hasPermission('modifier_projets')) {
            abort(403, 'Action non autorisée');
        }
        
        $request->validate(['designation' => 'required|string|max:255']);

        $delai = max((int)($request->delai_jours ?? 1), 1);
        $debut = $request->date_debut ?: null;
        $fin   = $debut ? Carbon::parse($debut)->addDays($delai - 1)->format('Y-m-d') : null;

        DB::table('gantt_taches')
            ->where('id', $tacheId)
            ->where('projet_id', $id)
            ->update([
                'designation'       => trim($request->designation),
                'unite'             => $request->unite ?? 'H/J',
                'responsable'       => $request->responsable ?? null,
                'ct_prevue'         => (float)($request->ct_prevue  ?? 0),
                'ct_realisee'       => (float)($request->ct_realisee ?? 0),
                'avancement'        => min(max((float)($request->avancement ?? 0) / 100, 0), 1),
                'date_debut'        => $debut,
                'delai_jours'       => $delai,
                'date_fin_initiale' => $fin,
                'date_fin_calculee' => $fin,
                'updated_at'        => now(),
            ]);

        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche modifiée !');
    }

    // ── Supprimer une tâche ───────────────────────────────────────────
    public function destroyTache($id, $tacheId)
    {
        // Vérifier la permission
        if (!auth()->user()->hasPermission('modifier_projets')) {
            abort(403, 'Action non autorisée');
        }
        
        DB::table('gantt_taches')
            ->where('id', $tacheId)
            ->where('projet_id', $id)
            ->delete();

        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche supprimée !');
    }
}