<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * La permission 'voir_consultants' gouvernait auparavant aussi la
 * création/modification/suppression des consultants (routes/web.php).
 * Ces actions sont désormais protégées par des permissions dédiées
 * (creer_consultants, modifier_consultants, supprimer_consultants).
 * Cette migration préserve l'accès effectif des comptes existants qui
 * avaient déjà voir_consultants=yes, en leur accordant aussi les 3
 * nouvelles permissions.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereNotNull('permissions')
            ->orderBy('id')
            ->each(function ($user) {
                $perms = json_decode($user->permissions, true) ?? [];

                if (($perms['voir_consultants'] ?? 'no') !== 'yes') {
                    return;
                }

                $perms['creer_consultants'] = 'yes';
                $perms['modifier_consultants'] = 'yes';
                $perms['supprimer_consultants'] = 'yes';

                DB::table('users')->where('id', $user->id)->update([
                    'permissions' => json_encode($perms),
                ]);
            });
    }

    public function down(): void
    {
        DB::table('users')
            ->whereNotNull('permissions')
            ->orderBy('id')
            ->each(function ($user) {
                $perms = json_decode($user->permissions, true) ?? [];

                unset($perms['creer_consultants'], $perms['modifier_consultants'], $perms['supprimer_consultants']);

                DB::table('users')->where('id', $user->id)->update([
                    'permissions' => json_encode($perms),
                ]);
            });
    }
};
