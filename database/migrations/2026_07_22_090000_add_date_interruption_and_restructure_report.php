<?php

use App\Services\GanttDateService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('gantt_taches', 'date_interruption')) {
            Schema::table('gantt_taches', function (Blueprint $table) {
                $table->date('date_interruption')->nullable()->after('date_fin');
            });
        }

        // "report" n'est plus une valeur de type_tache — c'est désormais un état
        // orthogonal (date_reprise/date_interruption) applicable à phase|journee.
        // On repasse les tâches existantes en 'phase' en calculant leur
        // date_interruption rétroactivement (comme le faisait l'ancienne logique,
        // sur la base de CT Réalisé) pour ne pas perdre l'info déjà saisie.
        DB::table('gantt_taches')->where('type_tache', 'report')->orderBy('id')->each(function ($tache) {
            $dateInterruption = null;

            if ($tache->date_debut) {
                $dateInterruption = GanttDateService::calculerDateFin(
                    \Illuminate\Support\Carbon::parse($tache->date_debut),
                    (float) $tache->ct_realisee
                )->toDateString();
            }

            DB::table('gantt_taches')->where('id', $tache->id)->update([
                'type_tache' => 'phase',
                'date_interruption' => $dateInterruption,
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('gantt_taches', function (Blueprint $table) {
            $table->dropColumn('date_interruption');
        });
    }
};
