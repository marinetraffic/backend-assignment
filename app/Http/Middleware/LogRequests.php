<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    public function handle($request, Closure $next)
    {
        $request->start = microtime(true);
        return $next($request);
    }
    public function terminate($request, $response)
    {
        $request->end = microtime(true);
        $this->log($request, $response);
    }
    protected function log($request)
    {
        $duration = $request->end - $request->start;
        $url = $request->fullUrl();
        $method = $request->getMethod();
        $accept = $request->header("Accept");

        $ip = $request->getClientIp();
        $log = "{$ip} {$method}@{$url} - {$accept}  {$duration} ms";
        Log::info($log);
    }
}
