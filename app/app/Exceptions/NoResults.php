<?php

namespace App\Exceptions;

use Exception;

class NoResults extends Exception {
    protected $message;

    public function __construct($m='') {
        $this->message = $m ? $m : 'No results found...';
    }

    public function render($request) {
        return response()->json( [
            'status'=>false,
            'errorCode'=>'err01',
            'message'=>$this->message,
        ], 404);
    }
}
