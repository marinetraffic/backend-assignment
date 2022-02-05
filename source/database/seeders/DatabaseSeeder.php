<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env("APP_ENV") == "testing"){
            $this->call([TestShippositionSeeder::class]);
        }
        else {
            $this->call([ShipPositionTableSeeder::class]);
        }
    }
}
