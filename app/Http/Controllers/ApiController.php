<?php

namespace App\Http\Controllers;

use App\Repositories\VesselPositionRepository;
use App\Utilities\ParamsResolver;
use App\VesselPosition\ResponseFormatter;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * @var VesselPositionRepository
     */
    private $repository;


    public function __construct(VesselPositionRepository $repository){
        $this->repository = $repository;
    }


    public function index(Request $request){

        $filters = ParamsResolver::resolve($request->all());

        $data = $this->repository->matching($filters);

        $accept = request()->header('accept');

        $responseFormatter = new ResponseFormatter($data);

        return $responseFormatter->format($accept);

    }
}
