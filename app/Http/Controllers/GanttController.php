<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Models\GanttPhase;
use App\Models\GanttTache;
use App\Models\Projet;
use App\Services\AffectationChargeService;
use App\Services\GanttTacheDateCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class GanttController extends Controller
{
    // ── Afficher le Gantt d'un projet ────────────────────────────────
    public function show(Request $request, $id)
    {
        if (!auth()->user()->hasPermission('voir_gantt')) {
            abort(403, 'Accès non autorisé à la page Gantt');
        }

        $projet = Projet::with(['client', 'chefProjet'])->findOrFail($id);

        $phases = $projet->ganttPhases()->with('taches.consultants')->get();

        $tachesSansPhase = GanttTache::where('projet_id', $id)
            ->whereNull('phase_id')
            ->orderBy('numero')
            ->with('consultants')
            ->get();

        $consultantsProjet = Consultant::orderBy('nom_complet')->get();

        $groupBy = $request->query('groupBy') === 'consultant' ? 'consultant' : 'phase';

        return view('Gantt', compact('projet', 'phases', 'tachesSansPhase', 'consultantsProjet', 'groupBy'));
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

    public function storeTache(Request $request, $id, GanttTacheDateCalculator $calculateur)
    {
        $this->autoriser();

        $request->validate([
            'designation' => 'required|string|max:255',
            'phase_id' => 'nullable|exists:gantt_phases,id',
            'consultant_ids' => 'nullable|array',
            'consultant_ids.*' => 'exists:consultants,id',
        ]);

        $numero = GanttTache::where('projet_id', $id)->max('numero') ?? 0;
        $champsType = $this->resoudreChampsType($request);
        $ctRealisee = (float) ($request->ct_realisee ?? 0);
        $avancement = min(max((float) ($request->avancement ?? 0), 0), 100);

        // Le report ne se propose qu'en modification d'une tâche déjà existante.
        $champsDates = $calculateur->calculerPourTache(new GanttTache(), [
            'type_tache' => $champsType['type_tache'],
            'ct_prevue' => $champsType['ct_prevue'],
            'ct_realisee' => $ctRealisee,
            'avancement' => $avancement,
            'date_debut' => $champsType['date_debut'],
            'jours_choisis' => $champsType['jours_choisis'],
            'date_reprise_demandee' => null,
            'date_interruption_demandee' => null,
        ]);

        $tache = GanttTache::create(array_merge([
            'projet_id' => $id,
            'phase_id' => $request->phase_id ?: null,
            'numero' => $numero + 1,
            'designation' => trim($request->designation),
            'unite' => 'H/J',
            'responsable' => $request->responsable,
            'ct_realisee' => $ctRealisee,
            'avancement' => $avancement,
        ], $champsType, $champsDates));

        $tache->consultants()->sync($request->consultant_ids ?? []);
        AffectationChargeService::recalculerPourProjet($id);

        // Centre la timeline sur la tâche qui vient d'être créée (voir Gantt.blade.php)
        // au lieu de "aujourd'hui" — sinon une date passée/lointaine reste hors champ
        // après le scroll par défaut et semble ne jamais apparaître dans la timeline.
        return redirect()->route('gantt.show', $id)
            ->with('success', '✅ Tâche ajoutée !')
            ->with('scrollToTacheId', $tache->id);
    }

    public function updateTache(Request $request, $id, $tacheId, GanttTacheDateCalculator $calculateur)
    {
        $this->autoriser();

        $request->validate([
            'designation' => 'required|string|max:255',
            'phase_id' => 'nullable|exists:gantt_phases,id',
            'consultant_ids' => 'nullable|array',
            'consultant_ids.*' => 'exists:consultants,id',
            // Les deux dates du report sont saisies manuellement par l'utilisateur
            // (jamais devinées) : elles doivent être fournies ensemble, et la date
            // de début du report ne peut pas être après la date de reprise.
            'date_reprise' => 'nullable|date|required_with:date_interruption',
            'date_interruption' => 'nullable|date|required_with:date_reprise|before_or_equal:date_reprise',
        ]);

        $tache = GanttTache::where('id', $tacheId)->where('projet_id', $id)->firstOrFail();

        $champsType = $this->resoudreChampsType($request);
        $ctRealisee = (float) ($request->ct_realisee ?? 0);
        $avancement = min(max((float) ($request->avancement ?? 0), 0), 100);
        $dateRepriseDemandee = $request->filled('date_reprise') ? Carbon::parse($request->date_reprise) : null;
        $dateInterruptionDemandee = $request->filled('date_interruption') ? Carbon::parse($request->date_interruption) : null;

        $champsDates = $calculateur->calculerPourTache($tache, [
            'type_tache' => $champsType['type_tache'],
            'ct_prevue' => $champsType['ct_prevue'],
            'ct_realisee' => $ctRealisee,
            'avancement' => $avancement,
            'date_debut' => $champsType['date_debut'],
            'jours_choisis' => $champsType['jours_choisis'],
            'date_reprise_demandee' => $dateRepriseDemandee,
            'date_interruption_demandee' => $dateInterruptionDemandee,
        ]);

        // Un report n'a de sens que sur une tâche qui a déjà une date de départ
        // résolue (date_debut pour "phase", au moins un jour choisi pour "journee")
        // — sinon GanttTacheDateCalculator::resoudrePourPhase()/resoudrePourJournee()
        // l'ignore silencieusement (segments vides, interruption/reprise jamais
        // enregistrées) : la tâche était "modifiée" (succès affiché) mais le report
        // demandé disparaissait sans aucun message (bug constaté le 2026-07-23).
        if (($dateRepriseDemandee || $dateInterruptionDemandee) && !$champsDates['date_debut']) {
            throw ValidationException::withMessages([
                'date_interruption' => $champsType['type_tache'] === 'journee'
                    ? 'Impossible de reporter cette tâche : choisissez d\'abord au moins un jour.'
                    : 'Impossible de reporter cette tâche : renseignez d\'abord sa "Date début".',
            ]);
        }

        $tache->update(array_merge([
            'phase_id' => $request->phase_id ?: null,
            'designation' => trim($request->designation),
            'responsable' => $request->responsable,
            'ct_realisee' => $ctRealisee,
            'avancement' => $avancement,
        ], $champsType, $champsDates));

        $tache->consultants()->sync($request->consultant_ids ?? []);
        AffectationChargeService::recalculerPourProjet($id);

        return redirect()->route('gantt.show', $id)
            ->with('success', '✅ Tâche modifiée !')
            ->with('scrollToTacheId', $tache->id);
    }

    public function destroyTache($id, $tacheId)
    {
        $this->autoriser();

        GanttTache::where('id', $tacheId)->where('projet_id', $id)->delete();
        AffectationChargeService::recalculerPourProjet($id);

        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche supprimée !');
    }

    /**
     * Résout/valide les champs liés au type de tâche (phase/journee) — partagé
     * entre storeTache/updateTache. Ne calcule plus aucune date : tout le calcul
     * de date_debut/date_fin/date_interruption/segments est délégué à
     * GanttTacheDateCalculator::calculerPourTache() (voir storeTache/updateTache).
     */
    private function resoudreChampsType(Request $request): array
    {
        $type = in_array($request->type_tache, ['phase', 'journee'], true)
            ? $request->type_tache
            : 'phase';

        if ($type === 'journee') {
            $request->validate([
                'jours' => 'nullable|array',
                'jours.*' => 'date',
            ]);

            $jours = collect($request->jours ?? [])
                ->map(fn($d) => Carbon::parse($d)->toDateString())
                ->unique()
                ->sort()
                ->values();

            $ctPrevue = (float) ($request->ct_prevue ?? 0);

            // En report actif, les jours restants sont choisis plus tard (au fil de
            // la reprise) — on exige seulement de ne pas dépasser CT Prévu, pas
            // l'égalité stricte, sinon impossible d'enregistrer une pause tant que
            // tous les jours ne sont pas déjà choisis.
            if ($request->filled('date_reprise')) {
                if ($jours->count() > (int) $ctPrevue) {
                    throw ValidationException::withMessages([
                        'jours' => "Le nombre de jours choisis ({$jours->count()}) dépasse le nombre de jours prévu ({$ctPrevue}).",
                    ]);
                }
            } elseif ((int) $ctPrevue !== $jours->count()) {
                throw ValidationException::withMessages([
                    'jours' => "Le nombre de jours choisis ({$jours->count()}) ne correspond pas au nombre de jours prévu ({$ctPrevue}).",
                ]);
            }

            return [
                'type_tache' => 'journee',
                'ct_prevue' => $ctPrevue,
                'date_debut' => null,
                'jours_choisis' => $jours->isEmpty() ? null : $jours->all(),
            ];
        }

        $request->validate([
            'date_debut' => 'nullable|date',
            'ct_prevue' => 'nullable|numeric|min:0',
        ]);

        return [
            'type_tache' => $type,
            'ct_prevue' => (float) ($request->ct_prevue ?? 0),
            'date_debut' => $request->filled('date_debut') ? Carbon::parse($request->date_debut) : null,
            'jours_choisis' => null,
        ];
    }

    private function autoriser(): void
    {
        if (!auth()->user()->hasPermission('modifier_projets')) {
            abort(403, 'Action non autorisée');
        }
    }
}
