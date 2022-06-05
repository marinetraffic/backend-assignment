<?php

namespace App\Filters\VesselPosition;

use Illuminate\Database\Eloquent\Builder;

class FilterByCoordinatesRange
{
    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     *
     * @see coordinate calculation query taken from:
     * @see https://laravel.io/forum/04-23-2014-convert-this-geolocation-query-to-query-builder-for?page=1
     */
    public function apply_filter(Builder $builder, string $value): Builder
    {
        $coordinates = explode(',', $value);
        $radius = 1;

        if (count($coordinates) !== 2) {
            return $builder;
        }

        [$longitude, $latitude] = $coordinates;

        $haversine = "(6371 * acos(cos(radians(" . $latitude . ")) 
                    * cos(radians(`latitude`)) 
                    * cos(radians(`longitude`) 
                    - radians(" . $longitude . ")) 
                    + sin(radians(" . $latitude . ")) 
                    * sin(radians(`latitude`))))";

        return $builder->select('*')
            ->selectRaw("{$haversine} AS distance")
            ->whereRaw("{$haversine} < ?", [$radius]);
    }
}
