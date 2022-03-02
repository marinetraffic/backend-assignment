<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Positions;

Route::get('positions{mmsi}', function($mmsi) {
    return Positions::find($mmsi);
});