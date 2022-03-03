<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogIncomingRequests {
    public function handle(Request $request, Closure $next) {
        $path = $request->path();
        $ip = $request->ip();
        $payload = $request->getContent();

        print_r($path);
        print_r($ip);
        print_r($payload);

        return $next($request);
    }
}
