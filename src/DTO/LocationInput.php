<?php

namespace App\DTO;

final class LocationInput {
    public int $mmsi;
    public int $stationId;
    public int $speed;
    public GeoLocationOutput $geolocation;
    public int $course;
    public int $heading;
    public float $rot;
    public int $timestamp;
}