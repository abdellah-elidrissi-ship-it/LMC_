<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // migration consultants
public function up()
{
    Schema::create('consultants', function (Blueprint $table) {
        $table->id();
        $table->string('nom_complet');
        $table->enum('type_consultant', ['Interne', 'Freelancer'])->default('Interne');
        $table->text('specialite')->nullable();
        $table->string('email')->nullable();
        $table->string('telephone')->nullable();
        $table->boolean('actif')->default(true);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};
