<?php

namespace App\Http\Controllers;

use App\Enums\ContentTypes;
use App\Exports\PositionsExport;
use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Http\Resources\PositionXmlCollection;
use App\JsonApi\V1\Positions\PositionSchema;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use LaravelJsonApi\Core\Responses\DataResponse;
use Maatwebsite\Excel\Excel;
use Spatie\ArrayToXml\ArrayToXml;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\ListItem;
use Spatie\SchemaOrg\MultiTypedEntity;
use Spatie\SchemaOrg\Schema;

class PositionController extends Controller
{
    public function index(PositionRequest $request)
    {
        $query = Position::query()
            ->when($request->query('mmsi'), function ($query, $mmsi) {
                $query->where('mmsi', $mmsi);
            })
            ->when($request->query('maxLat'), function ($query, $maxLat) {
                $query->where('lat', '<=', $maxLat);
            })
            ->when($request->query('minLat'), function ($query, $minLat) {
                $query->where('lat', '>=', $minLat);
            })
            ->when($request->query('maxLon'), function ($query, $maxLon) {
                $query->where('lon', '<=', $maxLon);
            })
            ->when($request->query('minLon'), function ($query, $minLon) {
                $query->where('lon', '>=', $minLon);
            })
            ->when($request->query('fromDatetime'), function ($query, $fromDatetime) {
                $query->where('timestamp', '>=', Carbon::parse($fromDatetime)->toISOString());
            })
            ->when($request->query('toDatetime'), function ($query, $toDatetime) {
                $query->where('timestamp', '<=', Carbon::parse($toDatetime)->toISOString());
            });

        $contentType = $request->header('content_type');

        if($contentType == ContentTypes::CSV) {
            return (new PositionsExport($query))->download('invoices.csv', Excel::CSV, [
                'Content-Type' => ContentTypes::CSV,
            ]);
        } else if($contentType == ContentTypes::XML) {
            $xmlData = ArrayToXml::convert(['__numeric' => $query->get()->toArray()]);

            return response()->xml($xmlData);
        } else if ($contentType == ContentTypes::JSON) {

            return PositionResource::collection(
                $query->paginate(100));

        }else if ($contentType == ContentTypes::LD) {
            $graph = new Graph();

            foreach( $query->get() as $position) {

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
                    ->timestamp($position->timestamp)
                ;

            };

            return response($graph)->header('Content-Type', ContentTypes::LD);
        }  else {
            abort(415, 'Invalid Content Type');
        }
    }
}
