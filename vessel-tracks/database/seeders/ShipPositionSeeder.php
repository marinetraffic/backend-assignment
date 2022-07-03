<?php

namespace Database\Seeders;

use App\Models\ShipPosition;
use Illuminate\Database\Seeder;
use File;
use Illuminate\Support\Facades\Storage;

class ShipPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $truncate = env("TRUNCATE_SHIP_POSITIONS");
        $truncate ? ShipPosition::truncate() : "" ;

        $file =Storage::disk('local')->get('ship_positions.json');
        $shipPositions = json_decode($file);
        foreach ($shipPositions as $shipPosition) {
            ShipPosition::create([
                "mmsi" => $shipPosition->mmsi,
                "status" => $shipPosition->status,
                "station_id" => $shipPosition->stationId,
                "speed" => $shipPosition->speed,
                "longitude" => $shipPosition->lon,
                "latitude" => $shipPosition->lat,
                "course" => $shipPosition->course,
                "heading" => $shipPosition->heading,
                "rot" => $shipPosition->rot,
                "timestamp" => $shipPosition->timestamp,
            ]);
        }
    }
}
