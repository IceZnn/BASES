<?php

namespace App\Providers;

use App\Models\Chamado;
use App\Observers\ChamadoObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Chamado::observe(ChamadoObserver::class);
    }
}
