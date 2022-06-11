<?php

namespace App\Http\Filters\Conditions;

use App\Http\Filters\FilterContracts;
use Illuminate\Database\Eloquent\Builder;

class TimeFilter implements FilterContracts
{

    public function apply(Builder $builder, $value)
    {
        return $builder;
    }
}
