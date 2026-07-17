<?php

namespace App\Providers;

use App\Models\Tache;
use App\Observers\TacheObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Tache::observe(TacheObserver::class);
    }
}