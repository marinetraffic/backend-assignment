<?php

namespace App\Adapters;

use Illuminate\Database\Eloquent\Builder;

class JSONAdapter implements Adapter
{

    public function get_response(Builder $query)
    {
        return response($query->get());
    }
}
