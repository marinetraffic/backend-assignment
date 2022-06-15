<?php

namespace Database\Seeders;

use App\Models\Position;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function run()
    {
        //Position::truncate();

        $json_positions = File::get("database/data/ship_positions.json");

        $positions = json_decode($json_positions);

        foreach ($positions as $key => $value) {
            Position::create([
                "mmsi" => $value->mmsi,
                "status" => $value->status,
                "station_id" => $value->stationId,
                "speed" => $value->speed,
                "longitude" => $value->lon,
                "latitude" => $value->lat,
                "course" => $value->course,
                "heading" => $value->heading,
                "rot" => $value->rot,
                "timestamp" => $value->timestamp,
            ]);
        }
    }
}
