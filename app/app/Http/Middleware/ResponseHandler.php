<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Conversions;
// use SimpleXMLElement;

class ResponseHandler {
    public function handle(Request $request, Closure $next) {
        $response = $next($request);
        $httpCode = $response->status();
        $acceptHeader = $request->header('accept');

        // Convert response back to array.
        $response = json_decode(json_encode($response->original), true);

        if($acceptHeader == 'application/json') 
            return response()->json($response, $httpCode)
                ->header('Content-Type', 'application/json');

        // Based on the accept header change the representation of the response.
        switch($acceptHeader) {
            case 'application/vnd.api+json':
                $jsonApiResponse = [];

                if($response['status']) {
                    $jsonApiResponse['data'] = $response['data'];
                } else {
                    unset($response['status']);
                    $jsonApiResponse['error'] = $response;
                }

                return response()->json(
                    $jsonApiResponse, 
                    $httpCode
                )->header('Content-Type', 'application/vnd.api+json');
            break;
            case 'application/xml':
                $conv = new Conversions();
                $xml = new \SimpleXMLElement('<root/>');
                
                header('Content-type: text/xml');
                $conv->arrayToXml($response, $xml);
                echo $xml->asXML();
                
                return response('');
            break;
        }
    }
}
