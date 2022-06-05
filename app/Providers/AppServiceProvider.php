<?php

namespace App\Providers;

use App\Interfaces\VesselPositionFilterServiceInterface;
use App\Interfaces\VesselPositionServiceInterface;
use App\Services\VesselPositionFilterService;
use App\Services\VesselPositionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(VesselPositionServiceInterface::class, VesselPositionService::class);
        $this->app->bind(VesselPositionFilterServiceInterface::class, VesselPositionFilterService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
