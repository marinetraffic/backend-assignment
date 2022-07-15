<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_root_ShipPosition()
    {
        $response = $this->get('/api/ShipPosition');

        $response->assertStatus(200);
    }

    /**
     * A basic test with query parameters.
     *
     * @return void
     */
    public function test_query_parameters()
    {
        $response = $this->get('/api/ShipPosition?MMSI=247039300&MinTimestamp=1372683960');

        $response->assertStatus(200);
    }

    /**
     * A basic test with json request body
     *
     * @return void
     */
    public function test_json()
    {
        $response = $this->getJson('/api/ShipPosition',[
            "MMSI" => 247039300,
            "MinTimestamp" => 1372683960,
        ]);

        $response->assertStatus(200);
    }
}
