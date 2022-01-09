<?php

namespace Tests\Unit;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function position_has_attributes()
    {
        $position = Position::factory()->create();

        $this->assertArrayHasKey('mmsi', $position);
        $this->assertArrayHasKey('status', $position);
        $this->assertArrayHasKey('station', $position);
        $this->assertArrayHasKey('speed', $position);
        $this->assertArrayHasKey('lon', $position);
        $this->assertArrayHasKey('lat', $position);
        $this->assertArrayHasKey('course', $position);
        $this->assertArrayHasKey('heading', $position);
        $this->assertArrayHasKey('rot', $position);
        $this->assertArrayHasKey('timestamp', $position);
    }
}
