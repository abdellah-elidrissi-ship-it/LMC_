<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // migration normes
public function up()
{
    Schema::create('normes', function (Blueprint $table) {
        $table->id();
        $table->string('code_norme');
        $table->text('description')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('normes');
    }
};
