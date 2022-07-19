<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VesselTrackingTest extends TestCase
{
    public function testCanFilterBySingleMmsi(){
        $mmsi = "247039300";
        
        $response = $this->getJson("/api/v1/positions?mmsi={$mmsi}");

        $response->assertOk();
        $response->assertJsonCount(869, 'data');
    }

    public function testCanFilterByMultipleMmsi(){
        $mmsi = "247039300,311040700";

        $response = $this->getJson("/api/v1/positions?mmsi={$mmsi}");

        $response->assertOk()->assertJsonCount(1836, 'data');
    }

    public function testFailsWithSingleTimeIntervalFilterValue(){
        $time = 1372697580;

        $this->expectExceptionMessage("Time interval must contain exactly 2 values");

        $response = $this->withoutExceptionHandling()->getJson("/api/v1/positions?time_interval={$time}");
    }

    public function testCanFilterWithTimeInterval(){
        $time = "1372697580,1372700520";

        $response = $this->getJson("/api/v1/positions?time_interval={$time}");

        $response->assertOk()->assertJsonCount(1971, 'data');
    }

    public function testCanFilterWithLatitudeAndLongitude(){

        $lat = "42.05627,41.57028";

        $lon = "16.57032,16.25182";

        $response = $this->getJson("/api/v1/positions?lat={$lat}&lon={$lon}")->dump();

        $response->assertOk()->assertJsonFragment([
            'mmsi' => "247039300",
            'stationId' => "89",
            'lat' => "41.98653",
            'lon' => "16.25182",
            'speed' => "157",
            'course' => "149",
            'timestamp' => "1372700340"
        ]);
    }
}
