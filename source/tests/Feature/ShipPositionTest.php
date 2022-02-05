<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Seeders\TestShippositionSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShipPositionTest extends TestCase
{
    use RefreshDatabase; //this Trait allows to reseed the database per each test.

    protected $test_record_mmsi = "247039300";

    /**a
     * A basic feature test example.
     *
     * @return void
     */
    public function test_json_header()
    {
        
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/json/shippositions'); // route here differs, because of switch in routes. that makes the route invisible during testing. but adding routes file specifically 

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJsonStructure([
            '*' => [
                'mmsi',
                'status',
                'station_id',
                'speed',
                'lon',
                'lat',
                'course',
                'heading',
                'rot',
                'timestamp'
            ]
        ]);
        $response->assertJsonFragment(['mmsi'=> $this->test_record_mmsi]);
        
    }

    public function test_json_api_header()
    {
        
        $response = $this->withHeaders([
            'Accept' => 'application/vnd.api+json'
        ])->get('/api/v1/vndjson/shippositions');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.api+json');
        $response->assertJsonStructure([
            'jsonapi' => [
                'version'
            ],
            'data' => [
                '*' => [
                    'type',
                    'id', //wanted to use 'mmsi', but according to JSON:API specification, id field cannot be renamed
                    'attributes' => [
                        'status',
                        'station_id',
                        'speed',
                        'lon',
                        'lat',
                        'course',
                        'heading',
                        'rot',
                        'timestamp'
                    ],
                    'links' => [
                        'self'
                    ]
                ]
            ]
            
        ]);
        $response->assertJsonFragment(['id'=> $this->test_record_mmsi]);
        
    }

    public function test_xml_header()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/xml'
        ])->get('/api/v1/xml/shippositions'); 

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee("<mmsi>".$this->test_record_mmsi."</mmsi>",false);
    }

    public function test_csv_header()
    {
        $response = $this->withHeaders([
            'Accept' => 'text/csv; charset=UTF-8'
        ])->get('/api/v1/csv/shippositions'); 

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertDownload();
    }
}
