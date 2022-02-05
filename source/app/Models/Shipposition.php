<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipposition extends Model
{
    public $table = "ship_positions";
    protected $primaryKey = 'mmsi'; // or null

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "mmsi",
        "status",
        "station",
        "speed",
        "lon",
        "lat",
        "course",
        "heading",
        "rot",
        "timestamp",
    ];

    public function getRouteKeyName()
    {
        return 'mmsi';
    }

    public function scopeLatFrom($query, $value)
    {
        return $query->where('lat', '>=', $value);
    }

    public function scopeLatTo($query, $value)
    {
        return $query->where('lat', '<=', $value);
    }

    public function scopeLonFrom($query, $value)
    {
        return $query->where('lon', '>=', $value);
    }

    public function scopeLonTo($query, $value)
    {
        return $query->where('lon', '<=', $value);
    }

    public function scopeTimestampFrom($query, $value)
    {
        return $query->where('timestamp', '>=', $value);
    }

    public function scopeTimestampTo($query, $value)
    {
        return $query->where('timestamp', '<=', $value);
    }
}
