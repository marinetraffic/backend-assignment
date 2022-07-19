<?php

namespace App\Services;

use App\Models\IncomingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequestLoggerService
{
    protected $request;

    protected $response;

    public function __construct(Request $request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function logRequest()
    {

        $method = strtoupper($this->request->getMethod());
        $body = $this->request->getContent();
        $fullPath = $this->request->fullUrlWithoutQuery($this->avoids());
        
        $status_code = $this->response->getStatusCode();
        
        IncomingRequest::create([
            'method' => $method,
            'body' => $body,
            'url' => $fullPath,
            'ip_address' => $this->request->ip(),
            'status_code' => $status_code
        ]);
    }

    public function avoids()
    {
        return config('logres.avoids');
    }
}
