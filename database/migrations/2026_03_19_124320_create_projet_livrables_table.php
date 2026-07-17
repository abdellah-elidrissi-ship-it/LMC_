<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('projet_livrables')) {
            Schema::create('projet_livrables', function (Blueprint $table) {
                $table->id();
                $table->foreignId('projet_id')->constrained()->onDelete('cascade');
                $table->foreignId('livrable_id')->constrained('livrables_smi')->onDelete('cascade');
                $table->enum('statut', ['Non commencé', 'En cours', 'Terminé'])->default('Non commencé');
                $table->text('observations')->nullable();
                $table->timestamps();

                $table->unique(['projet_id', 'livrable_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projet_livrables');
    }
};
