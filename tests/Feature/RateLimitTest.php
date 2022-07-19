<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Tests\TestCase;

class RateLimitTest extends TestCase
{
    public function test_rate_limiting_after_allowed_requests(){
        config(['app.requests_allowed_per_hour' => 5]);

        for ($i=0; $i < 5; $i++) { 
            $this->getJson('/api/v1')->assertOk();
        }

        $this->expectException(ThrottleRequestsException::class);
        $response = $this->withoutExceptionHandling()->getJson('/api/v1')->assertStatus(429);
        
    }
}
