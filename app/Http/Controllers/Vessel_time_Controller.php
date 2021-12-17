<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Models\Vessel;


class Vessel_time_Controller extends Controller
{
    use ApiResponser;

    /**
     * Display the specified resource.
     *  GET 127.0.0.1:8000/time/{time}
     * 
     * @param  int  $time
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $time)
    {
        Log::info('Request IP: ' . json_encode($request->getClientIp()) . "\n");

        Log::info('$time: ' . $request->getUri() . "\n");

        $vessel = Vessel::all();

        $vessel = $vessel->where('timestamp', $time);

        return response()->json(['data_by_time' => $vessel], 200);
    }
}
