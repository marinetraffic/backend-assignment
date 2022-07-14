<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentTypeMiddleware
{
    private static $XML_CONTENT_TYPE = 'application/xml';
    private static $CSV_CONTENT_TYPE = 'application/csv';
    private static $JSON_API__CONTENT_TYPE = 'application/vnd.api+json';



    public function handle(Request $request, Closure $next)
    {
        if($request->hasHeader('Content-Type'))
        {
            if($request->header('Content-Type') == self::$XML_CONTENT_TYPE)
            {
                $xml = simplexml_load_string($request->getContent(), "SimpleXMLElement", LIBXML_NOCDATA);
                $arr = json_decode(json_encode($xml), true);
                $request->merge($arr);
            }
            elseif($request->header('Content-Type') == self::$CSV_CONTENT_TYPE)
            {
                $csv_content = $request->getContent();
                $lines = explode("\n", $csv_content);
                if(count($lines) != 2)
                    return response("Invalid CSV", Response::HTTP_BAD_REQUEST);
                $arr = array_combine(str_getcsv($lines[0]), str_getcsv($lines[1]));
                $request->merge($arr);
            }
            elseif($request->header('Content-Type') == self::$JSON_API__CONTENT_TYPE)
            {
                $request['json+api'] = true;
            }
        }

        return $next($request);
    }
}
