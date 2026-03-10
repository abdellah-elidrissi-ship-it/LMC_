<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('projet_formations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('projet_id')->constrained()->onDelete('cascade');
        $table->foreignId('formation_id')->constrained()->onDelete('cascade');
        $table->enum('statut', ['Finalisée', 'Réalisée', 'À planifier', 'En cours'])->default('À planifier');
        $table->text('observations')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('projet_formations');
    }
};
