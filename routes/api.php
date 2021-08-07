<?php

use App\Http\Controllers\Api\VesselTrackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['throttle:10,60', 'vessels_tracks.response'])->get('/vessels_tracks', [VesselTrackController::class, 'list']);
