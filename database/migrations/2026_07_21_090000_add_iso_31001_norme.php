<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('normes')->where('code_norme', 'ISO 31001:2025')->exists();

        if (!$exists) {
            DB::table('normes')->insert([
                'code_norme' => 'ISO 31001:2025',
                'description' => 'Système de management du risque',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('normes')->where('code_norme', 'ISO 31001:2025')->delete();
    }
};
