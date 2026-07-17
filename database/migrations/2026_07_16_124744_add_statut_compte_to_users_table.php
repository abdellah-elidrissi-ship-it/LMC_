<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('statut_compte', ['en_attente', 'approuve', 'refuse'])
                ->default('approuve')
                ->after('permissions');
            $table->enum('role_souhaite', ['consultant', 'chef_projet'])
                ->nullable()
                ->after('statut_compte');
            $table->text('motif_refus')->nullable()->after('role_souhaite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['statut_compte', 'role_souhaite', 'motif_refus']);
        });
    }
};
