<?php

namespace App\DTO;

final class LocationOutput {
    public int $mmsi;
    public \DateTimeInterface $timestamp;
    public float $speed;
    public GeoLocationOutput $geoLocation;
}