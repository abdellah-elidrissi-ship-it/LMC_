<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivrablesController extends Controller
{
    /**
     * Retourne les livrables d'un projet groupés par chapitre
     * avec le statut de chaque livrable (pour la blade)
     *
     * Usage: $livrables = LivrablesController::forProjet($projetId);
     */
    public static function forProjet(int $projetId): array
    {
        // Tous les livrables + statut projet si existe
        $rows = DB::select("
            SELECT
                ls.id,
                ls.chapitre_code,
                ls.clause,
                ls.libelle,
                ls.phase_smi,
                ls.ordre,
                COALESCE(pl.statut, 'Non commencé') as statut,
                pl.observations
            FROM livrables_smi ls
            LEFT JOIN projet_livrables pl
                ON pl.livrable_id = ls.id AND pl.projet_id = ?
            ORDER BY ls.ordre ASC
        ", [$projetId]);

        // Grouper par chapitre_code
        $grouped = [];
        foreach ($rows as $row) {
            $chap = $row->chapitre_code;
            if (!isset($grouped[$chap])) {
                $grouped[$chap] = [
                    'code'      => $chap,
                    'livrables' => [],
                    'total'     => 0,
                    'termines'  => 0,
                ];
            }
            $grouped[$chap]['livrables'][] = $row;
            $grouped[$chap]['total']++;
            if ($row->statut === 'Terminé') {
                $grouped[$chap]['termines']++;
            }
        }

        return $grouped;
    }

    /**
     * Sauvegarde les statuts des livrables d'un projet
     * POST /projet/{id}/livrables
     *
     * Request body:
     * livrables[livrable_id] = statut  (Non commencé / En cours / Terminé)
     */
    public function save(Request $request, int $projetId)
    {
        $request->validate([
            'livrables'   => 'required|array',
            'livrables.*' => 'in:Non commencé,En cours,Terminé',
        ]);

        $now = now();
        $upserts = [];

        foreach ($request->livrables as $livrableId => $statut) {
            $upserts[] = [
                'projet_id'   => $projetId,
                'livrable_id' => (int) $livrableId,
                'statut'      => $statut,
                'updated_at'  => $now,
                'created_at'  => $now,
            ];
        }

        // Upsert — insert ou update si déjà existant
        DB::table('projet_livrables')->upsert(
            $upserts,
            ['projet_id', 'livrable_id'],   // colonnes unique
            ['statut', 'updated_at']         // colonnes à mettre à jour
        );
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

        if ($request->ajax()) {
            return response()->json(['success' => true, 'saved' => count($upserts)]);
        }

        return back()->with('success', '✅ Livrables mis à jour avec succès.');
    }

    /**
     * Sauvegarde AJAX d'un seul livrable
     * POST /projet/{id}/livrables/single
     */
    public function saveSingle(Request $request, int $projetId)
    {
        $request->validate([
            'livrable_id' => 'required|exists:livrables_smi,id',
            'statut'      => 'required|in:Non commencé,En cours,Terminé',
        ]);

        DB::table('projet_livrables')->upsert(
            [[
                'projet_id'   => $projetId,
                'livrable_id' => $request->livrable_id,
                'statut'      => $request->statut,
                'updated_at'  => now(),
                'created_at'  => now(),
            ]],
            ['projet_id', 'livrable_id'],
            ['statut', 'updated_at']
        );
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

        return response()->json(['success' => true]);
    }
}