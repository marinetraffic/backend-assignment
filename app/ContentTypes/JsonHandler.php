<?php

namespace App\ContentTypes;

use App\Interfaces\ContentTypeHandlerInterface;
use Illuminate\Http\JsonResponse;

class JsonHandler implements ContentTypeHandlerInterface
{
    public function create_response(array $array_of_data): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Retrieved successfully',
            'data' => $array_of_data
        ])->withHeaders(['Content-Type' => 'application/json']);
    }
}
