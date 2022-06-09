<?php

namespace App\Adapters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\ArrayToXml\ArrayToXml;

class XmlAdapter implements Adapter
{

    public function get_response(Builder $query)
    {
        $data = $query->get();
        return ArrayToXml::convert(["item"=>$data->toArray()]);
    }
}
