<?php

namespace App\Services;


use App\Models\ShipPosition;
use Illuminate\Http\Request;
use SimpleXMLElement;

class FiltersService{

    public function handle(Request $request) {

        $params = $request->only('mmsi','time','latlong');
        $query = ShipPosition::all();

        foreach ($params as $key => $value) {
            $filter = 'filterBy'.$key;
            try{
                $query = ShipPosition::$filter($value);
            }
            catch (\Exception $exception){
                return $exception->getMessage();
            }
        }

        $query= $query->get()->makeHidden(['created_at','updated_at' ]);
        ContentTypeService::handle($query, $request);

        return $query;


    }

}
