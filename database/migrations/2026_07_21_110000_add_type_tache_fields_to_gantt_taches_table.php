<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gantt_taches', function (Blueprint $table) {
            // phase (continu, défaut = comportement actuel) | journee (jours discontinus) | report (continu + reprise)
            $table->string('type_tache')->default('phase')->after('consultant_id');
            $table->json('jours_choisis')->nullable()->after('date_fin');
            $table->date('date_reprise')->nullable()->after('jours_choisis');
        });
    }

    public function down(): void
    {
        Schema::table('gantt_taches', function (Blueprint $table) {
            $table->dropColumn(['type_tache', 'jours_choisis', 'date_reprise']);
        });
    }
};
