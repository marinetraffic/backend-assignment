<?php

namespace App\Traits;

use App\Enums\ContentTypes;
use App\Exports\PositionsExport;
use App\Http\Resources\PositionResource;
use Maatwebsite\Excel\Excel;
use Spatie\ArrayToXml\ArrayToXml;
use Spatie\SchemaOrg\Graph;

trait PositionTrait{
    public function getFormattedResponse($contentType, $query){
        if ($contentType == ContentTypes::CSV) {

            return (new PositionsExport($query))->download('invoices.csv', Excel::CSV, [
                'Content-Type' => ContentTypes::CSV,
            ]);
        } else if ($contentType == ContentTypes::XML) {
            $xmlData = ArrayToXml::convert(['__numeric' => $query->get()->toArray()]);

            return response()->xml($xmlData);
        } else if ($contentType == ContentTypes::JSON) {

            return PositionResource::collection(
                $query->paginate(100));

        } else if ($contentType == ContentTypes::LD) {
            $graph = new Graph();

            foreach ($query->get() as $position) {

                $graph->listItem($position->lat)
                    ->identifier($position->mmsi)
                    ->mmsi($position->mmsi)
                    ->status($position->status)
                    ->station($position->station)
                    ->speed($position->speed)
                    ->lon($position->lon)
                    ->lat($position->lat)
                    ->course($position->course)
                    ->heading($position->heading)
                    ->rot($position->rot)
                    ->timestamp($position->timestamp);

            };

            return response($graph)->header('Content-Type', ContentTypes::LD);
        } else {

            return response()->json([
                'message' => 'Invalid Content Typet',
                'code' => 415
            ], 415);
        }
    }
}
