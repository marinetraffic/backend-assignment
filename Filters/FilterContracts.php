<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterContracts
{
    /**
     * @param Builder $builder
     * @param $value
     */
    public function apply(Builder $builder, $value);
}
