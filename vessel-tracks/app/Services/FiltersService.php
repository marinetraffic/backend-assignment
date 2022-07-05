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

            $query = ShipPosition::$filter($value);

            $query = $query->get()->makeHidden(['created_at','updated_at' ]);
        }

        ContentTypeService::handle($query, $request);

        return $query;

    }

}
