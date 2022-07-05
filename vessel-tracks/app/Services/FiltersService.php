<?php

namespace App\Services;


use App\Models\ShipPosition;
use Illuminate\Http\Request;
use SimpleXMLElement;

class FiltersService{

    public function handle(Request $request) {

        $params = $request->only('mmsi','time','latlong');
        $query = ShipPosition::all()->makeHidden(['created_at','updated_at' ]);

        foreach ($params as $key => $value) {
            $filter = 'filterBy'.$key;
            try{
                $query = ShipPosition::$filter($value)->get()->makeHidden(['created_at','updated_at' ]);
            }
            catch (\Exception $exception){
                return $exception->getMessage();
            }
        }



        ContentTypeService::handle($query, $request);

        return $query;

    }

}
