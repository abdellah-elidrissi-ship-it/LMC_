<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultant_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('titre');
            $table->text('objectif')->nullable();

            $table->date('date');
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();

            $table->enum('statut', ['Assignée', 'Lue', 'Acceptée', 'Refusée', 'En cours', 'Terminée'])
                ->default('Assignée');

            $table->timestamp('lu_at')->nullable();
            $table->timestamp('reponse_at')->nullable();
            $table->text('commentaire')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
