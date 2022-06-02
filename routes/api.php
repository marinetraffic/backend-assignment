<?php

use App\Http\Controllers\Api\v1\VesselTrackingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/v1/getVessels' , [VesselTrackingController::class , 'index'])->middleware('request_logger');
