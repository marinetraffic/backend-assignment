<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VesselTrack;
use Illuminate\Http\Request;

class VesselTrackController extends Controller
{
    public function list(Request $request): array
    {
        $data = VesselTrack::
            // mmsi
            when($request->mmsi, function ($query, $mmsi) {
                return $query->whereIn('mmsi', is_array($mmsi) ? $mmsi : [$mmsi]);
            })

            // lon
            ->when($request->lon, function ($query, $lon) {
                return $query->where('lon', $lon);
            })

            // lon from
            ->when($request->lon_from, function ($query, $lon_from) {
                return $query->where('lon', '>=', $lon_from);
            })

            // lon to
            ->when($request->lon_to, function ($query, $lon_to) {
                return $query->where('lon', '<=', $lon_to);
            })

            // lat
            ->when($request->lat, function ($query, $lat) {
                return $query->where('lat', $lat);
            })

            // lat from
            ->when($request->lat_from, function ($query, $lat_from) {
                return $query->where('lat', '>=', $lat_from);
            })

            // lat to
            ->when($request->lat_to, function ($query, $lat_to) {
                return $query->where('lat', '<=', $lat_to);
            })

            // timestamp
            ->when($request->timestamp, function ($query, $timestamp) {
                return $query->where('timestamp', $timestamp);
            })

            // timestamp from
            ->when($request->timestamp, function ($query, $timestamp_from) {
                return $query->where('timestamp', '>=', $timestamp_from);
            })

            // timestamp to
            ->when($request->timestamp, function ($query, $timestamp_to) {
                return $query->where('timestamp', '<=', $timestamp_to);
            })

            ->orderBy('id', 'DESC')
            ->get();

        return $data->toArray();
    }
}
