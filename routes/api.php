<?php

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

/**
 * vessel's mmsi
 */
Route::resource('mmsi', 'Vesse_mmsi_Controller', ['only' => ['show']]);

/**
 * vessel's longitude
 */
Route::resource('lon', 'Vessel_lon_Controller', ['only' => ['show']]);

/**
 * vessel's latitude
 */
Route::resource('lat', 'Vessel_lat_Controller', ['only' => ['show']]);

/**
 * vessel's timestamp
 */
Route::resource('time', 'Vessel_time_Controller', ['only' => ['show']]);

/**
 *  Csrf token
 * 
 * TO DO
 */
// Route::get('/token', function (Request $request) {
//     $token = $request->session()->token();

//     $token = csrf_token();

//     // ...
// });
