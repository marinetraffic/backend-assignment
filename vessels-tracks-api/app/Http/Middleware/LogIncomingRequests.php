<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\IncomingRequest;

class LogIncomingRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $newIncomingRequest = new IncomingRequest();
        $newIncomingRequest->IP = $request->ip();
        $newIncomingRequest->request = json_encode($request);
        $newIncomingRequest->save();

        return $next($request);
    }
}
