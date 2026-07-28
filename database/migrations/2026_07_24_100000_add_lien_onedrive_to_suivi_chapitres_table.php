<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suivi_chapitres', function (Blueprint $table) {
            $table->string('lien_onedrive')->nullable()->after('statut_livrables');
        });
    }

    public function down(): void
    {
        Schema::table('suivi_chapitres', function (Blueprint $table) {
            $table->dropColumn('lien_onedrive');
        });
    }
};
