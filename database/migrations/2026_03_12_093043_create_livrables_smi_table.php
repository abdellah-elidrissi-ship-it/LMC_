<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ══════════════════════════════════════════
        //  livrables_smi — catalogue fixe des livrables
        //  (données statiques, peuplées par le seeder)
        // ══════════════════════════════════════════
        Schema::create('livrables_smi', function (Blueprint $table) {
            $table->id();
            $table->string('chapitre_code', 20);        // §4, §5, §6 ... §10, Transversal
            $table->string('clause', 30)->nullable();    // 4.1, 6.1.2, 8.1.4 ...
            $table->text('libelle');                     // libellé complet du livrable
            $table->string('phase_smi', 100)->nullable();// PHASE 1 — DIAGNOSTIC ...
            $table->unsignedSmallInteger('ordre')->default(0);
            $table->timestamps();
        });

        // ══════════════════════════════════════════
        //  projet_livrables — statut par projet
        // ══════════════════════════════════════════
        Schema::create('projet_livrables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')
                  ->constrained('projets')
                  ->onDelete('cascade');
            $table->foreignId('livrable_id')
                  ->constrained('livrables_smi')
                  ->onDelete('cascade');
            $table->enum('statut', [
                'Non commencé',
                'En cours',
                'Terminé'
            ])->default('Non commencé');
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->unique(['projet_id', 'livrable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projet_livrables');
        Schema::dropIfExists('livrables_smi');
    }
};