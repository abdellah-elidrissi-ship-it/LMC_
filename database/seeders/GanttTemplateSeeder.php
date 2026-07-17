<?php

namespace Database\Seeders;

use App\Models\Projet;
use App\Services\GanttTemplateService;
use Illuminate\Database\Seeder;

class GanttTemplateSeeder extends Seeder
{
    /**
     * Ajoute la base standard de phases/tâches SMI à tous les projets
     * qui n'ont pas encore de phases Gantt. Ne touche à aucune autre table.
     */
    public function run(): void
    {
        $projets = Projet::all();
        $crees = 0;
        $ignores = 0;

        foreach ($projets as $projet) {
            $avant = $projet->ganttPhases()->count();

            GanttTemplateService::creerPour($projet->id);

            if ($avant === 0) {
                $crees++;
            } else {
                $ignores++;
            }
        }

        $this->command->info("Phases Gantt créées pour {$crees} projet(s), {$ignores} déjà équipé(s) — ignoré(s).");
    }
}
