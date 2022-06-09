<?php

namespace App\Adapters;

use App\Utils\ContentTypeMap;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemaOrg\Graph;
use Illuminate\Support\Str;

class LDJSONAdapter implements Adapter
{

    public function get_response(Builder $query)
    {
        $graph = new Graph();

        foreach ($query->get() as $item) {
            $graph->listItem(Str::random())
                ->identifier($item->id)
                ->mmsi($item->mmsi)
                ->status($item->status)
                ->station($item->station)
                ->speed($item->speed)
                ->course($item->course)
                ->heading($item->heading)
                ->rot($item->rot)
                ->lat($item->position->getLat())
                ->lon($item->position->getLng())
                ->timestamp($item->timestamp);

        };

        return response($graph)->header("Content-Type","application/ld+json");
    }
}
