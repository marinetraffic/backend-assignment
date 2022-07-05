<?php

namespace App\Http\Controllers;

use App\Models\ShipPosition;
use App\Services\FiltersService;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VesselRequestsController extends Controller
{
    public $filtersService;

    public function __contruct(FiltersService $filtersService) {

        $this->filtersService = $filtersService;
    }

    public function getPosition(Request $request) {

        LogService::handle($request);
        return FiltersService::handle($request);;
    }
}
