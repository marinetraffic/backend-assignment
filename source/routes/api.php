<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipPositionController;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

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

Route::middleware(['throttle:10,1'])->group(function () {
    switch (app('request')->header('Accept')) {
      case 'application/json':
        Route::get('/v1/shippositions', [ShipPositionController::class, 'showShipPositionsJson']);
        break;
      case 'application/xml':
        Route::get('/v1/shippositions', [ShipPositionController::class, 'showShipPositionsXML']);
        break;
      case 'text/csv':
        Route::get('/v1/shippositions', [ShipPositionController::class, 'showShipPositionsCSV']);
        break;
      case 'application/vnd.api+json':
        JsonApiRoute::server('v1')->prefix('v1')->resources(function($server) {
          $server->resource('shippositions', JsonApiController::class)->readOnly();
        });
        break;
    }
});

