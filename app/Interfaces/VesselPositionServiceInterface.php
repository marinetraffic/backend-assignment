<?php

namespace App\Interfaces;

use App\Http\Requests\RetrieveVesselPositionRequest;
use Illuminate\Contracts\Pagination\Paginator;

interface VesselPositionServiceInterface
{
    public function getVesselPosition(RetrieveVesselPositionRequest $request): Paginator;
}
