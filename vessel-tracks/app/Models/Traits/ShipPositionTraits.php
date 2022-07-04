<?php
namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait ShipPositionTraits{

    public function scopeFilterByMmsi($query, $mmsi)
    {
        $mmsiArr =explode(',',$mmsi);

        return $query->whereIn('mmsi', $mmsiArr);
    }

    public function scopeFilterByTime($query, $time)
    {
        $errMessage = 'Invalid date format. Please check your values and try again';

        $timeInterval = explode(',',$time);

        if(count($timeInterval) !== 2){
            throw new Exception($errMessage);
        }

        /* Check if data is date */
        $test=\DateTime::createFromFormat('Y-m-d\TH:i:s', $timeInterval[0]);
        $errors = \DateTime::getLastErrors();
        if (!empty($errors['errors'])) {
            throw new \Exception($errMessage);
        }
        \DateTime::createFromFormat('Y-m-d\TH:i:s', $timeInterval[1]);
        $errors = \DateTime::getLastErrors();
        if (!empty($errors['errors'])) {
            throw new \Exception($errMessage);
        }

        $timeFrom = Carbon::parse($timeInterval[0])->timestamp;
        $timeTo = Carbon::parse($timeInterval[1])->timestamp;

        if($timeFrom > $timeTo){
            throw new Exception($errMessage);
        }

        return $query->whereBetween('timestamp',[$timeFrom, $timeTo]);
    }

    public function scopeFilterBylatlong($query, $latlong)
    {
        $latLongExplode = explode(',',$latlong);

        if(array_key_exists(1,$latLongExplode)){

            $lat = $latLongExplode[0];
            $long = $latLongExplode[1];

            return $query->where('longitude',$long)->where('latitude',$lat);
        }
        else{
            throw new \Exception('Lattitude and Longitude is not on the correct format. Please check your values and try again');
        }
    }

}
