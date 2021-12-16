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
        $response = $next($request);

        //APP_NAME=ParaskevakosRestApi at .env
        $response->headers->set($headerName, config('app.name'));

        return $response;
    }
}
