<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\RegistroActividadMaterial;
use App\Observers\RegistroActividadMaterialObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
        {
            // REGISTRAR AQUÍ EL OBSERVER
            RegistroActividadMaterial::observe(RegistroActividadMaterialObserver::class);
        }
}
