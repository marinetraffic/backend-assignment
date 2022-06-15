<?php

namespace App\Http\Filters\Conditions;

use App\Http\Filters\FilterContracts;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class TimeFilter implements FilterContracts
{

    /**
     * @throws \Exception
     */
    public function apply(Builder $builder, $value): Builder
    {

        $explodedValues = array_filter(explode(',', $value));

        if(count($explodedValues) !== 2){
            throw new Exception('Wrong Parameters');
        }

        $firstTimestamp = Carbon::parse($explodedValues[0])->timestamp;

        $secondTimestamp = Carbon::parse($explodedValues[1])->timestamp;

        if($secondTimestamp > $firstTimestamp){
            throw new Exception('Invalid Format');
        }

        return $builder->whereBetween('timestamp', [$secondTimestamp, $firstTimestamp]);
    }
}
