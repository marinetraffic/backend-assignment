<?php

namespace App\Console\Commands;

use App\Models\ShipPosition;
use Illuminate\Console\Command;

class ImportShipPositionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marine:import-ship-positions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = public_path() . "/ship_positions/ship_positions.json";
        $ship_positions = json_decode(file_get_contents($path), true);

        foreach ($ship_positions as $ship_position) {

            ShipPosition::insert( [
                "mmsi" => $ship_position['mmsi'],
                "status" => $ship_position['status'],
                "stationId" => $ship_position['stationId'],
                "speed" => $ship_position['speed'],
                "lon" => $ship_position['lon'],
                "lat" => $ship_position['lat'],
                "course" => $ship_position['course'],
                "heading" => $ship_position['heading'],
                "rot" => $ship_position['rot'],
                "timestamp" => $ship_position['timestamp'],
            ]);
        }

        return self::SUCCESS;
    }
}
