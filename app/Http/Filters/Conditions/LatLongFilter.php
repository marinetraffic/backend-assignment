<?php

namespace App\Http\Filters\Conditions;


use App\Http\Filters\FilterContracts;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LatLongFilter implements FilterContracts
{

    /**
     * @throws Exception
     */
    public function apply(Builder $builder, $value)
    {
        $explodedValues = array_filter(explode(',', $value));

        if(count($explodedValues) !== 2){
            throw new Exception('Wrong Parameters');
        }
        $latitude = $explodedValues[0];
        $longitude = $explodedValues[1];

        return $builder->select("*", \DB::raw("6371 * acos(cos(radians(" . $latitude . "))
             * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
             + sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"))
            ->having('distance', '<', 1000)
            ->orderBy('distance');
    }
}
