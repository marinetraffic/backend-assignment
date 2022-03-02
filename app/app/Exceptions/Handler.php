<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler {

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register() {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // public function render($request, Exception $exception) {
    //     if ($exception instanceof ModelNotFoundException) {
    //         return response()->json([
    //             'status'=>false,
    //             'message'=>'Resource could not be found...'
    //         ], 404);
    //     }

    //     return parent::render($request, $exception);
    // }
}
