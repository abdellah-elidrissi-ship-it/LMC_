<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * 7e norme confirmée par l'utilisateur pour la section C (Normes applicables) —
 * "37001" mentionné précédemment était une coquille pour ISO 31007:2025.
 * ISO 31001:2025 (supprimée par la migration précédente, 0 usage) n'existe
 * plus : impossible de la "renommer", on ajoute donc une norme neuve.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!DB::table('normes')->where('code_norme', 'ISO 31007:2025')->exists()) {
            DB::table('normes')->insert([
                'code_norme' => 'ISO 31007:2025',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('normes')->where('code_norme', 'ISO 31007:2025')->delete();
    }
};
