<?php

namespace App;

use App\Http\Resources\TrackApiResource;
use App\Http\Resources\TrackResource;
use \Illuminate\Http\Request;

class ResponseManager
{
    public static function respond(Request $request, $data, $status, $isCollection=false)
    {

        if(isset($request['json+api']) && $request['json+api'])
        {
            $collection = TrackApiResource::class;
        }
        else {
            $collection = TrackResource::class;
        }

        if($isCollection)
        {
            return \response($collection::collection($data), $status);
        }
        else
        {
            return \response(new $collection($data), $status);
        }
    }
}
