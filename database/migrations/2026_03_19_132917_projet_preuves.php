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
        // database/migrations/xxxx_xx_xx_xxxxxx_create_projet_preuves_table.php
Schema::create('projet_preuves', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('projet_id');
    $table->string('label')->nullable();
    $table->string('fichier_nom');
    $table->string('fichier_path');
    $table->string('mime_type')->nullable();
    $table->integer('taille_kb')->nullable();
    $table->timestamps();

    $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
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
