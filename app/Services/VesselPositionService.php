<?php

namespace App\Services;

use App\Http\Requests\RetrieveVesselPositionRequest;
use App\Interfaces\VesselPositionServiceInterface;
use App\Models\VesselPosition;
use Illuminate\Contracts\Pagination\Paginator;

class VesselPositionService implements VesselPositionServiceInterface
{
    protected int $perPage;
    protected string $multipleValueSeparator;

    public function __construct()
    {
        $this->perPage = 25; // @TODO: Move this value to config file
        $this->multipleValueSeparator = ',';
    }

    public function getVesselPosition(RetrieveVesselPositionRequest $request): Paginator
    {
        return VesselPosition::query()
            ->vesselPositionDynamicFilter($request)
            ->simplePaginate($request->safe()->only(['per_page'])['per_page'] ?? $this->perPage)
            ->withQueryString();
    }
}
