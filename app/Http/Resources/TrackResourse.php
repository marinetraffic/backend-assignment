<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackResourse extends JsonResource
{
    public function toArray($request)
    {
        return [
            'mmsi' => $this->mmsi,
            'status' => $this->status,
            'stationId' => $this->stationId,
            'speed' => $this->speed,
            'lon' => $this->lon,
            'lat' => $this->lat,
            'course' => $this->course,
            'heading' => $this->heading,
            'rot' => $this->rot,
            'timestamp' => $this->timestamp,
        ];
    }
}
