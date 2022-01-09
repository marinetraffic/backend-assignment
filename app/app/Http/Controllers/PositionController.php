<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use Carbon\Carbon;
use App\Traits\PositionTrait;

class PositionController extends Controller
{
    use PositionTrait;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Backend assignment API documentation",
     *      description="Backend assignment API documentation",
     * )
     *
     * @OA\Server(
     *      description="Local Server",
     *      url="/"
     * )
     */

    /**
     * @OA\Get(
     *      path="/api/positions",
     *      operationId="getPostionsList",
     *      tags={"Positions"},
     *      summary="Get list of ship positions",
     *      description="Returns list of ship positions",
     *
     *      @OA\Parameter(
     *         name="mmsi",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             example=247039300
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="maxLat",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="number",
     *             example=42.75
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="minLat",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="number",
     *             example=42.75
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="maxLon",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="number",
     *             example=42.75
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="minLon",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="number",
     *             example=42.75
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="fromDateTime",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="date",
     *             example="2013-07-02 17:44:00"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="toDateTime",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="date",
     *             example="2013-07-02 17:44:00"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       @OA\Response(response=425, description="Invalid Content Types")
     *     )
     *
     * Returns list of projects
     */
    public function index(PositionRequest $request)
    {
        $query = Position::query()
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
            });

        return $this->getFormattedResponse($request->header('content_type'), $query);
    }

}
