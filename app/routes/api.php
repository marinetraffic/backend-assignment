<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionsController;

Route::get('positions/{mmsi}', [PositionsController::class, 'getPositionsByVesselId'])
    ->where('mmsi', '^[0-9]+(,[0-9]+)*')
    ->middleware('log.incoming.requests');

Route::get('positions/{lat}/{lon}', [PositionsController::class, 'getPositionsByLatLon'])
    ->middleware('log.incoming.requests');

Route::get('positions', [PositionsController::class, 'getPositionsByStamp'])
    ->middleware('log.incoming.requests');

// Route not found fallback
Route::fallback(function () {
    return response()->json(['status' => false, 'message'=>'Route not found...'], 404);
});