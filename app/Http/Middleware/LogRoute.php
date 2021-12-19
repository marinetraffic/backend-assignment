<?php
namespace App\Http\Middleware;
use Log;
use Closure;

class LogRoute
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function  handle($request, Closure $next)
    {
       
        $log = [
                'URI' => $request->getUri(),
                'METHOD' => $request->getMethod(),
                'REQUEST_BODY' => $request->all(),
            ];

        //             $data = [ 
        // 'Request Method' => $request->method(),
        //     'Request Path' => $request->path(),
        //     'Requesting User' => $request->user()->toArray(),
        //     'Request Params' => $request->all(),
        //     'Request IP' => $request->ip(),
        //     'Origin' => $request->header('host'),
        // ];

        Log::info(json_encode($log));

           // Log::info(json_encode($log));
       return $next($request);
    }

}