<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShipPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(storage_path('ship_positions.json'));

        $ship_positions = json_decode($json, true);

        foreach ($ship_positions as $ship_position)  {
            foreach ($ship_position as $key => $value) {
                $insertArr[$key] = $value;
            }
            DB::table('ship_positions')->insert($insertArr);
        }
    }
}
