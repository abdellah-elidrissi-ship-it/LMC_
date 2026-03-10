<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gantt_taches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->onDelete('cascade');

            // Infos tâche
            $table->integer('numero')->nullable();           // N° tâche (1, 2, 3...)
            $table->string('designation');                   // Nom tâche
            $table->string('unite')->default('H/J');         // Unité (H/J)
            $table->string('responsable')->nullable();       // Responsable(s)

            // Charge de travail
            $table->decimal('ct_prevue', 8, 2)->default(0);   // CT Prévue en h/j
            $table->decimal('ct_realisee', 8, 2)->default(0); // CT Réalisé en h/j

            // Planning
            $table->decimal('avancement', 5, 2)->default(0);  // % avancement (0-1)
            $table->date('date_debut')->nullable();            // Début
            $table->integer('delai_jours')->default(1);        // Délais en jours
            $table->date('date_fin_initiale')->nullable();     // Fin initiale calculée

            // Arrêts/reprises
            $table->date('arret_1')->nullable();
            $table->date('reprise_1')->nullable();
            $table->date('arret_2')->nullable();
            $table->date('reprise_2')->nullable();
            $table->integer('delai_sup')->default(0);          // Délai supplémentaire

            $table->date('date_fin_calculee')->nullable();     // Fin calculée finale

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gantt_taches');
    }
};