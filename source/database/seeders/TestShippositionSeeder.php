<?php

namespace Database\Seeders;

use App\Models\Shipposition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TestShippositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ship_positions')->delete();
        $json = File::get("database/data/testdata_ship_positions.json");
        $data = json_decode($json);
        foreach ($data as $row) {
            Shipposition::create(array(
                'mmsi' => $row->mmsi,
                'status' => $row->status,
                'station_id' => $row->stationId,
                'speed' => $row->speed,
                'lon' => $row->lon,
                'lat' => $row->lat,
                'course' => $row->course,
                'heading' => $row->heading,
                'rot' => $row->rot,
                'timestamp' => $row->timestamp,
            ));
        }
    }
}
