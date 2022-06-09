<?php

namespace Tests\Feature;

use Tests\TestCase;

class VesselPositionApiTest extends TestCase
{
    private $lat_from,$lat_to,$lon_from,$lon_to;

    public function __construct()
    {
        parent::__construct();
        $this->lat_from =  rand(40*10,45*10)/10;
        $this->lat_to =  rand($this->lat_from*10,45*10)/10;
        $this->lon_from =  rand(13*10,16*10)/10;
        $this->lon_to =  rand($this->lon_from*10,16*10)/10;
        $this->mmsi = 247039300;
    }

    /**
     * Test 406 response without header.
     *
     * @return void
     */
    public function test_without_header()
    {
        $response = $this->get('/api/v1/vessel-positions');
        $response->assertStatus(406);
    }

    /**
     * A basic test for json response.
     *
     * @return void
     */
    public function test_json_header()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/v1/vessel-positions');
        $response->assertStatus(200);
        $response->assertHeader("Content-Type", "application/json");
    }

    /**
     * A basic test for csv response.
     *
     * @return void
     */
    public function test_csv_header()
    {
        $response = $this->withHeaders([
            'Accept' => 'text/csv',
        ])->get('/api/v1/vessel-positions');
        $response->assertStatus(200);
        $response->assertHeader("Content-Type", "text/csv");
        $response->assertDownload("data.csv");


    }

    /**
     * A basic test for json ld response.
     *
     * @return void
     */
    public function test_ld_json_header()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/ld+json',
        ])->get('/api/v1/vessel-positions');
        $response->assertStatus(200);
        $response->assertHeader("Content-Type", "application/ld+json");
        $response->assertJson([
            '@context' => "https://schema.org",
        ]);
    }

    /**
     * A basic test for json response filtered with mmsi.
     *
     * @return void
     */
    public function test_json_header_with_mmsi_filtering()
    {
        $mmsi_test = 247039300;
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get("/api/v1/vessel-positions?mmsi_list[]={$mmsi_test}");
        $response->assertStatus(200);
        $response->assertHeader("Content-Type", "application/json");
        $content = json_decode($response->content());
        foreach ($content as $item) {
            $this->assertEquals($item->mmsi, $mmsi_test);
        }

    }

    /**
     * A basic test for json response filtered with mmsi.
     *
     * @return void
     */
    public function test_json_header_with_multiple_mmsi_filtering()
    {
        $mmsi_test = 247039300;
        $mmsi_test_2 = 311486000;
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get("/api/v1/vessel-positions?mmsi_list[]={$mmsi_test}&mmsi_list[]={$mmsi_test_2}");
        $response->assertStatus(200);
        $response->assertHeader("Content-Type", "application/json");
        $content = json_decode($response->content());
        foreach ($content as $item) {
            $this->assertTrue($item->mmsi == $mmsi_test || $item->mmsi == $mmsi_test_2);
        }

    }

    /**
     * A basic test for json response filtered with lat filtering
     *
     * @return void
     */
    public function test_json_header_with_lat_filtering()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get("/api/v1/vessel-positions?lat_from={$this->lat_from}&lat_to={$this->lat_to}");
        $response->assertStatus(200);
        $response->assertHeader("Content-Type", "application/json");
        $content = json_decode($response->content());
        foreach ($content as $item) {
            $this->assertGreaterThanOrEqual($this->lat_from, $item->position->coordinates[1]);
            $this->assertLessThanOrEqual($this->lat_to, $item->position->coordinates[1]);
        }

    }

    /**
     * A basic test for json response filtered with lon filtering
     *
     * @return void
     */
    public function test_json_header_with_lon_filtering()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get("/api/v1/vessel-positions?lon_from={$this->lon_from}&lon_to={$this->lon_to}");
        $response->assertStatus(200);
        $response->assertHeader("Content-Type", "application/json");
        $content = json_decode($response->content());
        foreach ($content as $item) {
            $this->assertGreaterThanOrEqual($this->lon_from, $item->position->coordinates[0]);
            $this->assertLessThanOrEqual($this->lon_to, $item->position->coordinates[0]);
        }

    }
    /**
     * A basic test for json+ld response filtered with lon filtering
     *
     * @return void
     */
    public function test_ld_json_header_lon_filter()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/ld+json',
        ])->get("/api/v1/vessel-positions?lon_from={$this->lon_from}&lon_to={$this->lon_to}");

        $content = json_decode($response->content());
        foreach ($content->{"@graph"}  as $item) {
            $this->assertGreaterThanOrEqual($this->lon_from, $item->lon);
            $this->assertLessThanOrEqual($this->lon_to, $item->lon);
        }
    }
    /**
     * A basic test for json+ld response filtered with mmsi filtering
     *
     * @return void
     */
    public function test_ld_json_header_mmsi_filter()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/ld+json',
        ])->get("/api/v1/vessel-positions?mmsi_list[]={$this->mmsi}");

        $content = json_decode($response->content());
        foreach ($content->{"@graph"}  as $item) {
            $this->assertEquals($this->mmsi, $item->mmsi);
        }
    }

    /**
     * A basic test for json+ld response filtered with lat filtering
     *
     * @return void
     */
    public function test_ld_json_header_lat_filter()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/ld+json',
        ])->get("/api/v1/vessel-positions?lat_from={$this->lat_from}&lat_to={$this->lat_to}");
        $content = json_decode($response->content());
        foreach ($content->{"@graph"} as $item) {
            $this->assertGreaterThanOrEqual($this->lat_from, $item->lat);
            $this->assertLessThanOrEqual($this->lat_to, $item->lat);
        }
    }
}
