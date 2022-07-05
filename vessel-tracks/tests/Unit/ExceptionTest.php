<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testInvalideLatLong()
    {
        $response=$this->getJson('/api/position?latlong=2')->assertStatus(422);

    }

    public function testInvalidDate()
    {
        $response=$this->getJson('/api/position?time=2')->assertStatus(422);

    }

    public function testEndDateBiggerThanStartDate()
    {
        $response=$this->getJson('/api/position?time=2013-07-01T04:00:00,2013-06-01T08:00:00')->assertStatus(422);

    }


}
