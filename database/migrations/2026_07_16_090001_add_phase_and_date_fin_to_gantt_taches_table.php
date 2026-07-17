<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gantt_taches', function (Blueprint $table) {
            $table->foreignId('phase_id')->nullable()->after('projet_id')
                ->constrained('gantt_phases')->nullOnDelete();
            $table->date('date_fin')->nullable()->after('date_debut');
        });

        // Backfill des tâches existantes (avancement 0-1 -> 0-100, date_fin depuis date_fin_calculee)
        foreach (DB::table('gantt_taches')->get() as $tache) {
            DB::table('gantt_taches')
                ->where('id', $tache->id)
                ->update([
                    'date_fin' => $tache->date_fin_calculee ?? $tache->date_fin_initiale,
                    'avancement' => min((float) $tache->avancement * 100, 100),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('gantt_taches', function (Blueprint $table) {
            $table->dropForeign(['phase_id']);
            $table->dropColumn(['phase_id', 'date_fin']);
        });
    }
};
