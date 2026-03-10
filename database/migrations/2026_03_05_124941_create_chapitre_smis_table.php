<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('chapitres_smis', function (Blueprint $table) {
        $table->id();
        $table->string('code_chapitre'); // §4, §5, §6...
        $table->string('titre_chapitre');
        $table->text('exigences_cles')->nullable();
        $table->integer('ordre')->default(0);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('chapitre_smis');
    }
};
