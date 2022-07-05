<?php

namespace Tests\Unit;

use App\Models\ShipPosition;
use Tests\TestCase;

class PositionFiltersTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetAllPositions()
    {
        $this->json('GET','api/position')->assertStatus(200);
    }

    public function testFilterByMmsi()
    {
        $position = ShipPosition::factory()->count(1)->create();

        $mmsi = $position->first()->mmsi;


        $response = $this->getJson('/api/position?mmsi='.$mmsi);
        $response->assertStatus(200)->assertJson([
            0 => [
                'mmsi' => $mmsi
            ]
        ]);
    }

    public function testFilterByLatLong()
    {
        $position = ShipPosition::factory()->count(1)->create();
        $lat = $position->first()->latitude;
        $long = $position->first()->longitude;

        $response = $this->getJson('/api/position?latlong='.$lat.','.$long);
        $response->assertStatus(200)->assertJson([
            0 => [
                'latitude' => $lat,
                'longitude' => $long
            ]
        ]);
    }

}
