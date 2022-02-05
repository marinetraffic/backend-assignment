<?php

namespace App\JsonApi\V1\Shippositions;

use App\Models\Shipposition;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Filters\Scope;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;

class ShippositionSchema extends Schema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Shipposition::class;
    
    protected ?array $defaultPagination = ['number' => 1];
    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make('mmsi'),
            Number::make('status'),
            Number::make('station_id'),
            Number::make('speed'),
            Number::make('lon'),
            Number::make('lat'),
            Number::make('course'),
            Number::make('heading'),
            Str::make('rot'),
            Number::make('timestamp'),
        ];
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this, 'mmsi'),
            Scope::make('lat-from'),
            Scope::make('lat-to'),
            Scope::make('lon-from'),
            Scope::make('lon-to'),
            Scope::make('timestamp-from'),
            Scope::make('timestamp-to'),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }

}
