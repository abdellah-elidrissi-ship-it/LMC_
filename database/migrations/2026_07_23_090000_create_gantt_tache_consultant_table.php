<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gantt_tache_consultant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gantt_tache_id')->constrained('gantt_taches')->cascadeOnDelete();
            $table->foreignId('consultant_id')->constrained('consultants')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['gantt_tache_id', 'consultant_id']);
        });

        // Backfill : une tâche qui avait déjà un consultant_id simple garde son
        // assignation sous forme de ligne pivot. L'ancienne colonne consultant_id
        // n'est volontairement pas supprimée ici (voir migration séparée à venir),
        // pour pouvoir valider la bascule avant de perdre la colonne.
        DB::table('gantt_taches')
            ->whereNotNull('consultant_id')
            ->select('id', 'consultant_id')
            ->orderBy('id')
            ->chunk(200, function ($taches) {
                $now = now();
                DB::table('gantt_tache_consultant')->insert(
                    $taches->map(fn($t) => [
                        'gantt_tache_id' => $t->id,
                        'consultant_id' => $t->consultant_id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ])->all()
                );
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('gantt_tache_consultant');
    }
};
