<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackApiResource extends JsonResource
{
//    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                "type" => "tracks",
                "id" => $this->id,
                "attributes"=> [
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
                ]
        ];
    }
}
