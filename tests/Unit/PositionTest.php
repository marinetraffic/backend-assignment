<?php

namespace Tests\Unit;

use App\Models\Position;
use Tests\TestCase;

class PositionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_for_all_record()
    {
        //\Artisan::call('db:seed --class=PositionSeeder');
        Position::factory()->count(3)->create();

        $response = $this->getJson('/api/position');


        $response->assertStatus(200)->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'mmsi',
                    'status',
                    'station_id',
                ]
            ]
        ]);
    }


    public function test_for_single_mmsi()
    {

        $position = Position::factory()->count(3)->create();

        $mmsi = $position->first()->mmsi;


        $response = $this->getJson('/api/position?mmsi='.$mmsi);

        $response->assertStatus(200)->assertJson([
            'current_page' => 1,
            'data' => [
                0 => [
                    'mmsi' => $mmsi
                ]
            ]
        ]);
    }

    public function test_for_multiple_mmsi(){
        $position = Position::factory()->count(3)->create();

        $mmsi = $position->take(2);

        $response = $this->getJson('/api/position?mmsi='.$mmsi[0]['mmsi'].','.$mmsi[1]['mmsi']);

        $response->assertStatus(200)->assertJson([
            'current_page' => 1,
            'data' => [
                0 => [
                    'mmsi' => $mmsi[0]['mmsi']
                ],
                1 => [
                    'mmsi' => $mmsi[1]['mmsi']
                ]
            ]
        ]);

    }

    public function test_for_rate_limiting(){
        $response = $this->call('GET', '/api/position');
        $header_value = $response->headers->get('X-Ratelimit-Limit');
        $this->assertEquals(10, $header_value);
    }

    public function test_check_if_log_was_written(){
        file_put_contents(storage_path('logs/marine.log'),'');
        $this->call('GET', '/api/position');
        $logFile = file(storage_path().'/logs/marine.log');
        $logCollection = [];
        foreach ($logFile as $line_num => $line) {
            $logCollection[] = array('line'=> $line_num, 'content'=> htmlspecialchars($line));
        }
        $this->assertCount(1, $logCollection);
    }

    public function test_for_json_response(){
        Position::factory()->count(3)->create();

        $response = $this->getJson('/api/position');

        $response->assertHeader('content-type', 'application/json');
    }

    public function test_for_xml_response(){
        Position::factory()->count(3)->create();

        $response = $this->getJson('/api/position', [
            'content-type' => 'application/xml'
        ]);

        $response->assertHeader('content-type', 'application/xml');
    }


    public function test_for_csv_response(){
        Position::factory()->count(3)->create();

        $response = $this->getJson('/api/position', [
            'content-type' => 'test/csv'
        ]);

        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }


}
