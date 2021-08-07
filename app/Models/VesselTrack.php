<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class VesselTrack
 * @package App\Models
 *
 * @property int $mmsi
 * @property int $status
 * @property int $station_id
 * @property int $speed
 * @property float $lon
 * @property float $lat
 * @property int $course
 * @property int $rot
 * @property Carbon|null $timestamp
 */
class VesselTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'mmsi',
        'status',
        'station_id',
        'speed',
        'lon',
        'lat',
        'course',
        'rot',
        'timestamp',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
