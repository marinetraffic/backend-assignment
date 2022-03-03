<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\HttpCodes;

class MediaIsNotSupported extends Exception {
    protected $message;
    protected $media;

    public function __construct($m='', $md='') {
        $this->message = $m ? $m : 'Unsupported media used...';
        $this->media = $md ? $md : '';
    }

    public function render($request) {
        return response()->json( [
            'status'=>false,
            'errorCode'=>'err04',
            'message'=>$this->message,
        ], HttpCodes::UNSUPPORTED_MEDIA);
    }
}
