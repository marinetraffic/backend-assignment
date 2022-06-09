<?php

namespace App\Utils;

use App\Models\VesselPosition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QueryBuilder
{
    /**
     * Construct query based on get params.
     * @param \Illuminate\Http\Request $request
     * @return Builder
     * @throws \Illuminate\Validation\ValidationException
     */
    public function make_query(Request $request): Builder
    {
        Validator::make($request->all(), [
            'mmsi_list' => 'array',
            'mmsi_list.*' => 'integer',
            'time_from' => 'integer',
            'time_to' => 'integer:gte:time_from',
            'lat_from' => 'numeric|between:-90,90',
            'lat_to' => 'numeric|between:-90,90',
            'lon_from' => 'numeric|between:-180,180',
            'lon_to' => 'numeric|between:-180,180',
        ])->validated();

        return VesselPosition::query()
            ->when($request->query('mmsi_list'), function ($query, $mmsi_list) {
                $query->wherein('mmsi', $mmsi_list);
            })
            ->when($request->query('time_from'), function ($query, $time_from) {
                $query->where('timestamp', '>=', Carbon::createFromTimestamp($time_from)->toISOString());
            })
            ->when($request->query('time_to'), function ($query, $time_to) {
                $query->where('timestamp', '<=', Carbon::createFromTimestamp($time_to)->toISOString());
            })
            ->when($request->query('lat_from'), function ($query, $lat_from) {
                $query->whereRaw("ST_Y(position) >= $lat_from");
            })->when($request->query('lat_to'), function ($query, $lat_to) {
                $query->whereRaw("ST_Y(position) <= $lat_to");
            })->when($request->query('lon_from'), function ($query, $lon_from) {
                $query->whereRaw("ST_X(position) >= $lon_from");
            })->when($request->query('lon_to'), function ($query, $lon_to) {
                $query->whereRaw("ST_X(position) <= $lon_to");
            });
    }
}
