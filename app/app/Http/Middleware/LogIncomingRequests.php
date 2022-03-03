<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogIncomingRequests {
    public function handle(Request $request, Closure $next) {
        // Store request movement to database.
        $logIncomingReq = new \App\Models\LogIncomingRequests;
        $logIncomingReq->ip = $request->ip();
        $logIncomingReq->url = $request->getRequestUri();
        $logIncomingReq->payload = $request->getContent();
        $logIncomingReq->save();

        return $next($request);
    }
}
