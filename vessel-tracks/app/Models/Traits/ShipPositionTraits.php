<?php
namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
trait ShipPositionTraits{

    public function scopeFilterByMmsi($query, $mmsi)
    {
        $mmsiArr =explode(',',$mmsi);

        return $query->whereIn('mmsi', $mmsiArr);
    }

    public function scopeFilterByTime($query, $time)
    {
        $wrongDateFormat = 'Invalid date format. Please check your values and try again';

        $timeInterval = explode(',',$time);

        if(count($timeInterval) !== 2){
            if (!empty($errors['errors'])) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' =>$wrongDateFormat
                ], 422));
            }
        }

        /* Check if data is date */
        \DateTime::createFromFormat('Y-m-d\TH:i:s', $timeInterval[0]);
        $errors = \DateTime::getLastErrors();
        if (!empty($errors['errors'])) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' =>$wrongDateFormat
            ], 422));
        }

        \DateTime::createFromFormat('Y-m-d\TH:i:s', $timeInterval[1]);
        $errors = \DateTime::getLastErrors();
        if (!empty($errors['errors'])) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' =>$wrongDateFormat
            ], 422));
        }

        $timeFrom = Carbon::parse($timeInterval[0])->timestamp;
        $timeTo = Carbon::parse($timeInterval[1])->timestamp;

        if($timeFrom > $timeTo){
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' =>'End date must be bigger than start date'
            ], 422));
        }

        return $query->whereBetween('timestamp',[$timeFrom, $timeTo]);
    }

    public function scopeFilterBylatlong($query, $latlong)
    {

        $latLongExplode = explode(',', $latlong);

        try {
            $lat = floatval($latLongExplode[0]);
            $long = floatval($latLongExplode[1]);

            return $query->where('longitude', $long)->where('latitude', $lat);
            
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' =>'Invalid longitude and latitude data'
            ], 422));

        }

    }
}
