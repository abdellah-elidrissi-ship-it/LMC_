<?php

namespace App\Services;

use App\Models\Consultant;
use App\Models\Projet;
use App\Models\User;
use App\Notifications\ProjetAssigneNotification;
use App\Notifications\ProjetRetireNotification;

/**
 * Résout un Consultant (ou un User déjà connu) vers le compte User à
 * notifier lors d'une affectation/retrait de projet, quel que soit le
 * mécanisme d'origine (Affectation staffing, chef_projet_id,
 * user_projet_access). Si le consultant n'a pas de compte lié, ne fait
 * rien (même contrainte que le reste de l'app).
 */
class ProjetAccessNotifier
{
    public static function notifierAjout(
        Projet $projet,
        User $assignePar,
        ?Consultant $consultant = null,
        ?User $userDirect = null,
        ?string $role = null
    ): void {
        $user = $userDirect ?? static::resoudreUser($consultant);

        if (!$user) {
            return;
        }

        $user->notify(new ProjetAssigneNotification($projet, $role, $assignePar));
    }

    public static function notifierRetrait(
        Projet $projet,
        User $retirePar,
        ?Consultant $consultant = null,
        ?User $userDirect = null
    ): void {
        $user = $userDirect ?? static::resoudreUser($consultant);

        if (!$user) {
            return;
        }

        $user->notify(new ProjetRetireNotification($projet, $retirePar));
    }

    protected static function resoudreUser(?Consultant $consultant): ?User
    {
        if (!$consultant) {
            return null;
        }

        return User::where('consultant_id', $consultant->id)->first();
    }
}
