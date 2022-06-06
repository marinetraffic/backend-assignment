<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UnsupportedContentType extends Exception
{
    public function __construct(string $content_type)
    {
        $this->code = 415;
        $this->message = sprintf('%s is not supported as a content type.', $content_type);
    }

    public function render(): JsonResponse
    {
        return response()->json(['status' => 'failure', 'code' => $this->code, 'message' => $this->message], $this->code);
    }
}
