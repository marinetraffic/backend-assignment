<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * We are active over the response
 * after the request...
 * We use this middleware to add a Header signature in our API
 */
class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $headerName = 'X-Name')
    {
        /**
         * Adding Access-Control-Allow-Origin header response
         */
        $response = $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

        /**
         * Add header signature
         * based on APP_NAME=ParaskevakosRestApi
         */
        $response->headers->set($headerName, config('app.name'));

        return $response;
    }
}
