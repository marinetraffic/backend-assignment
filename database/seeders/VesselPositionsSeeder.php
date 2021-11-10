<?php

namespace Database\Seeders;

use App\Models\VesselPosition;
use Illuminate\Database\Seeder;
use File;

class VesselPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds by reading from given json file
     *
     * @return void
     */
    public function run()
    {
        VesselPosition::truncate();

        $json = File::get("ship_positions.json");
        $shipPositions = json_decode($json);
        foreach ($shipPositions as $key => $shipPosition) {
            VesselPosition::create([
                VesselPosition::FIELD_MMSI => $shipPosition->mmsi,
                VesselPosition::FIELD_STATUS => $shipPosition->status,
                VesselPosition::FIELD_STATION_ID => $shipPosition->stationId,
                VesselPosition::FIELD_SPEED => $shipPosition->speed,
                VesselPosition::FIELD_LON => $shipPosition->lon,
                VesselPosition::FIELD_LAT => $shipPosition->lat,
                VesselPosition::FIELD_COURSE => $shipPosition->course,
                VesselPosition::FIELD_HEADING => $shipPosition->heading,
                VesselPosition::FIELD_ROT => $shipPosition->rot,
                VesselPosition::FIELD_TIMESTAMP => $shipPosition->timestamp,
            ]);
        }
    }
}
