<?php

namespace App\Http\Controllers;

use App\Exceptions\TrackFilterException;
use App\Http\Requests\TrackCreateRequest;
use App\Http\Requests\TrackFilterRequest;
use App\Http\Resources\TrackResourse;
use App\Models\Track;
use App\TrackFilterer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackController extends Controller
{
    public function index(TrackFilterRequest $request)
    {
        $tracks = TrackFilterer::make($request)->apply()->get();
        return TrackResourse::collection($tracks);
    }

    public function show($id)
    {
        $track = Track::findOrFail($id);
        return new TrackResourse($track);
    }

    public function store(TrackCreateRequest $request)
    {
        $track = Track::create(
            $request->only('mmsi', 'status', 'stationId', 'speed', 'lon', 'lat', 'course', 'heading', 'rot', 'timestamp')
        );
        return response(new TrackResourse($track), Response::HTTP_CREATED);
    }

    public function update(TrackCreateRequest $request, $id)
    {
        $track = Track::findOrFail($id);
        $track->update([
            'mmsi' => $request->input('mmsi'),
            'status' => $request->input('status'),
            'stationId' => $request->input('stationId'),
            'speed' => $request->input('speed'),
            'lon' => $request->input('lon'),
            'lat' => $request->input('lat'),
            'course' => $request->input('course'),
            'heading' => $request->input('heading'),
            'rot' => $request->input('rot'),
            'timestamp' => $request->input('timestamp'),
        ]);
        return response(new TrackResourse($track), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        Track::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
