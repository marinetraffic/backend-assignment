<?php

namespace App\Helpers;

class VesselTrackingHandler
{
    private array $mmsi = [];
    private mixed $latitudes = [];
    private mixed $longitudes  = [];
    private mixed $filter_time_from;
    private mixed $filter_time_to;
    private string $format;

    public function __construct(array $requestInfo)
    {
        $this->setMmsi(isset($requestInfo['mmsi']) ? array_values($requestInfo['mmsi']) : []);
        $this->setFormat(isset($requestInfo['format']) ? $requestInfo['format'] : 'application/json');
        $this->setLatitudes((isset($requestInfo['latitudes'])) ? $requestInfo['latitudes'] : []);
        $this->setLongitudes((isset($requestInfo['longitudes'])) ? $requestInfo['longitudes'] : []);
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
    public function getLatitudes(): mixed
    {
        return $this->latitudes;
    }

    /**
     * @param mixed|string $latitudes
     */
    public function setLatitudes(mixed $latitudes): void
    {
        $this->latitudes = $latitudes;
    }

    /**
     * @return mixed
     */
    public function getLongitudes(): mixed
    {
        return $this->longitudes;
    }

    /**
     * @param mixed|string $longitudes
     */
    public function setLongitudes(mixed $longitudes): void
    {
        $this->longitudes = $longitudes;
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
