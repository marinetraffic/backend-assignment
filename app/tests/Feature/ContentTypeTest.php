<?php

namespace Tests\Feature;

use App\Enums\ContentTypes;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentTypeTest extends TestCase
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
    public function only_allow_acceptable_content_types()
    {
        $this->artisan('cache:clear');

        foreach (ContentTypes::toArray() as $contentType) {
            $response = $this->withHeaders([
                'Content-Type' => $contentType,
            ])->get(route('positions'));

            $response->assertStatus(200);
            $response->assertHeader('Content-Type', $contentType);
        }

        $response = $this->withHeaders([
            'Content-Type' => 'application/vnd.api+json',
        ])->get(route('positions'));

        $response->assertStatus(415);
    }
}
