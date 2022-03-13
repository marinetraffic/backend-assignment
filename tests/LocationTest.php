<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\DTO\LocationOutput;

class LocationTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/v1/locations');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@context' => '/api/v1/contexts/Location',
            '@id' => '/api/v1/locations',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 2696,
            'hydra:view' => [
                "@id" => "/api/v1/locations?page=1",
                "@type" => "hydra:PartialCollectionView",
                "hydra:first" => "/api/v1/locations?page=1",
                "hydra:last" => "/api/v1/locations?page=90",
                "hydra:next" => "/api/v1/locations?page=2"
            ],
        ]);

        $this->assertCount(30, $response->toArray()['hydra:member']);
    }


    public function testMmsiSingleFilter(): void
    {
        $response = static::createClient()->request('GET', '/api/v1/locations?page=1&mmsi=247039300');

        $this->assertResponseIsSuccessful();
        // // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            "@context" => "/api/v1/contexts/Location",
            "@id" => "/api/v1/locations",
            "@type" => "hydra:Collection",
            "hydra:member" => [
              [
                "@type" => "Location",
                "@id" =>"/api/v1/locations/247039300",
                "mmsi" => 247039300,
                "geoLocation" => [
                  "@type" => "GeoLocationOutput",
                ]
              ]
            ],
        ]);

          $this->assertJsonContains([
            "hydra:totalItems" => 869,
            "hydra:view" => [
              "@id" => "/api/v1/locations?mmsi=247039300&page=1",
              "@type" => "hydra:PartialCollectionView",
              "hydra:first" =>"/api/v1/locations?mmsi=247039300&page=1",
              "hydra:last" => "/api/v1/locations?mmsi=247039300&page=29",
              "hydra:next" =>"/api/v1/locations?mmsi=247039300&page=2"
          ]

          ]);
    }

    public function testFilterDateFilter(): void
    {
        $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A40%3A00%2B00%3A00');

        $this->assertResponseIsSuccessful();
        // // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            "@context" => "/api/v1/contexts/Location",
            "@id" => "/api/v1/locations",
            "@type" => "hydra:Collection",
            "hydra:member" => [
              [
                "@type" => "Location",
                "@id" => "/api/v1/locations/247039300",
                "mmsi" => 247039300,
                "geoLocation" => [
                  "@type" => "GeoLocationOutput",
                ]
              ]
            ],
        ]);

          $this->assertJsonContains([
            "hydra:totalItems" => 145,
            "hydra:view" => [
              "@id" =>"/api/v1/locations?timestamp=2013-07-01T17%3A40%3A00%2B00%3A00&page=1",
              "@type" => "hydra:PartialCollectionView",
              "hydra:first" => "/api/v1/locations?timestamp=2013-07-01T17%3A40%3A00%2B00%3A00&page=1",
              "hydra:last" => "/api/v1/locations?timestamp=2013-07-01T17%3A40%3A00%2B00%3A00&page=5",
              "hydra:next" => "/api/v1/locations?timestamp=2013-07-01T17%3A40%3A00%2B00%3A00&page=2"
          ]
          ]);
    }

    public function testFilterGeoFilter(): void
    {
        $response = static::createClient()->request('GET', 'api/v1/locations?page=1&geolocation=42.65908%2C15.54455');

        $this->assertResponseIsSuccessful();
        // // Asserts that the returned content type is JSON-LD (the default)
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // // Asserts that the returned JSON is a superset of this one
        $this->assertJsonContains([
            "@context" => "/api/v1/contexts/Location",
            "@id" => "/api/v1/locations",
            "@type" => "hydra:Collection",
            "hydra:member" => [
              [
                "@type" => "Location",
                "@id" => "/api/v1/locations/247039300",
                "mmsi" => 247039300,
                "geoLocation" => [
                  "@type" => "GeoLocationOutput",
                ]
              ]
            ],
        ]);

          $this->assertJsonContains([
            "hydra:totalItems" => 37,
            "hydra:view" => [
              "@id" =>"/api/v1/locations?geolocation=42.65908%2C15.54455&page=1",
              "@type" => "hydra:PartialCollectionView",
              "hydra:first" => "/api/v1/locations?geolocation=42.65908%2C15.54455&page=1",
              "hydra:last" => "/api/v1/locations?geolocation=42.65908%2C15.54455&page=2",
              "hydra:next" => "/api/v1/locations?geolocation=42.65908%2C15.54455&page=2"
          ]
          ]);
    }

    public function testHomePage(): void
    {
        $response = static::createClient()->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testDocsPage(): void
    {
        $response = static::createClient()->request('GET', '/docs');
        $this->assertResponseIsSuccessful();
    }


}
