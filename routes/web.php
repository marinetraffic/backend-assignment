<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['prefix' => 'api','middleware' => 'Throttle:10,60'], function () use ($router) {

  $router->get('details', [
    'middleware' => App\Http\Middleware\RateLimits::class,
    'uses' => 'VSDetailsController@showDetails'
]);
  $router->post('add', [
    'middleware' => App\Http\Middleware\RateLimits::class,
    'uses' => 'VSDetailsController@create'
]);
});
