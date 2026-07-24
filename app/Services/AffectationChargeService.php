<?php

namespace App\Services;

use App\Models\Affectation;
use Illuminate\Support\Facades\DB;

/**
 * Source unique du calcul de jours_realises par consultant sur un projet
 * (colonne affectations.jours_realises, affichée dans "Charge de travail") —
 * dérivé des tâches Gantt qui lui sont assignées (GanttTache::consultants(),
 * many-to-many), plus jamais saisi manuellement. À appeler après toute
 * création/modification/suppression de tâche Gantt (GanttController) et
 * après toute modification des affectations d'un projet (EditController,
 * NouveauProjetController).
 */
class AffectationChargeService
{
    public static function recalculerPourProjet(int $projetId): void
    {
        $realisesParConsultant = DB::table('gantt_tache_consultant')
            ->join('gantt_taches', 'gantt_taches.id', '=', 'gantt_tache_consultant.gantt_tache_id')
            ->where('gantt_taches.projet_id', $projetId)
            ->groupBy('gantt_tache_consultant.consultant_id')
            ->selectRaw('gantt_tache_consultant.consultant_id, SUM(gantt_taches.ct_realisee) as total')
            ->pluck('total', 'consultant_id');

        Affectation::where('projet_id', $projetId)->get()->each(function (Affectation $affectation) use ($realisesParConsultant) {
            $affectation->update([
                'jours_realises' => $realisesParConsultant->get($affectation->consultant_id, 0),
            ]);
        });
    }
}
