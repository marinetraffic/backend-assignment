<?php

namespace App\Exceptions;

use Exception;

class InvalidParameter extends Exception {
    protected $message;

    public function __construct($m='', $p='') {
        $this->message = $m ? $m : 'Invalid parameter used...';
    }

    public function render($request) {
        return response()->json( [
            'status'=>false,
            'errorCode'=>'err02',
            'message'=>$this->message,
        ], 404);
    }
}
