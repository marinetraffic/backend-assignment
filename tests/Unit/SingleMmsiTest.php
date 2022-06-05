<?php

namespace Tests\Unit;

use App\Models\ShipPosition;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SingleMmsiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_single_mmsi()
    {


        $ship_location = ShipPosition::orderBy('id')->first()->toArray();

        $response = $this->json('POST', 'api/v1/getVessels',
            [
                'mmsi' => [$ship_location['mmsi']],
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJson([$ship_location]);
    }
}
