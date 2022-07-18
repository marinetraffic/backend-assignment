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
        // ->assertJsonFragment([
        //     'mmsi' => "247039300",
        //     'stationId' => "83",
        //     'lat' => "43.81345",
        //     'lon' => "14.36933",
        //     'speed' => "157"
        // ]);
    }
}
