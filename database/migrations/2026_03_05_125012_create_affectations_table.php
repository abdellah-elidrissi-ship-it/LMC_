<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('affectations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('projet_id')->constrained()->onDelete('cascade');
        $table->foreignId('consultant_id')->constrained()->onDelete('cascade');
        $table->string('role_dans_projet')->nullable(); // Chef de Projet, Consultant, etc.
        $table->decimal('jours_alloues', 5, 1)->default(0);
        $table->decimal('jours_realises', 5, 1)->default(0);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
