<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\DTO\LocationInput;
use App\DTO\LocationOutput;
use App\Filter\DateFilter;
use App\Filter\MmsiFilter;
use App\Filter\GeoRangeFilter;


#[ApiResource(
  collectionOperations: [
    'get' => [
      'method' => 'GET',
      "input" => LocationInput::class,
      "output" => LocationOutput::class,
    ]
  ],
  itemOperations: [
    'get' =>
    [
      'controller' =>
      NotFoundAction::class,
      'read' => false,
      'output' => false
    ],
  ]
)]
#[ApiFilter(DateFilter::class, properties: ['timestamp'])]
#[ApiFilter(MmsiFilter::class, properties:['mmsi'])]
#[ApiFilter(GeoRangeFilter::class, properties:['geolocation'])]

class Location
{
  /** 
   * Unique vessel identifier 
   */
  #[ApiProperty(identifier: true)]
  public int $mmsi;
  /**
   * AIS vessel status 
   */
  public int $status;
  /** 
   * Receiving station ID 
   */
  public int $stationId;
  /**
   * Speed in knots x 10 (i.e. 10,1 knots is 101) 
   */
  public int $speed;
  /**
   * Vessel's course over ground 
   */
  public int $course;
  /**
   * Vessel's true heading 
   */
  public int $heading;
  /**
   * longitude,latitude,radius
   */
  public array $geolocation;
  /**
   * Vessel's rate of turn 
   */
  public float $rot;
  /** 
   * Position timestamp 
   */
   public int $timestamp;
}
