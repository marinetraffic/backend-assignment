<?php

namespace App\Http\Middleware;

use App\Models\ApiRequestLogs;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class ApiRequestLogMiddleware
{
    private ApiRequestLogs $log;

    public function __construct(ApiRequestLogs $log)
    {
        $this->log = $log;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->log->url = $request->fullUrl();
        $this->log->method = $request->method();
        $this->log->body = $request->getContent();
        $this->log->ip = $request->ip();
        $this->log->status_code = $response->getStatusCode();
        $this->log->created_at = Carbon::now();
        $this->log->save();
    }
}
