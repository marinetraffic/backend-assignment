<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

class LogIncomingRequest
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->logger->info(sprintf('%s request - %s', $request->getMethod(), $request->getUri()));

        return $next($request);
    }
}
