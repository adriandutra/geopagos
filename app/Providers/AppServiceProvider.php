<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\TorneoRepositoryInterface;
use App\Domain\Repositories\JugadorRepositoryInterface;
use App\Application\Infraestructure\Persistence\EloquentJugadorRepository; 
use App\Application\Infraestructure\Persistence\EloquentTorneoRepository; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(JugadorRepositoryInterface::class, EloquentJugadorRepository::class);
        $this->app->bind(TorneoRepositoryInterface::class, EloquentTorneoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
