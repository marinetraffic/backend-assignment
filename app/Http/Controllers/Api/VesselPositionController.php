<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RetrieveVesselPositionRequest;
use App\Interfaces\VesselPositionServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;

class VesselPositionController extends Controller
{
    public function get(RetrieveVesselPositionRequest $request, VesselPositionServiceInterface $vesselPositionService): Paginator
    {
        return $vesselPositionService->getVesselPosition($request);
    }
}
