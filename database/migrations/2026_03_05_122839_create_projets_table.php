<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   // migration projets
public function up()
{
    Schema::create('projets', function (Blueprint $table) {
        $table->id();
        $table->string('reference_projet')->unique();
        $table->foreignId('client_id')->constrained()->onDelete('cascade');
        $table->foreignId('chef_projet_id')->constrained('consultants')->onDelete('cascade');
        $table->string('type_projet')->default('SMI — Système de Management Intégré');
        $table->enum('statut', ['Finalisé', 'En cours', 'Planifié', 'En retard', 'En pause'])->default('Planifié');
        $table->integer('jours_prevus')->default(0);
        $table->integer('jours_realises')->default(0);
        $table->integer('avancement_percent')->default(0);
        $table->text('blocage')->nullable();
        $table->text('commentaire')->nullable();
        $table->date('date_debut')->nullable();
        $table->date('date_fin_prevue')->nullable();
        $table->date('date_fin_reelle')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
