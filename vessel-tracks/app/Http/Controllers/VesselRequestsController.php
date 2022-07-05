<?php

namespace App\Http\Controllers;

use App\Models\ShipPosition;
use App\Services\ContentTypeService;
use App\Services\FiltersService;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VesselRequestsController extends Controller
{
    public $filtersService;

    public function __contruct(FiltersService $filtersService) {
        $this->filtersService = $filtersService;
    }

    public function getPosition(Request $request) {

        LogService::handle($request);

        $data = FiltersService::handle($request);

        if($data instanceof Collection){
            if ($data->isEmpty())
            { return 'No data found'; }
        }

        $data = ContentTypeService::handle($data, $request);

        return $data;


    }
}
