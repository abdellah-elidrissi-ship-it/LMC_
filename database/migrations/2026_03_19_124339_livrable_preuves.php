<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livrable_preuves', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('projet_id');
    $table->unsignedBigInteger('livrable_id');
    $table->string('label')->nullable();
    $table->string('fichier_nom');
    $table->string('fichier_path');
    $table->string('mime_type')->nullable();
    $table->integer('taille_kb')->nullable();
    $table->timestamps();

    $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
    $table->foreign('livrable_id')->references('id')->on('livrables_smi')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
