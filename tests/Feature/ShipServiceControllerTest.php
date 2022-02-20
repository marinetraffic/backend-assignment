<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\VarDumper\VarDumper;
use Tests\TestCase;

class ShipServiceControllerTest extends TestCase
{


    protected $mmsi='311486000';

    public function test_is_json()
    {
        $response=$this->get("/api/ship?mmsi={$this->mmsi}&type=json");
        json_decode($response->content());
        if (json_last_error() !== 0) {
            $this->assertTrue('is not application/json');
        }
        $response->assertStatus(200);
    }

    public function test_is_xml()
    {
        $response=$this->get("/api/ship?mmsi={$this->mmsi}&type=xml");
        $doc = @simplexml_load_string($response->content());
        if (!$doc) {
            $this->assertTrue('is not application/xml');
        }
        $response->assertStatus(200);
    }

    public function test_is_csv()
    {
        $response=$this->get("/api/ship?mmsi={$this->mmsi}&type=csv");
        $response->assertStatus(200);
    }

    public function test_is_hal()
    {
        $response=$this->get("/api/ship?mmsi={$this->mmsi}&type=hal");
        json_decode($response->content());
        if (json_last_error() !== 0) {
            $this->assertTrue('is not application/hal+json');
        }
        $response->assertStatus(200);
    }
}
