<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;

    // /**
    //  * Regarding Exception @ 'homestead.sellers
    //  * we need to tell laravel to use this specific table right now 
    //  * and not the table that it is guessing
    //  */
    protected $table = 'vessels';

    /**
     * table vessel field names
     */
    const FIELD_ID  = "id";

    const FIELD_MMSI = "mmsi";
    const FIELD_STATUS = "status";
    const FIELD_STATION_ID = "stationId";
    const FIELD_SPEED = "speed";
    const FIELD_LON = "lon";
    const FIELD_LAT = "lat";
    const FIELD_COURSE = "course";
    const FIELD_HEADING = "heading";
    const FIELD_ROT = "rot";
    const FIELD_TIMESTAMP = "timestamp";

    const FIELD_CREATED_AT = "created_at";
    const FIELD_UPDATED_AT = "updated_at";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::FIELD_MMSI,
        self::FIELD_STATUS,
        self::FIELD_STATION_ID,
        self::FIELD_SPEED,
        self::FIELD_LON,
        self::FIELD_LAT,
        self::FIELD_COURSE,
        self::FIELD_HEADING,
        self::FIELD_ROT,
        self::FIELD_TIMESTAMP,
    ];


    /**
     * The attributes excluded from the model's JSON data.
     *
     * @var array
     */
    protected $hidden = [
        self::FIELD_ID,
        self::FIELD_CREATED_AT,
        self::FIELD_UPDATED_AT,
    ];
}
