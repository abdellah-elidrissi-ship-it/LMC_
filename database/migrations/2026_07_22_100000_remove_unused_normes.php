<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Réduit la liste des normes proposées en section C (Normes applicables) aux
 * seules retenues par le client. Vérifié avant application : les 8 normes
 * retirées ci-dessous ont 0 ligne dans projet_normes (aucun projet réel ne les
 * utilise), donc suppression directe sans risque de perte de données.
 *
 * "37001" mentionné par l'utilisateur comme 7e norme à garder n'est PAS traité
 * ici (confirmation en attente : nouvelle norme ISO 37001 à ajouter, ou faute
 * de frappe pour une norme existante ?).
 */
return new class extends Migration
{
    private array $codesASupprimer = [
        'ISO 19011:2018',
        'ISO 13485:2016',
        'ISO 27001:2022',
        'ISO 31000:2018',
        'ISO 26000',
        'IATF 16949:2016',
        'Bonnes pratiques d’Hygiène',
        'ISO 31001:2025',
    ];

    public function up(): void
    {
        DB::table('normes')->whereIn('code_norme', $this->codesASupprimer)->delete();
    }

    public function down(): void
    {
        foreach ($this->codesASupprimer as $code) {
            if (!DB::table('normes')->where('code_norme', $code)->exists()) {
                DB::table('normes')->insert([
                    'code_norme' => $code,
                    'description' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
};
