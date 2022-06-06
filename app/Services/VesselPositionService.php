<?php

namespace App\Services;

use App\Http\Requests\RetrieveVesselPositionRequest;
use App\Interfaces\GenerateAppropriateContentTypeResponseServiceInterface;
use App\Models\VesselPosition;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VesselPositionService
{
    protected GenerateAppropriateContentTypeResponseServiceInterface $appropriateContentTypeResponseService;

    public function __construct(GenerateAppropriateContentTypeResponseServiceInterface $appropriateContentTypeResponseService)
    {
        $this->appropriateContentTypeResponseService = $appropriateContentTypeResponseService;
    }

    public function getVesselPosition(RetrieveVesselPositionRequest $request): Response|StreamedResponse|JsonResponse|Application|ResponseFactory
    {
        return $this->appropriateContentTypeResponseService->select_output_handler($request->header('accept'), VesselPosition::query()->vesselPositionDynamicFilter($request));
    }
}
