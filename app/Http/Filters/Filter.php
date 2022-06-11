<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Filter
{
    /**
     * @var Request
     */
    protected Request $request;

    /*
     * Initialize the request
     */
    public function __construct(Request $request){
        $this->request = $request;
    }

    /*
     * Loop through the available filter and call the matching class
     */
    public function apply(Builder $builder, array $filters): Builder
    {
        foreach ($this->resolvedFilter($filters) as $key=>$filter){
            if(!$filter instanceof FilterContracts){
                continue;
            }

            $filter->apply($builder, $this->request->get($key));
        }

        return $builder;
    }


    /*
     * Filter The keys return only the keys already declared
     */
    protected function resolvedFilter(array $filters): array
    {
        return \Illuminate\Support\Arr::only(
            $filters,
            array_keys($this->request->all())
        );
    }


}
