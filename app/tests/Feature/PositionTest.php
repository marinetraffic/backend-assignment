<?php

namespace Tests\Feature;

use App\Enums\ContentTypes;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    protected $positions;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('cache:clear');

        $this->positions = Position::factory(100)->create();
    }

    /** @test */
    public function it_can_be_filtered_by_mmsi()
    {
        $position = $this->positions->first();

        $response = $this->withHeaders([
            'Content-Type' => ContentTypes::JSON
        ])->get(route('positions', ['mmsi' => $position->mmsi]));

        $responseData = $response->json()['data'];

        foreach ($responseData as $record){
            $this->assertEquals($position->mmsi, $record['mmsi']);
        }

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_be_filtered_by_lon_range()
    {
        $position = $this->positions->first();
        $maxLon = $position->lon;
        $minLon = $maxLon - 1;

        $response = $this->withHeaders([
            'Content-Type' => ContentTypes::JSON
        ])->get(route('positions', [
            'maxLon' => $maxLon,
            'minLon' => $minLon
        ]));

        $responseData = $response->json()['data'];

        if(count($responseData) > 0) {
            foreach ($responseData as $record) {
                $this->assertLessThanOrEqual($maxLon, $record['lon']);
                $this->assertGreaterThanOrEqual($minLon, $record['lon']);
            }
        }

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_be_filtered_by_lat_range()
    {
        $position = $this->positions->first();
        $maxLat = $position->lat;
        $minLat = $maxLat - 1;

        $response = $this->withHeaders([
            'Content-Type' => ContentTypes::JSON
        ])->get(route('positions', [
            'maxLat' => $maxLat,
            'minLat' => $minLat
        ]));

        $responseData = $response->json()['data'];

        if(count($responseData) > 0) {
            foreach ($responseData as $record) {
                $this->assertLessThanOrEqual($maxLat, $record['lat']);
                $this->assertGreaterThanOrEqual($minLat, $record['lat']);
            }
        }

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_be_filtered_by_datetime_range()
    {
        $position = $this->positions->first();

        $toDatetime = Carbon::create($position->timestamp)->addDays(1)->toISOString();
        $fromDatetime = Carbon::create($position->timestamp)->toISOString();

        $response = $this->withHeaders([
            'Content-Type' => ContentTypes::JSON
        ])->get(route('positions', [
            'fromDatetime' => $fromDatetime,
            'toDatetime' => $toDatetime
        ]));

        $responseData = $response->json()['data'];

        if(count($responseData) > 0) {
            foreach ($responseData as $record) {
                $this->assertLessThanOrEqual($toDatetime, Carbon::create($record['timestamp'])->toISOString());
                $this->assertGreaterThanOrEqual($fromDatetime, Carbon::create($record['timestamp'])->toISOString());
            }
        }

        $response->assertStatus(200);
    }
}
