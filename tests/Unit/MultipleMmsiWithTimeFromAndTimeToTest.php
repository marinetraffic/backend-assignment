<?php

namespace Tests\Unit;

use App\Models\ShipPosition;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MultipleMmsiWithTimeFromAndTimeToTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_multiple_mmsi_with_time_from_and_time_to_filter()
    {

        $ship_locations = ShipPosition::where('timestamp', '>=', '1372700290')
            ->where('timestamp', '<=' , '1372700290')->get()->toArray();

        $response = $this->json('POST', 'api/v1/getVessels',
            [
                'time_from' => '1372700280',
                'time_to' => '1372700290'
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJson($ship_locations);
    }
}
