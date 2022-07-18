<?php

namespace App\Http\Controllers;

use App\Models\VesselPosition;
use App\Services\TrackService;
use Illuminate\Http\Request;

class VesselTrackController extends Controller
{
    public function index(Request $request, VesselPosition $vesselPosition, TrackService $trackService){
        $positions = $trackService->filter($vesselPosition)->latest()->get();
        return response()->json([
            'status' => 'success',
            'message' => "Tracks retrieved successfully",
            'data' => $positions
        ]);
    }
}
