<?php

namespace App\Filters\VesselPosition;

use Illuminate\Database\Eloquent\Builder;

class FilterByTimestampsRange
{
    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function apply_filter(Builder $builder, string $value): Builder
    {
        $timestamps = explode(',', $value);

        if (count($timestamps) !== 2) {
            return $builder;
        }

        [$from, $to] = $timestamps;

        return $builder->where('timestamp', '>=', $from)->where('timestamp', '<=', $to);
    }
}
