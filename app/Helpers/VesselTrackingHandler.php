<?php

namespace App\Helpers;

class VesselTrackingHandler
{
    private array $mmsi = [];
    private mixed $latitude = '';
    private mixed $longitude  = '';
    private mixed $filter_time_from;
    private mixed $filter_time_to;
    private string $format;

    public function __construct(array $requestInfo)
    {
        $this->setMmsi(isset($requestInfo['mmsi']) ? array_values($requestInfo['mmsi']) : []);
        $this->setFormat(isset($requestInfo['format']) ? $requestInfo['format'] : 'application/json');
        $this->setLatitude((isset($requestInfo['latitude'])) ? $requestInfo['latitude'] : null);
        $this->setLongitude((isset($requestInfo['longitude'])) ? $requestInfo['longitude'] : null);
        $this->setFilterTimeTo((isset($requestInfo['time_to'])) ? $requestInfo['time_to'] : null);
        $this->setFilterTimeFrom((isset($requestInfo['time_from'])) ? $requestInfo['time_from'] : null);
    }

    /**
     * @return array
     */
    public function getMmsi(): array
    {
        return $this->mmsi;
    }

    /**
     * @param array $mmsi
     */
    public function setMmsi(array $mmsi): void
    {
        $this->mmsi = $mmsi;
    }

    /**
     * @return mixed
     */
    public function getLatitude(): mixed
    {
        return $this->latitude;
    }

    /**
     * @param mixed|string $latitude
     */
    public function setLatitude(mixed $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude(): mixed
    {
        return $this->longitude;
    }

    /**
     * @param mixed|string $longitude
     */
    public function setLongitude(mixed $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getFilterTimeFrom(): mixed
    {
        return $this->filter_time_from;
    }

    /**
     * @param mixed $filter_time_from
     */
    public function setFilterTimeFrom(mixed $filter_time_from): void
    {
        $this->filter_time_from = $filter_time_from;
    }

    /**
     * @return mixed
     */
    public function getFilterTimeTo(): mixed
    {
        return $this->filter_time_to;
    }

    /**
     * @param mixed $filter_time_to
     */
    public function setFilterTimeTo(mixed $filter_time_to): void
    {
        $this->filter_time_to = $filter_time_to;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }


}
