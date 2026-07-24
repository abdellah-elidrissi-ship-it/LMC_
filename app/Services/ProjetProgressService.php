<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ProjetProgressService
{
    /**
     * Recalcule avancement_percent à partir du ratio de livrables Terminé,
     * et le persiste. Retourne le pourcentage calculé.
     */
    public static function recalculerAvancement(int $projetId): int
    {
        $totalLivrables = DB::table('projet_livrables')
            ->where('projet_id', $projetId)
            ->count();

        $livrablesTermines = DB::table('projet_livrables')
            ->where('projet_id', $projetId)
            ->where('statut', 'Terminé')
            ->count();

        $avancement = $totalLivrables > 0
            ? round(($livrablesTermines / $totalLivrables) * 100)
            : 0;

        DB::table('projets')
            ->where('id', $projetId)
            ->update([
                'avancement_percent' => $avancement,
                'updated_at' => now(),
            ]);

        return $avancement;
    }
}
