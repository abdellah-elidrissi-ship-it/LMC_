<?php

namespace App\Http\Controllers;

use App\Models\GanttPhase;
use App\Models\GanttTache;
use App\Models\Projet;
use Illuminate\Http\Request;

class GanttController extends Controller
{
    // ── Afficher le Gantt d'un projet ────────────────────────────────
    public function show($id)
    {
        if (!auth()->user()->hasPermission('voir_gantt')) {
            abort(403, 'Accès non autorisé à la page Gantt');
        }

        $projet = Projet::with(['client', 'chefProjet'])->findOrFail($id);

        $phases = $projet->ganttPhases()->with('taches')->get();

        $tachesSansPhase = GanttTache::where('projet_id', $id)
            ->whereNull('phase_id')
            ->orderBy('numero')
            ->get();

        return view('Gantt', compact('projet', 'phases', 'tachesSansPhase'));
    }

    // ── Phases ─────────────────────────────────────────────────────

    public function storePhase(Request $request, $id)
    {
        $this->autoriser();

        $request->validate(['nom' => 'required|string|max:255']);

        $ordre = GanttPhase::where('projet_id', $id)->max('ordre') ?? 0;

        GanttPhase::create([
            'projet_id' => $id,
            'nom' => trim($request->nom),
            'ordre' => $ordre + 1,
        ]);

        return redirect()->route('gantt.show', $id)->with('success', '✅ Phase ajoutée !');
    }

    public function updatePhase(Request $request, $id, $phaseId)
    {
        $this->autoriser();

        $request->validate(['nom' => 'required|string|max:255']);

        GanttPhase::where('id', $phaseId)
            ->where('projet_id', $id)
            ->update(['nom' => trim($request->nom)]);

        return redirect()->route('gantt.show', $id)->with('success', '✅ Phase modifiée !');
    }

    public function destroyPhase($id, $phaseId)
    {
        $this->autoriser();

        GanttPhase::where('id', $phaseId)->where('projet_id', $id)->delete();

        return redirect()->route('gantt.show', $id)->with('success', '✅ Phase supprimée !');
    }

    // ── Tâches ─────────────────────────────────────────────────────

    public function storeTache(Request $request, $id)
    {
        $this->autoriser();

        $request->validate([
            'designation' => 'required|string|max:255',
            'phase_id' => 'nullable|exists:gantt_phases,id',
        ]);

        $numero = GanttTache::where('projet_id', $id)->max('numero') ?? 0;

        GanttTache::create([
            'projet_id' => $id,
            'phase_id' => $request->phase_id ?: null,
            'numero' => $numero + 1,
            'designation' => trim($request->designation),
            'unite' => 'H/J',
            'responsable' => $request->responsable,
            'ct_prevue' => (float) ($request->ct_prevue ?? 0),
            'ct_realisee' => (float) ($request->ct_realisee ?? 0),
            'avancement' => min(max((float) ($request->avancement ?? 0), 0), 100),
            'date_debut' => $request->date_debut ?: null,
            'date_fin' => $request->date_fin ?: null,
        ]);

        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche ajoutée !');
    }

    public function updateTache(Request $request, $id, $tacheId)
    {
        $this->autoriser();

        $request->validate([
            'designation' => 'required|string|max:255',
            'phase_id' => 'nullable|exists:gantt_phases,id',
        ]);

        GanttTache::where('id', $tacheId)
            ->where('projet_id', $id)
            ->update([
                'phase_id' => $request->phase_id ?: null,
                'designation' => trim($request->designation),
                'responsable' => $request->responsable,
                'ct_prevue' => (float) ($request->ct_prevue ?? 0),
                'ct_realisee' => (float) ($request->ct_realisee ?? 0),
                'avancement' => min(max((float) ($request->avancement ?? 0), 0), 100),
                'date_debut' => $request->date_debut ?: null,
                'date_fin' => $request->date_fin ?: null,
            ]);

        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche modifiée !');
    }

    public function destroyTache($id, $tacheId)
    {
        $this->autoriser();

        GanttTache::where('id', $tacheId)->where('projet_id', $id)->delete();

        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche supprimée !');
    }

    private function autoriser(): void
    {
        if (!auth()->user()->hasPermission('modifier_projets')) {
            abort(403, 'Action non autorisée');
        }
    }
}
