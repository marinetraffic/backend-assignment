<?php

namespace App\Interfaces;

use App\Http\Requests\RetrieveVesselPositionRequest;
use Illuminate\Database\Eloquent\Builder;

interface VesselPositionFilterServiceInterface
{
    public function create_filter_class(Builder $builder, RetrieveVesselPositionRequest $request): Builder;
}
