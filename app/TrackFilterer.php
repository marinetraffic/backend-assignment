<?php


namespace App;

use App\Models\Track;
use Illuminate\Http\Request;


class TrackFilterer
{
    private $query;
    private $mmsi;
    private $lon_range;
    private $lat_range;
    private $interval;

    /**
     * Creates an instance of this class
     *
     * @param Request $request
     * @return TrackFilterer
     */
    public static function make(Request $request)
    {
        return new TrackFilterer($request);
    }

    private function __construct(Request $request)
    {
        $this->query = Track::query();
        $this->mmsi = $request->input('mmsi');
        $this->lon_range = $request->input('lon_range');
        $this->lat_range = $request->input('lat_range');
        $this->interval = $request->input('interval');
    }

    /**
     * Creates a proper Query according to the requested filters
     *
     * @return $this
     */
    public function apply()
    {
        if($this->mmsi){
            $this->query->whereIn('mmsi', $this->mmsi);
        }
        if($this->lon_range){
            sort($this->lon_range);
            $this->query->whereBetween('lon', $this->lon_range);
        }
        if($this->lat_range){
            sort($this->lat_range);
            $this->query->whereBetween('lat', $this->lat_range);
        }
        if($this->interval){
            sort($this->interval);
            $this->query->whereBetween('timestamp', $this->interval);
        }
        return $this;
    }

    /**
     * Gets the tracks from the database by executing the built Query.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->query->get();
    }
}
