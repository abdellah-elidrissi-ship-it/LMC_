<?php

use App\Models\GanttTache;
use App\Services\GanttTacheDateCalculator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('gantt_taches', 'segments')) {
            Schema::table('gantt_taches', function (Blueprint $table) {
                $table->json('segments')->nullable()->after('date_reprise');
            });
        }

        // Recalcule segments (et date_fin/date_interruption pour les tâches en
        // report) en repassant les valeurs ACTUELLES de chaque tâche dans le
        // calculateur — équivalent à un vrai re-save utilisateur, sans devoir
        // reconstituer un historique. Corrige au passage les tâches en report
        // dont le date_fin était déjà obsolète (ex. CT Réalisé ayant dépassé
        // CT Prévu avant le fix du 2026-07-22 sur GanttController).
        $calculateur = new GanttTacheDateCalculator();

        GanttTache::query()->orderBy('id')->chunk(200, function ($taches) use ($calculateur) {
            foreach ($taches as $tache) {
                $resultat = $calculateur->calculerPourTache($tache, [
                    'type_tache' => $tache->type_tache,
                    'ct_prevue' => (float) $tache->ct_prevue,
                    'ct_realisee' => (float) $tache->ct_realisee,
                    'avancement' => (float) $tache->avancement,
                    'date_debut' => $tache->date_debut,
                    'jours_choisis' => $tache->jours_choisis,
                    'date_reprise_demandee' => $tache->date_reprise,
                    'date_interruption_demandee' => $tache->date_interruption,
                ]);

                $tache->update($resultat);
            }
        });
    }

    public function down(): void
    {
        Schema::table('gantt_taches', function (Blueprint $table) {
            $table->dropColumn('segments');
        });
    }
};
