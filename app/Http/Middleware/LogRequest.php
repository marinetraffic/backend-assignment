<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use App\Models\IncomingRequest;

class LogRequest
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
        IncomingRequest::create([
            "ip_address" => $request->ip(),
            "method" => $request->method(),
            "endpoint" => $request->path(),
            "params" => json_encode($request->query()),
            "requested_at" => Carbon::now(),
        ]);
        return $next($request);
    }
}
