<?php

namespace Database\Seeders;

use App\Models\VesselPosition;
use Illuminate\Database\Seeder;
use File;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Carbon\Carbon;

class VesselPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(base_path("database\data\ship_positions.json"));
        $pos_data = json_decode($json);

        foreach ($pos_data as $key => $value) {
            $pos = new VesselPosition();
            $pos->mmsi = $value->mmsi;
            $pos->ais_status = $value->status;
            $pos->station_id = $value->stationId;
            $pos->speed = $value->speed;
            $pos->timestamp = Carbon::createFromTimestamp($value->timestamp);
            $pos->position = new Point($value->lat, $value->lon);
            $pos->heading = $value->heading;
            $pos->course = $value->course;
            $pos->rot = $value->rot;
            $pos->save();
        }
    }
}
