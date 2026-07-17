<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('livrables_smi')) {
            Schema::create('livrables_smi', function (Blueprint $table) {
                $table->id();
                $table->string('chapitre_code', 20);
                $table->string('clause', 30)->nullable();
                $table->text('libelle');
                $table->string('phase_smi', 100)->nullable();
                $table->unsignedSmallInteger('ordre')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('livrables_smi');
    }
};
