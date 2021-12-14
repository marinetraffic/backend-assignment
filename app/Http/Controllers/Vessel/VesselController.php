<?php

namespace App\Http\Controllers\VesselController;

use Illuminate\Support\Facades\Log;
use App\Models\Vessel;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class VesselController extends ApiController
{
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
        //return response()->json(['vessels_data' => $vessels], 200);
        //Or using traits
        return $this->showAll($vessels);
    }

    /**
     * Display the specified resource.
     *  GET vesseltracking.dev/vessel/1
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show(Vessel $vessel)   <- After Laravel 5.2Using The Laravel Implicit Model Binding for Some Methods
    //instead of $vessel = Vessel::findOrFail($id);
    public function show($id)
    {
        //If the vessel does not exist we will have an exception with
        //findOrFail
        //other with find need to be handled with a different condition
        $vessel = Vessel::findOrFail($id);

        //return all the vessels as a json response
        // return response()->json(['vessel_data' => $vessels], 200);
        return $this->showOne($vessel, 200);
    }
}
