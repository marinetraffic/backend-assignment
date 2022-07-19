<?php

use App\Http\Controllers\VesselTrackController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->middleware(['throttle:api'])->group(function(){
    Route::get('/', function(){
        return response()->json([
            'status' => 'success',
            'message' => 'You are connect to v1.0.0 api'
        ]);
    });
    Route::get('positions', [VesselTrackController::class, 'index']);
});
