<?php

namespace Tests\Feature;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_example()
    {
        $this->artisan('import:file')->assertNotExitCode(1);

        $this->assertDatabaseCount('positions', Position::count());
    }
}
