<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class EmptyMmsiWithNoFiltering extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_empty_mmsi_id_with_no_filtering()
    {
        Artisan::call('migrate');
        Artisan::call('marine:import-ship-positions');

        $response = $this->json('POST', 'api/v1/getVessels',
            [
                'mmsi' => [],
            ]
        );

        $response
            ->assertStatus(400)
            ->assertJson(['error' => 'You have to provide at least one Mmsi Id or filtering method!']);

    }
}
