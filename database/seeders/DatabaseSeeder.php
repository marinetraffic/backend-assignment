<?php

namespace Database\Seeders;

use App\Models\Vessel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds by reading from ship_positions.json
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();
        // Vessel::truncate();
        // DB::table('vessels')->truncate();

        $json = File::get("ship_positions.json");
        $shipPositions = json_decode($json);
        foreach ($shipPositions as $key => $shipPosition) {
            Vessel::create([
                Vessel::FIELD_MMSI => $shipPosition->mmsi,
                Vessel::FIELD_STATUS => $shipPosition->status,
                Vessel::FIELD_STATION_ID => $shipPosition->stationId,
                Vessel::FIELD_SPEED => $shipPosition->speed,
                Vessel::FIELD_LON => $shipPosition->lon,
                Vessel::FIELD_LAT => $shipPosition->lat,
                Vessel::FIELD_COURSE => $shipPosition->course,
                Vessel::FIELD_HEADING => $shipPosition->heading,
                Vessel::FIELD_ROT => $shipPosition->rot,
                Vessel::FIELD_TIMESTAMP => $shipPosition->timestamp,
            ]);
        }
    }
}
