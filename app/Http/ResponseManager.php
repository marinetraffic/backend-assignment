<?php

namespace App\Http;

use App\Responders\CsvResponder;
use App\Responders\JsonResponder;

class ResponseManager{

    public static function create($data, $contentType){
        if ($contentType == "text/csv"){
            // dd("responding with csv");
            $responder = new CsvResponder();
            return $responder->respond($data);
        }
        else{
            $responder = new JsonResponder();
            return $responder->respond($data);
        }
    }
}