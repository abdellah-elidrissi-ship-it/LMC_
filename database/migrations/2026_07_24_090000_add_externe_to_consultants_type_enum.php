<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Le formulaire consultants.blade.php propose déjà "Externe" comme
     * type_consultant, mais la colonne créée par
     * 2026_03_05_122756_create_consultants_table.php ne l'inclut pas dans
     * son ENUM(['Interne','Freelancer']) — l'enregistrer plante actuellement
     * côté base. On élargit l'ENUM pour l'aligner sur ce que l'UI propose déjà.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE consultants MODIFY COLUMN type_consultant ENUM('Interne', 'Freelancer', 'Externe') NOT NULL DEFAULT 'Interne'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE consultants MODIFY COLUMN type_consultant ENUM('Interne', 'Freelancer') NOT NULL DEFAULT 'Interne'");
    }
};
