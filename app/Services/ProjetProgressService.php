<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ProjetProgressService
{
    /**
     * Recalcule avancement_percent à partir de la moyenne des Av.% saisis
     * manuellement par chapitre (suivi_chapitres.avancement_percent),
     * et le persiste. Retourne le pourcentage calculé.
     */
    public static function recalculerAvancement(int $projetId): int
    {
        $moyenne = DB::table('suivi_chapitres')
            ->where('projet_id', $projetId)
            ->avg('avancement_percent');

        $avancement = $moyenne !== null ? (int) round($moyenne) : 0;

        DB::table('projets')
            ->where('id', $projetId)
            ->update([
                'avancement_percent' => $avancement,
                'updated_at' => now(),
            ]);

        return $avancement;
    }
}
