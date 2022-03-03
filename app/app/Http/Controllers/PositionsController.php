<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Positions;
use App\Exceptions\NoResults;
use App\Exceptions\InvalidParameter;
use App\Helpers\HttpCodes;

class PositionsController extends Controller {
    public function getPositionsByVesselId(Request $request, $mmsi) {
        if(!$mmsi) throw new InvalidParameter();

        $positions = Positions::whereRaw("mmsi IN ($mmsi)")->get();
        if(!$positions->count()) throw new NoResults();

        return response()->json(['status'=>true, 'data'=>$positions], HttpCodes::OK);    
    }

    public function getPositionsByLatLon(Request $request, $lat, $lon) {
        if(!$lon || !$lat || !str_contains($lat, ',') || 
            !str_contains($lon, ',')) throw new InvalidParameter();

        $lonFrom = floatval(trim(explode(',', $lon)[0]));
        $lonTo = floatval(trim(explode(',', $lon)[1]));

        $latFrom = floatval(trim(explode(',', $lat)[0]));
        $latTo = floatval(trim(explode(',', $lat)[1]));

        $positions = Positions::whereRaw("lon BETWEEN $lonFrom AND $lonTo AND lat BETWEEN $latFrom AND $latTo")->get();
        if(!$positions->count()) throw new NoResults();

        return response()->json(['status'=>true, 'data'=>$positions], HttpCodes::OK);    
    }

    public function getPositionsByStamp(Request $request) {
        $queryParams = $request->query();
        if(!isset($queryParams['start']) || !isset($queryParams['end']) || 
            !preg_match('/^\d+$/', $queryParams['start']) || 
            !preg_match('/^\d+$/', $queryParams['end'])) throw new InvalidParameter();
      
        $positions = Positions::whereRaw("timestamp BETWEEN ".$queryParams['start']." AND ".$queryParams['end'])->get();
        if(!$positions->count()) throw new NoResults();

        return response()->json(['status'=>true, 'data'=>$positions], HttpCodes::OK);    
    }
}
