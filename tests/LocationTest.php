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
          "@id" => "/api/v1/locations/247039300",
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
        "hydra:first" => "/api/v1/locations?mmsi=247039300&page=1",
        "hydra:last" => "/api/v1/locations?mmsi=247039300&page=29",
        "hydra:next" => "/api/v1/locations?mmsi=247039300&page=2"
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
        "@id" => "/api/v1/locations?timestamp=2013-07-01T17%3A40%3A00%2B00%3A00&page=1",
        "@type" => "hydra:PartialCollectionView",
        "hydra:first" => "/api/v1/locations?timestamp=2013-07-01T17%3A40%3A00%2B00%3A00&page=1",
        "hydra:last" => "/api/v1/locations?timestamp=2013-07-01T17%3A40%3A00%2B00%3A00&page=5",
        "hydra:next" => "/api/v1/locations?timestamp=2013-07-01T17%3A40%3A00%2B00%3A00&page=2"
      ]
    ]);
  }

  public function testFilterGeoFilter(): void
  {
    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'application/ld+json']]);

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
      "hydra:totalItems" => 67,
      "hydra:view" => [
        "@id" => "/api/v1/locations?geolocation=42.65908%2C15.54455&page=1",
        "@type" => "hydra:PartialCollectionView",
        "hydra:first" => "/api/v1/locations?geolocation=42.65908%2C15.54455&page=1",
        "hydra:last" => "/api/v1/locations?geolocation=42.65908%2C15.54455&page=3",
        "hydra:next" => "/api/v1/locations?geolocation=42.65908%2C15.54455&page=2"
      ]
    ]);

    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00&mmsi=247039300&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'application/ld+json']]);
    $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    $this->assertResponseIsSuccessful();
    $this->assertJsonContains([
      "@context" => "/api/v1/contexts/Location",
      "@id" => "/api/v1/locations",
      "@type" => "hydra:Collection",
      "hydra:member" => [
        [
          "@type" => "Location",
          "@id" => "/api/v1/locations/247039300",
          "mmsi" => 247039300,
          "stationId" => 288,
          "speed" => 15.3,
          "geoLocation" => [
            "@type" => "GeoLocationOutput",
            "lat" => 42.54122,
            "lon" => 15.69242
          ],
          "course" => 140,
          "heading" => 140,
          "rot" => 0,
          "timestamp" => "2013-07-01T17:33:00+00:00"
        ],
        [
          "@type" => "Location",
          "@id" => "/api/v1/locations/247039300",
          "mmsi" => 247039300,
          "stationId" => 963,
          "speed" => 14.9,
          "geoLocation" => [
            "@type" => "GeoLocationOutput",
            "lat" => 42.66573,
            "lon" => 15.53592
          ],
          "course" => 135,
          "heading" => 136,
          "rot" => 0,
          "timestamp" => "2013-07-01T17:33:00+00:00"
        ]
      ],
      "hydra:totalItems" => 2,
    ]);
  }

  public function testContentTypeJsonHal(): void
  {
    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00&mmsi=247039300&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'application/hal+json']]);
    $this->assertResponseHeaderSame('content-type', 'application/hal+json; charset=utf-8');
    $this->assertResponseIsSuccessful();
    $this->assertJsonContains([
      "_links" => [
        "self" => [
          "href" => "/api/v1/locations?geolocation=42.65908%2C15.54455&mmsi=247039300&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00"
        ],
        "item" => [
          [
            "href" => "/api/v1/locations/247039300"
          ],
          [
            "href" => "/api/v1/locations/247039300"
          ]
        ]
      ],
      "totalItems" => 2,
      "itemsPerPage" => 30,
      "_embedded" => [
        "item" => [
          [
            "_links" => [
              "self" => [
                "href" => "/api/v1/locations/247039300"
              ]
            ],
            "mmsi" => 247039300,
            "stationId" => 288,
            "speed" => 15.3,
            "geoLocation" => [
              "lat" => 42.54122,
              "lon" => 15.69242
            ],
            "course" => 140,
            "heading" => 140,
            "rot" => 0,
            "timestamp" => "2013-07-01T17:33:00+00:00"
          ],
          [
            "_links" => [
              "self" => [
                "href" => "/api/v1/locations/247039300"
              ]
            ],
            "mmsi" => 247039300,
            "stationId" => 963,
            "speed" => 14.9,
            "geoLocation" => [
              "lat" => 42.66573,
              "lon" => 15.53592
            ],
            "course" => 135,
            "heading" => 136,
            "rot" => 0,
            "timestamp" => "2013-07-01T17:33:00+00:00"
          ]
        ]
      ]
    ]);
  }

  public function testContentTypeJsonApi(): void
  {
    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00&mmsi=247039300&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'application/vnd.api+json']]);
    $this->assertResponseHeaderSame('content-type', 'application/vnd.api+json; charset=utf-8');
    $this->assertResponseIsSuccessful();
    $this->assertJsonContains([
      "links" => [
        "self" => "/api/v1/locations?geolocation=42.65908%2C15.54455&mmsi=247039300&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00"
      ],
      "meta" => [
        "totalItems" => 2,
        "itemsPerPage" => 30,
        "currentPage" => 1
      ],
      "data" => [
        [
          "id" => "/api/v1/locations/247039300",
          "type" => "Location",
          "attributes" => [
            "mmsi" => 247039300,
            "stationId" => 288,
            "speed" => 15.3,
            "geoLocation" => [
              "data" => [
                "type" => "GeoLocationOutput",
                "attributes" => [
                  "lat" => 42.54122,
                  "lon" => 15.69242
                ]
              ]
            ],
            "course" => 140,
            "heading" => 140,
            "rot" => 0,
            "timestamp" => "2013-07-01T17:33:00+00:00"
          ]
        ],
        [
          "id" => "/api/v1/locations/247039300",
          "type" => "Location",
          "attributes" => [
            "mmsi" => 247039300,
            "stationId" => 963,
            "speed" => 14.9,
            "geoLocation" => [
              "data" => [
                "type" => "GeoLocationOutput",
                "attributes" =>  [
                  "lat" => 42.66573,
                  "lon" => 15.53592
                ]
              ]
            ],
            "course" => 135,
            "heading" => 136,
            "rot" => 0,
            "timestamp" => "2013-07-01T17:33:00+00:00"
          ]
        ]
      ]

    ]);
  }

  public function testContentTypeJson(): void
  {
    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00&mmsi=247039300&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'application/json']]);
    $this->assertResponseHeaderSame('content-type', 'application/json; charset=utf-8');
    $this->assertResponseIsSuccessful();
    $this->assertJsonContains([
      [
        "mmsi" => 247039300,
        "stationId" => 288,
        "speed" => 15.3,
        "geoLocation" => [
          "lat" => 42.54122,
          "lon" => 15.69242
        ],
        "course" => 140,
        "heading" => 140,
        "rot" => 0,
        "timestamp" => "2013-07-01T17:33:00+00:00"
      ],
      [
        "mmsi" => 247039300,
        "stationId" => 963,
        "speed" => 14.9,
        "geoLocation" => [
          "lat" => 42.66573,
          "lon" => 15.53592
        ],
        "course" => 135,
        "heading" => 136,
        "rot" => 0,
        "timestamp" => "2013-07-01T17:33:00+00:00"
      ]
    ]);
  }

  public function testContentTypeXml(): void
  {
    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00&mmsi=247039300&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'application/xml']]);
    $this->assertResponseHeaderSame('content-type', 'application/xml; charset=utf-8');
    $this->assertResponseIsSuccessful();
    $this->assertStringContainsString("<mmsi>247039300</mmsi><stationId>288</stationId><speed>15.3</speed>", $response->getContent());
  }

  public function testContentTypeTextXml(): void
  {
    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00&mmsi=247039300&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'text/xml']]);
    $this->assertResponseHeaderSame('content-type', 'application/xml; charset=utf-8');
    $this->assertResponseIsSuccessful();
    $this->assertStringContainsString("<mmsi>247039300</mmsi><stationId>288</stationId><speed>15.3</speed>", $response->getContent());
  }

  public function testContentTypeYaml(): void
  {
    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00&mmsi=247039300&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'application/x-yaml']]);
    $this->assertResponseHeaderSame('content-type', 'application/x-yaml; charset=utf-8');
    $this->assertResponseIsSuccessful();
    $this->assertStringContainsString("[{ mmsi: 247039300, stationId: 288, speed: 15.3, geoLocation: { lat: 42.54122, lon: 15.69242 }, course: 140, heading: 140, rot: 0.0, timestamp: '2013-07-01T17:33:00+00:00' }, { mmsi: 247039300, stationId: 963, speed: 14.9, geoLocation: { lat: 42.66573, lon: 15.53592 }, course: 135, heading: 136, rot: 0.0, timestamp: '2013-07-01T17:33:00+00:00' }]", $response->getContent());
  }


  public function testContentTypeTextCsv(): void
  {
    $response = static::createClient()->request('GET', 'api/v1/locations?page=1&timestamp=2013-07-01T17%3A33%3A00%2B00%3A00&mmsi=247039300&geolocation=42.65908%2C15.54455', ['headers' => ['accept' => 'text/csv']]);
    $this->assertResponseHeaderSame('content-type', 'text/csv; charset=utf-8');
    $this->assertResponseIsSuccessful();
    $this->assertStringContainsString("mmsi,stationId,speed,geoLocation.lat,geoLocation.lon,course,heading,rot,timestamp", $response->getContent());
    $this->assertStringContainsString("247039300,288,15.3,42.54122,15.69242,140,140,0,2013-07-01T17:33:00+00:00", $response->getContent());
    $this->assertStringContainsString("247039300,963,14.9,42.66573,15.53592,135,136,0,2013-07-01T17:33:00+00:00", $response->getContent());
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
