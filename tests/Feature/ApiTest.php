<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use WithFaker;

    private $firstTrack = [  // first item on db
        'mmsi' => 247039300,
        'status' => 0,
        'stationId' => 81,
        'speed' => 180,
        'lon' => 15.4415,
        'lat' => 42.75178,
        'course' => 144,
        'heading' => 144,
        'rot' => "",
        'timestamp' => 1372683960
    ];

    /**
     * Tests the index endpoint for the tracks by checking the total amount of the returned tracks
     *
     * @return void
     */
    public function test_index_endpoint()
    {
        $response = $this->get('/api/tracks');
        $response->assertStatus(200)->assertJsonCount(2696);
    }

    /**
     * Tests the show endpoint for a specific track
     *
     * @return void
     */
    public function test_show_endpoint()
    {
        $response = $this->get('/api/tracks/1');
        $response->assertStatus(200)->assertJson($this->firstTrack);
    }

    /**
     * Tests the create endpoint by posting a specific one and checking the response
     *
     * @return void
     */
    public function test_create_endpoint()
    {
        $this->setUpFaker();
        $tmpTrack = $this->firstTrack;
        $tmpTrack['mmsi'] = $this->faker->randomNumber(9);
        $tmpTrack['timestamp'] = Carbon::now()->timestamp;
        $response = $this->postJson('/api/tracks', $tmpTrack);
        $response->assertStatus(201)->assertJson($tmpTrack);
    }

    /**
     * Tests the update endpoint by posting a change to a track
     *
     * @return void
     */
    public function test_update_endpoint()
    {
        $tmpTrack = $this->firstTrack;
        $tmpTrack['timestamp'] = Carbon::now()->timestamp;
        $response = $this->putJson('/api/tracks/1', $tmpTrack);
        $response->assertStatus(202)->assertJson($tmpTrack);
    }

    /**
     * Tests the destroy endpoint by deleting the first track and then validating that was deleted
     *
     * @return void
     */
    public function test_destroy_endpoint()
    {
        $response = $this->delete('/api/tracks/1');
        $response->assertStatus(204);

        $response = $this->get('/api/tracks/1');
        $response->assertStatus(404);
    }

    /**
     * Tests the filtering process. At first, it creates some tracks and then requests them by
     * - the mmsi
     * - the position
     * - and the interval
     *
     * @return void
     */
    public function test_filtering()
    {
        $this->setUpFaker();
        $num= 10;
        $starting_lat = 0;
        $starting_lon = 0;
        $ending_lat =$starting_lat+$num;
        $ending_lon =$starting_lon+$num;;
        $interval_start = Carbon::now()->subDays($num)->timestamp;
        $interval_end = Carbon::now()->timestamp;
        $mmsi = $this->faker->randomNumber(9);

        $this->generateTrackData($num, $mmsi, $starting_lat, $starting_lon);

        $response = $this->get("/api/tracks?mmsi[]={$mmsi}");
        $response->assertStatus(200)->assertJsonCount($num);

        $response = $this->get("/api/tracks?mmsi[]={$mmsi}&range_lat[]={$starting_lat}&range_lat[]={$ending_lat}&range_lon[]={$starting_lon}&range_lon[]={$ending_lon}");
        $response->assertStatus(200)->assertJsonCount($num);

        $response = $this->get("/api/tracks?mmsi[]={$mmsi}&interval[]={$interval_start}&interval[]={$interval_end}");
        $response->assertStatus(200)->assertJsonCount($num);
    }

    private function generateTrackData($n, $mmsi, $starting_lat, $starting_lon)
    {
        for($i = 0; $i < $n; $i++)
        {
            $track = [
                'mmsi' => $mmsi,
                'status' => $this->faker->randomNumber([0, 10]),
                'stationId' => 81,
                'speed' => $this->faker->randomNumber([50, 150]),
                'lon' => $starting_lon + $i,
                'lat' =>  $starting_lat + $i,
                'course' => 144,
                'heading' => 144,
                'rot' => "",
                'timestamp' => Carbon::now()->subDays($n-$i)->timestamp
            ];
            $this->postJson('/api/tracks', $track)->assertStatus(201);
        }
    }
}
