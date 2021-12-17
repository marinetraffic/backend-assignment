<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Models\Vessel;


class Vessel_lon_Controller extends Controller
{
    use ApiResponser;

    /**
     * Display the specified resource.
     * GET 127.0.0.1:8000/lon/{lon}
     * 
     * @param  int  $lon
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $lon)
    {
        Log::info('Request IP: ' . json_encode($request->getClientIp()) . "\n");

        Log::info('$lon: ' . $request->getUri() . "\n");

        $vessel = Vessel::all();

        $vessel = $vessel->where('lon', $lon);

        return response()->json(['data_by_lon' => $vessel], 200);
    }
}
