<?php

namespace App\Responders;

use App\Interfaces\ResponseInterface;

class JsonResponder implements ResponseInterface{

    public function respond(array $data)
    {
        return response()->json($data);
    }

}