<?php

namespace App\Http\Filters\Conditions;


use App\Http\Filters\FilterContracts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LatLongFilter implements FilterContracts
{

    public function apply(Builder $builder, $value)
    {
        $lat = '37.5969800';
        $lon = '12.0476900';
        return $builder->where;
    }
}
