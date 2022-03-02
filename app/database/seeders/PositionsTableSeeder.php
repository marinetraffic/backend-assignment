<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Positions;
use File;

class PositionsTableSeeder extends Seeder {
    public function run() {
        Positions::truncate();

        // Get content of file.
        $json = File::get("database/data/ship_positions.json");
        $positions = json_decode($json);

        foreach ($positions as $key => $value) {
            Positions::create([
                "mmsi" => $value->mmsi,
                "status" => $value->status,
                "stationid" => $value->stationId,
                "speed" => $value->speed,
                "lon" => $value->lon,
                "lat" => $value->lat,
                "course" => $value->course,
                "heading" => $value->heading,
                "rot" => $value->rot,
                "timestamp" => $value->timestamp
            ]);
        }
    }
}
