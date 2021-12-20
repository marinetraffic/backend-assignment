<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Models\Vessel;


class Vessel_lat_Controller extends Controller
{
    use ApiResponser;

    /**
     * Display the specified resource.
     * GET 127.0.0.1:8000/lat/{lat}
     * 
     * @param  int  $lat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $lat)
    {
        Log::info('Request IP: ' . json_encode($request->getClientIp()) . "\n");

        Log::info('$getUri: ' . $request->getUri() . "\n");

        $vessel = Vessel::all();

        $vessel = $vessel->where('lat', $lat);

        return response()->json(['data_by_lat' => $vessel], 200);
    }
}
