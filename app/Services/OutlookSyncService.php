<?php

namespace App\Services;

use App\Models\Tache;
use Illuminate\Support\Facades\Log;

/**
 * Point d'extension pour un futur sync à sens unique vers Outlook
 * (Microsoft Graph API). Non implémenté : chaque tâche créée/modifiée
 * passe déjà par ici via TacheObserver, il ne reste qu'à remplacer le
 * corps de sync() par l'appel Graph API le moment venu.
 */
class OutlookSyncService
{
    public function sync(Tache $tache): void
    {
        Log::debug('OutlookSyncService::sync (stub, aucun appel Graph API)', [
            'tache_id' => $tache->id,
        ]);
    }
}
