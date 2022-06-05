<?php

namespace App\Filters\VesselPosition;

use Illuminate\Database\Eloquent\Builder;

class FilterByVesselId
{
    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function apply_filter(Builder $builder, string $value): Builder
    {
        return $builder->whereIn('vessel_id', explode(',', $value));
    }
}
