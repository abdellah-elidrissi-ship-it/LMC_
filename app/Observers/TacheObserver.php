<?php

namespace App\Observers;

use App\Models\Tache;
use App\Services\OutlookSyncService;

class TacheObserver
{
    public function __construct(protected OutlookSyncService $outlookSync)
    {
    }

    public function created(Tache $tache): void
    {
        $this->outlookSync->sync($tache);
    }

    public function updated(Tache $tache): void
    {
        $this->outlookSync->sync($tache);
    }
}
