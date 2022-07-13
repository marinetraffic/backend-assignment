<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackCreateRequest;
use App\Http\Requests\TrackFilterRequest;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use App\ResponseManager;
use App\TrackFilterer;
use \Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackController extends Controller
{
    /**
     * Returns the tracks according to the provided filters.
     *
     * @param TrackFilterRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(TrackFilterRequest $request)
    {
        $tracks = TrackFilterer::make($request)->apply()->get();
        return ResponseManager::respond($request, TrackResource::collection($tracks), Response::HTTP_CREATED, true);
    }

    /**
     * Returns the track with the given id.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $track = Track::findOrFail($id);
        return ResponseManager::respond($request, new TrackResource($track), Response::HTTP_CREATED, false);
    }

    /**
     * Stores in the database a new track
     *
     * @param TrackCreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(TrackCreateRequest $request)
    {
        $track = Track::create(
            $request->only('mmsi', 'status', 'stationId', 'speed', 'lon', 'lat', 'course', 'heading', 'rot', 'timestamp')
        );
        return ResponseManager::respond($request, new TrackResource($track), Response::HTTP_CREATED, false);
    }

    /**
     * Updates the values of the Track with the given id.
     *
     * @param TrackCreateRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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
        return ResponseManager::respond($request, new TrackResource($track), Response::HTTP_ACCEPTED, false);
    }

    /**
     * Destroys the Track with the given id.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Track::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
