<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogService{

    public function handle(Request $request)
    {
        Log::channel('user_requests')->info(['ip'=>$request->ip(),'url' => Url()->full()]);
    }
}
