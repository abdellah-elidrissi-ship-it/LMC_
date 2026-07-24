<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gantt_taches', function (Blueprint $table) {
            $table->foreignId('consultant_id')->nullable()->after('phase_id')
                ->constrained('consultants')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('gantt_taches', function (Blueprint $table) {
            $table->dropConstrainedForeignId('consultant_id');
        });
    }
};
