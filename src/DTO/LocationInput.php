<?php

namespace App\DTO;

final class LocationInput {
    public int $mmsi;
    public int $timestamp;
    public int $speed;
    public GeoLocationOutput $geolocation;
}