<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('ip_address', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())->response(function() {
                return response('Your return message', 429);
            });
        });
    }
}
