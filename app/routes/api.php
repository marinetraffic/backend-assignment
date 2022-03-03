<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionsController;
use App\Helpers\HttpCodes;

Route::get('positions/{mmsi}', [PositionsController::class, 'getPositionsByVesselId'])
    ->where('mmsi', '^[0-9]+(,[0-9]+)*')
    ->middleware('limit.user.requests')
    ->middleware('log.incoming.requests');

Route::get('positions/{lat}/{lon}', [PositionsController::class, 'getPositionsByLatLon'])
    ->middleware('limit.user.requests')
    ->middleware('log.incoming.requests');

Route::get('positions', [PositionsController::class, 'getPositionsByStamp'])
    ->middleware('limit.user.requests')
    ->middleware('log.incoming.requests');

// Route not found fallback
Route::fallback(function () {
    return response()->json(
        ['status' => false, 'message'=>'Route not found...'], 
        HttpCodes::NOT_FOUND
    );
});