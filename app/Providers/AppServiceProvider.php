<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
     * By default Laravel uses the 255 characters as a length for the string
     * But By default MySql only supports 767 for the strings that are going top be used
     * as indexes
     * so 255 * 4 = 1020
     * we do *4 due to config\database.php
     * and attribute 'charset' => 'utf8mb4'
     * so 767/4 = 191.75
     * so we will use 191 to avoid any kind of problem with the strings in our migrations
     * 
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
