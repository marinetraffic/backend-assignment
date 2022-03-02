<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionsController;

Route::get('positions/{mmsi}', [PositionsController::class, 'getPositionsByVesselId']);
Route::get('positions/lat/{lat}', [PositionsController::class, 'getPositionsByLat']);