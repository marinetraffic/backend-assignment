<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PositionRequest $request)
    {
        return PositionResource::collection(
            Position::query()
                ->when($request->query('mmsi'), function ($query, $mmsi) {
                    $query->where('mmsi', $mmsi);
                })
                ->when($request->query('maxLat'), function ($query, $maxLat) {
                    $query->where('lat', '<=', $maxLat);
                })
                ->when($request->query('minLat'), function ($query, $minLat) {
                    $query->where('lat', '>=', $minLat);
                })
                ->when($request->query('maxLon'), function ($query, $maxLon) {
                    $query->where('lon', '<=', $maxLon);
                })
                ->when($request->query('minLon'), function ($query, $minLon) {
                    $query->where('lon', '>=', $minLon);
                })
                ->when($request->query('fromDatetime'), function ($query, $fromDatetime) {
                    $query->where('timestamp', '>=', Carbon::parse($fromDatetime)->toISOString());
                })
                ->when($request->query('toDatetime'), function ($query, $toDatetime) {
                    $query->where('timestamp', '<=', Carbon::parse($toDatetime)->toISOString());
                })
                ->paginate(100));
    }
}
