<?php

namespace App\Http\Filters\Conditions;

use App\Http\Filters\FilterContracts;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class TimeFilter implements FilterContracts
{

    public function apply(Builder $builder, $value): Builder
    {
        $processedTimestamp = Carbon::parse($value)->timestamp;

        return $builder->where('timestamp', '<=', $processedTimestamp);
    }
}
