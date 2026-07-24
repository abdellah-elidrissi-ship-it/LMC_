<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projet_formations', function (Blueprint $table) {
            $table->decimal('jours_realises', 5, 1)->default(0.0)->after('updated_at');
            $table->date('date_realisation')->nullable()->after('jours_realises');
        });
    }

    public function down(): void
    {
        Schema::table('projet_formations', function (Blueprint $table) {
            $table->dropColumn(['jours_realises', 'date_realisation']);
        });
    }
};
