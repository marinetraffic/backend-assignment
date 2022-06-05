<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetrieveVesselPositionRequest;
use App\Services\VesselPositionService;
use Illuminate\Contracts\Pagination\Paginator;

class VesselPositionController extends Controller
{
    public function get(RetrieveVesselPositionRequest $request, VesselPositionService $vesselPositionService): Paginator
    {
        return $vesselPositionService->getVesselPosition($request);
    }
}
