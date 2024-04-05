<?php

namespace App\Providers;

use App\Models\Recetas;
use App\Models\User;
use App\Policies\RecetaPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('validateUser', [RecetaPolicy::class, 'validateUser']);
    }
}
