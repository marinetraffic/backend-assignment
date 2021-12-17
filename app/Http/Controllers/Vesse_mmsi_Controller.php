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

        Log::info('$mmsi: ' . $request->getUri() . "\n");

        $vessel = Vessel::all();

        $vessel = $vessel->where('mmsi', $mmsi);

        return response()->json(['data_by_mmsi' => $vessel], 200);
    }
}
