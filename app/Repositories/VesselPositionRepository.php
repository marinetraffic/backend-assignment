<?php


namespace App\Repositories;


use App\Models\VesselPosition;
use Illuminate\Database\Eloquent\Builder;

class VesselPositionRepository extends EloquentRepository
{

    /**
     * @return Builder
     */
    protected function query(): Builder
    {
        return VesselPosition::query();
    }

}
