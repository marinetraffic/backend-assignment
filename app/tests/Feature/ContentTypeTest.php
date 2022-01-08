<?php

namespace Tests\Feature;

use App\Enums\ContentTypes;
use Tests\TestCase;

class ContentTypeTest extends TestCase
{
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
