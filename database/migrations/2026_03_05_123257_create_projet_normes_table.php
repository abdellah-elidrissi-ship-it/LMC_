<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // migration projet_normes
public function up()
{
    Schema::create('projet_normes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('projet_id')->constrained()->onDelete('cascade');
        $table->foreignId('norme_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('projet_normes');
    }
};
