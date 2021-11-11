<?php

namespace App\Http\Controllers;

use App\Repositories\VesselPositionRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * @var VesselPositionRepository
     */
    private $repository;


    public function __construct(){
        //TODO: Inject Repository
        $this->repository = new VesselPositionRepository();
    }

    public function index(Request $request){
        $filters = $this->processRequestParams($request->all());

        $data = $this->repository->matching($filters);

        $accept = request()->header('accept');

        if( $accept === 'application/xml' )
        {
            return response()->xml($data->toArray(), "vessel");
        }

        if( $accept === 'text/csv' )
        {
            return response()->csv($data->toArray());
        }

        if( $accept === 'application/vnd.api+json' )
        {
            return response()->json($data->toArray())->header('Content-Type', 'application/vnd.api+json');
        }

        if( $accept === 'application/ld+json' )
        {
            return response()->jsonLd($data->toArray())->header('Content-Type', 'application/ld+json');
        }

        if( $accept === 'application/json' )
        {
            return response()->jsonLd($data->toArray())->header('Content-Type', 'application/ld+json');
        }

        //return default
        return  response()->json($data->toArray());

    }

    private function processRequestParams(array $requestParams){


        //TODO: Create separate class for processing api request params

        foreach ($requestParams as $name => $value){

            if (strpos($value, ",") !== false){
                $requestParams[$name] = explode(",", $value);
            }

            if (strpos($value, "[and]") !== false){
                $range = explode("[and]", $value);
                $resolvedRange = [];
                foreach ($range as $id => $rangeItem){
                    if (strpos($rangeItem, "gt:") !== false){
                        $resolvedRange["min"] = str_replace("gt:", "", $rangeItem );
                    }
                    if (strpos($rangeItem, "lt:") !== false){
                        $resolvedRange["max"] = str_replace("lt:", "", $rangeItem );
                    }
                }
                $requestParams[$name] = $resolvedRange;
            }
        }
        return $requestParams;
    }
}
