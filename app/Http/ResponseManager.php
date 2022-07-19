<?php

namespace App\Http;

use App\Responders\CsvResponder;
use App\Responders\JsonResponder;
use App\Responders\XmlResponder;

class ResponseManager{

    public static function create($data, $contentType){
        if ($contentType == "text/csv"){
            $responder = new CsvResponder();
            return $responder->respond($data);
        }
        if ($contentType == "application/xml"){
            $responder = new XmlResponder();
            return $responder->respond($data);
        }
        if ($contentType == "application/vnd.api+json"){
            $responder = new JsonResponder();
            return $responder->respond($data);
        }
        else{
            $responder = new JsonResponder();
            return $responder->respond($data);
        }
    }
}