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
        return  response()->json($this->repository->matching($filters));
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
