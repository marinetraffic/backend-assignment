<?php

namespace App\DTO;

final class LocationOutput {
    public int $mmsi;
    public int $stationId;
    public float $speed;
    public GeoLocationOutput $geoLocation;
    public int $course;
    public int $heading;
    public float $rot;
    public \DateTimeInterface $timestamp;
}