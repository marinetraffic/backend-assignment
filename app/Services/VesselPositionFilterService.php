<?php

namespace App\Services;

use App\Filters\VesselPosition\FilterByCoordinatesRange;
use App\Filters\VesselPosition\FilterByTimestampsRange;
use App\Filters\VesselPosition\FilterByVesselId;
use App\Http\Requests\RetrieveVesselPositionRequest;
use App\Interfaces\VesselPositionFilterServiceInterface;
use Illuminate\Database\Eloquent\Builder;

class VesselPositionFilterService implements VesselPositionFilterServiceInterface
{
    protected array $availableFilters = [
        'mmsi' => FilterByVesselId::class,
        'coordinates' => FilterByCoordinatesRange::class,
        'timestamps' => FilterByTimestampsRange::class
    ];

    public function create_filter_class(Builder $builder, RetrieveVesselPositionRequest $request): Builder
    {
        foreach ($request->safe() as $fn => $fv) {
            if (array_key_exists($fn, $this->availableFilters)) {
                (new $this->availableFilters[$fn])->apply_filter($builder, $fv);
            }
        }

        return $builder;
    }
}
