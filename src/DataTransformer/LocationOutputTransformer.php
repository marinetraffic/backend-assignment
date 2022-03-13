<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\GeoLocationOutput;
use App\DTO\LocationOutput;
use App\Entity\Location;
use App\Entity\GeoLocation;
use DateTime;
use Psr\Log\LoggerInterface;

final class LocationOutputTransformer implements DataTransformerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $output = new LocationOutput();
        $output->mmsi = $data->mmsi;
        $timestamp = new \DateTime('@'. $data->timestamp);
        $output->timestamp = $timestamp;
        $output->speed = (float) $data->speed / 10;
        $geolocation = new GeoLocationOutput();
        $geolocation->lat = $data->geolocation['lat'];
        $geolocation->lon =  $data->geolocation['lon'];
        $output->geoLocation = $geolocation;

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return LocationOutput::class === $to && $data instanceof Location;
    }
}
