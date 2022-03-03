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
            'application/xml',
            'text/csv',
        ];

        $headers = $request->header();
        $acceptHeader = $request->header('accept');
    
        // If the accept header requested is not part of the allowed ones
        // the throw error response.
        if(!in_array($acceptHeader, $validContentTypes))
            throw new MediaIsNotSupported();

        if(!$acceptHeader)
            $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
