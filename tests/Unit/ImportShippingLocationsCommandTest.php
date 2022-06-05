<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ImportShippingLocationsCommandTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_import_shipping_locations_command()
    {
        //Artisan::call('migrate');

        $this->artisan('marine:import-ship-positions', [])
            ->expectsOutput('Ship Location Import From JSON started')
            ->expectsOutput('Ship Locations Imported');

        $this->assertDatabaseHas('ship_positions', [
            'id' => '1',
            'mmsi' => '247039300',
            'status' => '0',
            'stationId' => "81",
            "speed" => "180",
            "lon" => "15.44150",
            "lat" => "42.75178",
            "course" => "144",
            "heading" => "144",
            "rot" => "",
            "timestamp" => "1372683960"
        ]);

    }
}
