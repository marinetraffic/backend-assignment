<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Models\Vessel;

/**
 * We need to use the Trait ApiResponser in VesselController
 * doing that we can use the trait directly in all other controllers
 * since they are extended
 */
class VesselController extends Controller
{
    use ApiResponser; //we can use every trait method directly in our Controllers

    /**
     * Display a listing of the resource.
     * 
     * GET vesseltracking.dev/vessel
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vessels = Vessel::all();

        Log::info('Request IP: ' . json_encode($request->getClientIp()) . "\n");

        //return all the vessels as a json response
        return response()->json(['vessels_data_all' => $vessels], 200);
        //Or using traits
        // return $this->showAll($vessels);
    }

    /**
     * Display the specified resource.
     *  GET 127.0.0.1:8000/api/247039300
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show(Vessel $vessel)   <- After Laravel 5.2Using The Laravel Implicit Model Binding for Some Methods
    //instead of $vessel = Vessel::findOrFail($id);
    public function show(Request $request, $id)
    {
        Log::info('Request IP: ' . json_encode($request->getClientIp()) . "\n");

        Log::info('$id: ' . $request->getUri() . "\n");

        // Log::info('$id: ' . $request->getHost() . "\n");
        //[2021-12-15 16:59:53] local.INFO: $id: vesseltracking.dev
        $vessel = Vessel::all();

        //If the vessel does not exist we will have an exception with

        $vessel = $vessel->where('timestamp', $id);

        return response()->json(['vessel_data' => $vessel], 200);
        //return $this->showOne($vessel, 200);
    }
}
