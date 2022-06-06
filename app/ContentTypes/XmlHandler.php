<?php

namespace App\ContentTypes;

use App\Http\Resources\XmlResourceCollection;
use App\Interfaces\ContentTypeHandlerInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class XmlHandler implements ContentTypeHandlerInterface
{
    public function create_response(array $array_of_data): Application|ResponseFactory|Response
    {
        return response((new XmlResourceCollection($array_of_data))->convertArrayToXml())->withHeaders(['Content-Type' => 'application/xml']);
    }
}
