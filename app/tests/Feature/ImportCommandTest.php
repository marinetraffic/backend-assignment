<?php

namespace Tests\Feature;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function records_are_persisted_to_db()
    {
        $this->artisan('import:file')->assertNotExitCode(1);

        $this->assertDatabaseCount('positions', Position::count());
    }
}
