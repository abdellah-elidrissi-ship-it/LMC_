<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('suivi_chapitres', function (Blueprint $table) {
        $table->id();
        $table->foreignId('projet_id')->constrained()->onDelete('cascade');
        $table->foreignId('chapitre_id')->constrained('chapitres_smis')->onDelete('cascade');
        $table->integer('avancement_percent')->default(0);
        $table->enum('phase', ['⬜ Non démarré', '⏳ Démarré', '🔄 En cours', '✅ Terminé'])->default('⬜ Non démarré');
        $table->integer('jours_intervention')->default(0);
        $table->text('statut_livrables')->nullable();
        $table->text('observations')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('suivi_chapitres');
    }
};
