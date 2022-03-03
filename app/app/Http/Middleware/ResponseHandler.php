<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ResponseHandler {
    public function handle(Request $request, Closure $next) {
        $response = $next($request);
        $httpCode = $response->status();
        $acceptHeader = $request->header('accept');

        // Convert response back to array.
        $response = json_decode(json_encode($response->original), true);

        if($acceptHeader == 'application/json') 
            return $response;

        // Based on the accept header change the representation of the response.
        $mimedResponse = [];
        switch($acceptHeader) {
            case 'application/vnd.api+json':
                if($response['status']) {
                    $mimedResponse['data'] = $response['data'];
                } else {
                    unset($response['status']);
                    $mimedResponse['error'] = $response;
                }
            break;
            case 'application/xml':

            break;

        }
        
        // Set the content type to be the same as the desired on Accept header
        return response()->json(
            $mimedResponse, 
            $httpCode,
            ['Content-Type => '.$acceptHeader]
        );
    }
}
