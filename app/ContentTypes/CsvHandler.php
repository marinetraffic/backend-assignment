<?php

namespace App\ContentTypes;

use App\Http\Resources\CsvResourceCollection;
use App\Interfaces\ContentTypeHandlerInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvHandler implements ContentTypeHandlerInterface
{
    public function create_response(array $array_of_data): StreamedResponse
    {
        return response()->stream((new CsvResourceCollection($array_of_data))->create(), 200, ['Content-Type' => 'text/csv']);
    }
}
