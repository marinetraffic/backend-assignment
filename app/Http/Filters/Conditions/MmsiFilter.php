<?php

namespace App\Http\Filters\Conditions;

use App\Http\Filters\FilterContracts;
use Illuminate\Database\Eloquent\Builder;

class MmsiFilter implements FilterContracts
{

    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, $value)
    {
        return $builder;
    }
}
