<?php

namespace Tests\Feature;

use App\Enums\ContentTypes;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RateLimiterTest extends TestCase
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
    public function user_cannot_exceed_request_limit()
    {
        $this->artisan('cache:clear');

        for ($requestCounter = 0; $requestCounter < config('app.rate_limit'); $requestCounter++) {
            $response = $this->json('GET', route('positions'));

            echo $response->status();

            $response->assertStatus(200);
        }
        $response = $this->json('GET', route('positions'));
        $response->assertStatus(429);
    }
}
