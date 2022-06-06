<?php

namespace App\Providers;

use App\Interfaces\GenerateAppropriateContentTypeResponseServiceInterface;
use App\Interfaces\VesselPositionFilterServiceInterface;
use App\Interfaces\VesselPositionServiceInterface;
use App\Services\GenerateAppropriateContentTypeResponseService;
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
        $this->app->bind(GenerateAppropriateContentTypeResponseServiceInterface::class, GenerateAppropriateContentTypeResponseService::class);
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
