<?php

namespace App\Traits;




use App\Http\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait CanBeFiltered
{
    /*
     *  Return the newly built up query based on the filter provided
     */
    public function scopeWithFilter(Builder $builder, $filter = []): Builder
    {
        return (new Filter(request()))->apply($builder, $filter);
    }
}
