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
        if (!Schema::hasTable('projet_preuves')) {
            Schema::create('projet_preuves', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('projet_id');
                $table->string('label')->nullable();
                $table->string('fichier_nom');
                $table->string('fichier_path');
                $table->string('mime_type')->nullable();
                $table->integer('taille_kb')->nullable();
                $table->timestamps();

                $table->foreign('projet_id')
                    ->references('id')
                    ->on('projets')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projet_preuves');
    }
};