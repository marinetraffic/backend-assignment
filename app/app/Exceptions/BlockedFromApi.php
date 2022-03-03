<?php

namespace App\Exceptions;

use Exception;

class BlockedFromApi extends Exception {
    protected $message;

    public function __construct($m='') {
        $this->message = $m ? $m : 'You cannot use the API endpoints. You are blocked due to excessive requests...';
    }

    public function render($request) {
        return response()->json( [
            'status'=>false,
            'errorCode'=>'err03',
            'message'=>$this->message,
        ], 401);
    }
}
