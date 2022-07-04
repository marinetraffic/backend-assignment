<?php

namespace App\Http\Controllers;

use App\Models\ShipPosition;
use App\Services\FiltersService;
use Illuminate\Http\Request;

class VesselRequestsController extends Controller
{
    public $filtersService;

    public function __contruct(FiltersService $filtersService) {
        $this->filtersService = $filtersService;
    }

    public function getPosition(Request $request) {

        return FiltersService::handle($request);;
    }
}
