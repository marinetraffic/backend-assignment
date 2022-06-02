<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiValidation;
use App\Helpers\VesselTrackingHandler;
use App\Http\Controllers\Controller;
use App\Models\ApiRequestLogs;
use App\Models\ShipPosition;
use Carbon\Carbon;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Http\Request;

class VesselTrackingController extends Controller
{
    public function index(Request $request){

        if(empty($request->getContent()))
            return response()->json(['error' => 'Not Found'], 404);

        $requestInfo = json_decode($request->getContent(), true);

        if(!is_array($requestInfo))
            return response()->json(['error' => 'Bad Format on Your Json body'], 400);

        if($this->checkRateLimiter(request()->ip())){
            return response()->json(['error' => 'You have reached your 10 request/hour limit, try again in 1 hour!'], 400);
        }

        $vesselHandler = new VesselTrackingHandler($requestInfo);
        $apiValidation = new ApiValidation($vesselHandler);

        if(!$apiValidation->mmsiExistWithoutTimeStamps())
            return response()->json(['error' => 'You have to provide at least one mmsi or filtering method!'], 400);

        if(!$apiValidation->isFormatValid())
            return response()->json(['message' => 'Requested Format is not supported!'], 400);

        if (!empty($vesselHandler->getMmsi())) {
            $shipPositions = ShipPosition::whereIn('mmsi', $vesselHandler->getMmsi());
        } else {
            $shipPositions = ShipPosition::query();
        }

        if (!is_null($vesselHandler->getFilterTimeFrom())) {
            $shipPositions->where('timestamp', '>=', Carbon::create($vesselHandler->getFilterTimeFrom()));
        }

        if (!is_null($vesselHandler->getFilterTimeTo())) {

            if (!$apiValidation->isTimeToGreaterThanTimeFrom())
                return response()->json(['error' => 'time_to must be greater than or equal to time_from'], 400);

            $shipPositions->where('timestamp', '<=', Carbon::create($vesselHandler->getFilterTimeTo()));
        }

        if(!empty($vesselHandler->getLatitudes())){
            if($apiValidation->isLatitudesValid()){
                $shipPositions->where('lat', '>=' , $vesselHandler->getLatitudes()[0])
                ->where('lat', '<=' , $vesselHandler->getLatitudes()[1]);
            }else{
                return response()->json(['error' => 'You must provide 2 values for latitude range'], 400);
            }
        }

        if(!empty($vesselHandler->getLongitudes())){
            if($apiValidation->isLongitudesValid()){
                $shipPositions->where('lon', '>=' , $vesselHandler->getLongitudes()[0])
                    ->where('lon', '<=' , $vesselHandler->getLongitudes()[1]);
            }else{
                return response()->json(['error' => 'You must provide 2 values for longitude range'], 400);
            }
        }

        switch ($vesselHandler->getFormat()){
            case ApiValidation::CONTENT_TYPE_CSV:{
                $headers = [
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
                    , 'Content-type' => 'text/csv'
                    , 'Content-Disposition' => 'attachment; filename=vessel_positions.csv'
                    , 'Expires' => '0'
                    , 'Pragma' => 'public'
                ];
                $positions = $shipPositions->orderBy('id')->get()->toArray();
                array_unshift($positions, array_keys($positions[0]));
                $callback = function () use ($positions) {
                    $csvResult = fopen('php://output', 'w');
                    foreach ($positions as $row) {
                        fputcsv($csvResult, $row);
                    }
                    fclose($csvResult);
                };

                return response()->stream($callback, 201, $headers);
            }
            case ApiValidation::CONTENT_TYPE_XML:{
                $positions = $shipPositions->orderBy('id')->get()->toArray();
                $result = ArrayToXml::convert(['vessel_position' => $positions]);
                return response()->xml($result);
            }
            case ApiValidation::CONTENT_TYPE_VND_jSON:{
                $positions = $shipPositions->orderBy('id')->get()->toArray();
                return response($positions)->header('Content-Type', 'application/vnd.api+json');
            }
            default : {
                return response()->json($shipPositions->orderBy('id')->get(), 201);
            }
        }
    }

    private function checkRateLimiter(?string $ip): bool
    {
        $apiRequestsCounts = ApiRequestLogs::where('ip', $ip)
            ->where('created_at', '>=', Carbon::now()->subHours()->toDateTimeString()
            )->whereIn('status_code', [200, 201])->count();

        if ($apiRequestsCounts >= 10){
            return true;
        }

        return false;
    }

}
