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
    /**
     * 
     * POST 127.0.0.1:8000/time
     * x-www-form-urlencoded
     * BODY:
     * timeFrom: 1372700340
     * timeTo: 1372700580
     * 
     * test data: 1372700340, 1372700460, 1372700580
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //$timeFrom = null, $timeTo = null
    {
        Log::info('Request IP: ' . json_encode($request->getClientIp()) . "\n");

        Log::info('$time: ' . $request->getUri() . "\n");
        // Ascending Order
        $vessel = Vessel::all()->sortBy("timestamp");

        $timeFrom =  $request->input('timeFrom');
        $timeTo = $request->input('timeTo');

        Log::info('timeFrom:' .  $timeFrom);
        Log::info('timeTo:' .  $request->timeTo);

        $vessel = $vessel->whereBetween('timestamp', array($timeFrom, $timeTo));

        return response()->json(['data_by_time' => $vessel], 200);
    }
}
