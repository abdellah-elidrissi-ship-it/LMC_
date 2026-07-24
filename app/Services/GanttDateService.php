<?php

namespace App\Services;

use Illuminate\Support\Carbon;

/**
 * Conservé uniquement en façade de compatibilité : la migration historique
 * 2026_07_22_090000_add_date_interruption_and_restructure_report.php appelle
 * calculerDateFin() en statique, et une migration déjà exécutée ne se modifie
 * jamais. Tout nouveau code doit utiliser App\Services\GanttTacheDateCalculator
 * directement — ne pas ajouter de nouvelle logique ici.
 */
class GanttDateService
{
    public static function calculerDateFin(Carbon $dateDebut, float $ctPrevue): Carbon
    {
        return (new GanttTacheDateCalculator())->calculerDateFin($dateDebut, $ctPrevue);
    }
}
