<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Positions;
use App\Exceptions\NoResults;

class PositionsController extends Controller {
    public function getPositionsByVesselId(Request $request, $mmsi) {
        if(!$mmsi) throw new Exception();

        $positions = Positions::whereRaw("mmsi IN ($mmsi)")->get();
        if(!$positions->count()) throw new Exception();

        return response()->json(['status'=>true, 'data'=>$positions], 200);    
    }

    public function getPositionsByLat(Request $request, $lat) {
        if(!$lat) throw new Exception();
        if(!is_string($lat)) throw new Exception();
        if(!str_contains($lat, ',')) throw new Exception();

        $range = explode(',', $lat);
        $from = floatval(trim($range[0]));
        $to = floatval(trim($range[1]));

        $positions = Positions::whereRaw("lat BETWEEN $from AND $to")->get(['*']);
        if(!$positions->count()) throw new NoResults();

        return response()->json($positions, 200);
    }

}
