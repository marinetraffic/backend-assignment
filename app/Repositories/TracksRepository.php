<?php


namespace App\Repositories;

use App\Models\Tracks;
use SoapBox\Formatter\Formatter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @author Elton
 * Class ShipRepository
 * @package App\Repositories
 */

class TracksRepository
{

    /**
     * Return content as JSON
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function asJson($filters)
    {
        return response($this->retrieve($filters)->toJson(), 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Return content as HAL
     * @param $filters
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function asHal($filters)
    {
        $tracks=$this->retrieve($filters);
        foreach ($tracks as $index=>$track) {
            $track->_links=['self'=>['href'=>"{$filters['path']}?mmsi=" . $track->mmsi, 'hreflang'=>'en', 'type'=>'application/hal+json']];
        }
        return response($tracks, 200)
            ->header('Content-Type', 'application/hal+json');
    }

    /**
     * Return content as XML
     * @param $filters
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function asXml($filters)
    {
        $response=Formatter::make($this->retrieve($filters)->toJson(), Formatter::JSON)->toXml();
        return response($response, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Return content as csv
     * @param $filters
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function asCsv($filters)
    {
        $response=Formatter::make($this->retrieve($filters)->toJson(), Formatter::CSV)->toCsv();
        return response($response, 200)
            ->header('Content-Type', 'text/csv');
    }

    /**
     * Retrieve data based on filter params from Ship::mode()
     * @return string
     */
    protected function retrieve($filters)
    {
        return Tracks::whereIn('mmsi', $filters['mmsi'])
            ->whereBetween('timestamp', $filters['timestamp'])
            ->whereBetween('lon', $filters['lon'])
            ->whereBetween('lat', $filters['lat'])
            ->orderBy('mmsi')
            ->get();
    }

}
