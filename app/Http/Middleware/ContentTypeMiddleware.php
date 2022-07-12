<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentTypeMiddleware
{
    private static $XML_CONTENT_TYPE = "application/xml";
    private static $CSV_CONTENT_TYPE = "application/csv";


    public function handle(Request $request, Closure $next)
    {
        if($request->hasHeader('content-type'))
        {
            if($request->header('content-type') == self::$XML_CONTENT_TYPE)
            {

                $xml = simplexml_load_string($request->getContent(), "SimpleXMLElement", LIBXML_NOCDATA);
                $array = json_decode(json_encode($xml), true);
                $request->merge($array);

            }
        }

        return $next($request);
    }
}
