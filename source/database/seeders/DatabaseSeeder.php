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
        //added switching mechanism, so that Tests would use a much smaller subset of data.
        if (env("APP_ENV") == "testing"){
            $this->call([TestShippositionSeeder::class]);
        }
        else {
            $this->call([ShipPositionTableSeeder::class]);
        }
    }
}
