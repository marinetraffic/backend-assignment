<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Seeders\TestShippositionSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShipPositionFiltersTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseMigrations;

    //uses a database seeder to seed test database from a small subset of data
    protected $seed = TestShippositionSeeder::class;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mmsi_filter()
    {
        // dd(env('DB_CONNECTION'));
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions?filter[mmsi][]=247039300'); 
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonCount(2);
    }

    public function test_mmsi_multiple_filter()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions?filter[mmsi][]=247039300&filter[mmsi][]=311040700'); 
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonFragment(['mmsi'=> "247039300"]);
        $response->assertJsonFragment(['mmsi'=> "311040700"]);
        $response->assertJsonCount(3);
    }

    public function test_lat_from_filter()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions?filter[lat-from]=40'); 
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonFragment(['mmsi'=> "247039300"]);
        $response->assertJsonCount(2);
    }

    public function test_lat_to_filter()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions?filter[lat-to]=35'); 
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonFragment(['mmsi'=> "311040700"]);
        $response->assertJsonCount(1);
    }

    public function test_lon_from_filter()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions?filter[lon-from]=15'); 
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonFragment(['mmsi'=> "247039300"]);
        $response->assertJsonFragment(['mmsi'=> "311040700"]);
        $response->assertJsonCount(3);
    }

    public function test_lon_to_filter()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions?filter[lon-to]=12'); 
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonFragment(['mmsi'=> "311486000"]);
        $response->assertJsonCount(1);
    }

    public function test_timestamp_from_filter()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions?filter[timestamp-from]=1372646750'); 
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonFragment(['mmsi'=> "247039300"]);
        $response->assertJsonCount(1);
    }

    public function test_timestamp_to_filter()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions?filter[timestamp-to]=1372635250'); 
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonFragment(['mmsi'=> "311486000"]);
        $response->assertJsonCount(1);
    }
}
