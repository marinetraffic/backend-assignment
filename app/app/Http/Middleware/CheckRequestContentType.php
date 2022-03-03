<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\MediaIsNotSupported;

class CheckRequestContentType {
    public function handle(Request $request, Closure $next) {
        // If env is testing then skipp middleware
        if (env('APP_ENV') === 'testing') 
            return $next($request);

        $validContentTypes = [
            'application/json',
            'application/vnd.api+json',
        ];

        $headers = $request->header();
        $acceptHeader = $request->header('accept') 
            ? $request->header('accept')
            : 'application/json';
    
        // If the accept header requested is not part of the allowed ones
        // the throw error response.
        if(!in_array($acceptHeader, $validContentTypes))
            throw new MediaIsNotSupported();

        return $next($request);
    }
}
