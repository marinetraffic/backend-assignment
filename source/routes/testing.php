<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipPositionController;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;


//since the routes use a switch statement, these route are not visible in testing environment.
//therefore these routes are slightly different, and only loaded during testing.
Route::middleware(['throttle:10000,1'])->group(function () {
    
    Route::get('/v1/json/shippositions', [ShipPositionController::class, 'showShipPositionsJson']);
    Route::get('/v1/xml/shippositions', [ShipPositionController::class, 'showShipPositionsXML']);
    Route::get('/v1/csv/shippositions', [ShipPositionController::class, 'showShipPositionsCSV']);
    JsonApiRoute::server('v1')->prefix('v1/vndjson')->resources(function($server) {
        $server->resource('shippositions', JsonApiController::class)->readOnly();
    });
});