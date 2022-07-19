<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\ResponseManager;
use App\Models\VesselPosition;
use App\Services\TrackService;

class VesselTrackController extends Controller
{
    public function index(Request $request, VesselPosition $vesselPosition, TrackService $trackService){
        $positions = $trackService->filter($vesselPosition)->latest()->get()->toArray();

        return ResponseManager::create($positions, $request->header("accept"));
        
        return response()->json([
            'status' => 'success',
            'message' => "Tracks retrieved successfully",
            'data' => $positions
        ]);
    }
}
