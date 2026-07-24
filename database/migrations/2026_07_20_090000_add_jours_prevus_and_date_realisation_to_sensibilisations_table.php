<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sensibilisations', function (Blueprint $table) {
            $table->decimal('jours_prevus', 5, 1)->default(0.0)->after('photo_path');
            $table->date('date_realisation')->nullable()->after('jours_prevus');
        });
    }

    public function down(): void
    {
        Schema::table('sensibilisations', function (Blueprint $table) {
            $table->dropColumn(['jours_prevus', 'date_realisation']);
        });
    }
};
