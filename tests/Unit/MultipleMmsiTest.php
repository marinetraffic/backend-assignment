<?php

namespace Tests\Unit;

use App\Models\ShipPosition;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MultipleMmsiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_multiple_mmsi()
    {
//        Artisan::call('migrate');
//        Artisan::call('marine:import-ship-positions');

        $ship_location = ShipPosition::orderBy('id')->take(2)->get()->toArray();

        $response = $this->json('POST', 'api/v1/getVessels',
            [
                'mmsi' => [
                    $ship_location[0]['mmsi'],
                    $ship_location[1]['mmsi']
                ]
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJson($ship_location);
    }
}
