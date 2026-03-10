<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Projet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GanttController extends Controller
{
    public function show($id)
    {
        $projet = DB::selectOne("
            SELECT p.*, c.nom_client, cons.nom_complet as chef_nom
            FROM projets p
            LEFT JOIN clients c ON p.client_id = c.id
            LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
            WHERE p.id = ?
        ", [$id]);

        if (!$projet) abort(404);

        $taches = DB::select("
            SELECT * FROM gantt_taches 
            WHERE projet_id = ? 
            ORDER BY numero ASC
        ", [$id]);

        // Stats
        $totalPrevus   = collect($taches)->sum('ct_prevue');
        $totalRealises = collect($taches)->sum('ct_realisee');
        $avgAvancement = count($taches) > 0 ? round(collect($taches)->avg('avancement') * 100) : 0;
        $enRetard      = collect($taches)->filter(fn($t) => $t->ct_realisee > $t->ct_prevue && $t->ct_prevue > 0)->count();

        return view('gantt', compact('projet', 'taches', 'totalPrevus', 'totalRealises', 'avgAvancement', 'enRetard'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate(['fichier' => 'required|file|mimes:xlsx,xls']);

        $projet = Projet::findOrFail($id);
        $file   = $request->file('fichier');

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray(null, true, true, true);

            // Supprimer anciennes tâches
            DB::table('gantt_taches')->where('projet_id', $id)->delete();

            $inserted = 0;
            foreach ($rows as $i => $row) {
                // Skip header rows (1-7) — data starts row 8
                if ($i < 8) continue;

                $num  = $row['B'] ?? null;
                $desc = $row['C'] ?? null;

                // Skip si pas de désignation
                if (empty($desc) || !is_string($desc)) continue;
                if (empty($num) || !is_numeric($num)) continue;

                // Dates
                $dateDebut      = $this->parseDate($row['K'] ?? null);
                $dateFinInit    = $this->parseDate($row['M'] ?? null);
                $dateFinCalc    = $this->parseDate($row['S'] ?? null);
                $arret1         = $this->parseDate($row['N'] ?? null);
                $reprise1       = $this->parseDate($row['O'] ?? null);
                $arret2         = $this->parseDate($row['P'] ?? null);
                $reprise2       = $this->parseDate($row['Q'] ?? null);

                DB::table('gantt_taches')->insert([
                    'projet_id'         => $id,
                    'numero'            => (int)$num,
                    'designation'       => $desc,
                    'unite'             => $row['D'] ?? 'H/J',
                    'responsable'       => $row['E'] ?? null,
                    'ct_prevue'         => is_numeric($row['F'] ?? null) ? (float)$row['F'] : 0,
                    'ct_realisee'       => is_numeric($row['G'] ?? null) ? (float)$row['G'] : 0,
                    'avancement'        => is_numeric($row['I'] ?? null) ? (float)$row['I'] : 0,
                    'date_debut'        => $dateDebut,
                    'delai_jours'       => is_numeric($row['L'] ?? null) ? (int)$row['L'] : 1,
                    'date_fin_initiale' => $dateFinInit,
                    'arret_1'           => $arret1,
                    'reprise_1'         => $reprise1,
                    'arret_2'           => $arret2,
                    'reprise_2'         => $reprise2,
                    'delai_sup'         => is_numeric($row['R'] ?? null) ? (int)$row['R'] : 0,
                    'date_fin_calculee' => $dateFinCalc,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
                $inserted++;
            }

            return redirect()->route('gantt.show', $id)
                ->with('success', "✅ {$inserted} tâches importées avec succès!");

        } catch (\Exception $e) {
            return back()->with('error', '❌ Erreur: ' . $e->getMessage());
        }
    }

    public function storeTache(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required|string',
            'date_debut'  => 'nullable|date',
        ]);

        $last = DB::table('gantt_taches')->where('projet_id', $id)->max('numero') ?? 0;

        DB::table('gantt_taches')->insert([
            'projet_id'         => $id,
            'numero'            => $last + 1,
            'designation'       => $request->designation,
            'unite'             => $request->unite ?? 'H/J',
            'responsable'       => $request->responsable,
            'ct_prevue'         => $request->ct_prevue ?? 0,
            'ct_realisee'       => $request->ct_realisee ?? 0,
            'avancement'        => ($request->avancement ?? 0) / 100,
            'date_debut'        => $request->date_debut,
            'delai_jours'       => $request->delai_jours ?? 1,
            'date_fin_initiale' => $request->date_fin_initiale,
            'date_fin_calculee' => $request->date_fin_calculee,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche ajoutée!');
    }

    public function destroyTache($id, $tacheId)
    {
        DB::table('gantt_taches')->where('id', $tacheId)->where('projet_id', $id)->delete();
        return redirect()->route('gantt.show', $id)->with('success', '✅ Tâche supprimée!');
    }

    private function parseDate($val): ?string
    {
        if (empty($val)) return null;
        if ($val instanceof \DateTime) return $val->format('Y-m-d');
        if (is_numeric($val)) {
            try {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val);
                return $date->format('Y-m-d');
            } catch (\Exception $e) { return null; }
        }
        try {
            return \Carbon\Carbon::parse($val)->format('Y-m-d');
        } catch (\Exception $e) { return null; }
    }
}