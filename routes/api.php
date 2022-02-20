<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ShipServiceController;
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
 * New Class \App\Http\Middleware\ApiRequestLogger created to log incoming requests in file ../storage/logs/ais_api_dd_mm_yyyy.log with daily rotation.
 * Limit incoming requests per user to 10/hour set Kernel -> 'api' => ['throttle:10,1']
 */

Route::get('/ship/', [ShipServiceController::class, 'search'])->middleware(['request.logging']);
