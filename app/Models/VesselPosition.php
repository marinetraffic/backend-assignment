<?php

namespace App\Models;

use App\Http\Requests\RetrieveVesselPositionRequest;
use App\Services\VesselPositionFilterService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VesselPosition extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'vessel_positions';

    /**
     * @param Builder $query
     * @param RetrieveVesselPositionRequest $request
     * @return Builder
     */
    public function scopeVesselPositionDynamicFilter(Builder $query, RetrieveVesselPositionRequest $request): Builder
    {
        return (new VesselPositionFilterService())->create_filter_class($query, $request);
    }
}
