<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionsController;

Route::get('positions/{mmsi}', [PositionsController::class, 'getPositionsByVesselId'])->where('mmsi', '^[0-9]+(,[0-9]+)*');
Route::get('positions/latlon/{lat}/{lon}', [PositionsController::class, 'getPositionsByLatLon']);
Route::get('positions/stamp', [PositionsController::class, 'getPositionsByStamp']);

// Route not found fallback
Route::fallback(function () {
    return response()->json(['status' => false, 'message'=>'Route not found...'], 404);
});