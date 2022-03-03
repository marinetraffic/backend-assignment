<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\HttpCodes;

class InvalidParameter extends Exception {
    protected $message;
    protected $parameter;

    public function __construct($m='', $p='') {
        $this->message = $m ? $m : 'Invalid parameter used...';
        $this->parameter = $p ? $p : '';
    }

    public function render($request) {
        return response()->json( [
            'status'=>false,
            'errorCode'=>'err02',
            'message'=>$this->message,
        ], HttpCodes::BAD_REQUEST);
    }
}
