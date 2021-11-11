<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequest
{

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (app()->environment('local')) {
            $log = [
                'URI' => $request->getUri(),
                'METHOD' => $request->getMethod(),
                'IP' => $request->getClientIp(),
                'REQUEST_BODY' => $request->all(),
                'RESPONSE' => $response->getContent()
            ];

            Log::info(json_encode($log));
        }

        return $response;
    }
}
