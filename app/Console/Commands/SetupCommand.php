<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupCommand extends Command
{
    protected $signature = 'app:setup';
    protected $description = 'Setups the application';

    public function handle()
    {
        Artisan::call('migrate:fresh');
        $this->info("Database migrated");
        Artisan::call('db:populate');
        $this->info("Database populated");
        return 0;
    }
}
