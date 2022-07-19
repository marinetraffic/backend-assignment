<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestLogginTest extends TestCase
{
    public function testLogsApiRequest(){
        $response = $this->getJson("/api/v1");
        $response->assertOk();
        $this->assertDatabaseHas("incoming_requests", [
            'method' => "GET",
            'status_code' => "200"
        ]);
    }
}
