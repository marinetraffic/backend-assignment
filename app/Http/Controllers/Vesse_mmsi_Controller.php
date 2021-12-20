<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Models\Vessel;

class Vesse_mmsi_Controller extends Controller
{
    //we can use every trait method directly in our Controllers
    use ApiResponser;

    /**
     * Display the specified resource.
     * GET 127.0.0.1:8000/mmsi/{mmsi}
     * 
     * @param  int  $mmsi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $mmsi)
    {
        Log::info('Request IP: ' . json_encode($request->getClientIp()) . "\n");

        Log::info('$getUri: ' . $request->getUri() . "\n");

        $vessel = Vessel::all();

        $vessel = $vessel->where('mmsi', $mmsi);

        return response()->json(['data_by_mmsi' => $vessel], 200);
    }
    /**
     * 
     * POST 127.0.0.1:8000/mmsi
     * x-www-form-urlencoded
     * BODY:
     * mmsi: 311040700
     * mmsi1: 311486000
     * mmsi2: 311486000
     * mmsi3: 247039300
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('Request IP: ' . json_encode($request->getClientIp()) . "\n");

        Log::info('$getUri: ' . $request->getUri() . "\n");

        // Ascending Order
        $vessel = Vessel::all()->sortBy("mmsi");

        $mmsi = $request->all();

        foreach ($mmsi as $variableName) {
            // log mmsis'
            Log::info('mmsi:' .  $variableName);
        }

        $vessel = $vessel->whereIn('mmsi', $mmsi);

        return response()->json(['data_by_mmsi' => $vessel], 200);
    }
}
