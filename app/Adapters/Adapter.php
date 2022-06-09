<?php

namespace App\Adapters;

use Illuminate\Database\Eloquent\Builder;

interface Adapter
{
    /**
     * Construct query based on get params.
     * @param Builder
     */
    public function get_response(Builder $query);
}
