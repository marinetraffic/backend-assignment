<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RetrieveVesselPositionRequest;
use App\Services\VesselPositionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VesselPositionController extends Controller
{
    public function get(RetrieveVesselPositionRequest $request, VesselPositionService $vesselPositionService): Response|JsonResponse|StreamedResponse|Application|ResponseFactory
    {
        return $vesselPositionService->getVesselPosition($request);
    }
}
