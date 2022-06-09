<?php

namespace App\Http\Controllers;

use App\Utils\ContentTypeMap;
use App\Utils\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VesselPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, QueryBuilder $qb)
    {
        $query = $qb->make_query($request);
        $adapter = ContentTypeMap::getAdapter($request->header("Accept"));
        if ($adapter) {
            return $adapter->get_response($query);
        }

        return response("Content type not supported", 406);
    }


}
