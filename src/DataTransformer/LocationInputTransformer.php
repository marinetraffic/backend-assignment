<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\GeoLocationOutput;
use App\Entity\Location;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Component\ErrorHandler\Debug;

final class LocationInputTransformer implements DataTransformerInterface {

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function transform($data, string $to, array $context = [])
    {
        $location = new Location();
        $location->mmsi = $data->mmsi;
        $timestamp = new \DateTime($data->timestamp);
        $location->timestamp = $timestamp->getTimestamp();

        $geolocation = new GeoLocationOutput();
        $geolocation->lat = $data->geolocation->lat;
        $geolocation->lon = $data->geolocation->lon;
        $location->geoLocation = $geolocation;

        $location->stationId = $data->stationId;
        $location->speed = $data->speed;
        $location->rot = $data->rot;
        $location->course = $data->course;
        $location->heading = $data->heading;

        return $location;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        // in the case of an input, the value given here is an array (the JSON decoded).
        // if it's a location we transformed the data already
        if ($data instanceof Location) {
          return false;
        }

        return Location::class === $to && null !== ($context['input']['class'] ?? null);
    }
}