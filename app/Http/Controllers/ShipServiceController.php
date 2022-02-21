<?php

namespace App\Http\Controllers;

use App\Models\Tracks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Contracts\Routing\ResponseFactory;
use \Illuminate\Http;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @author Elton
 * @version One
 * Class ShipServiceController
 * @package App\Http\Controllers
 * Current api service not supports Api-KEY
 * Test cases class \tests\Feature\ShipServiceControllerTest.php
 * @example of full url: http://{host}:{port}/api/ship?mmsi=247039300,311486000&fromdate=1372694880&todate=1372700100&longitudefrom=2.3985&longitudeto=72.3985&latitudefrom=9.01322&latitudeto=190.01322&type=json
 */

class ShipServiceController extends Controller
{

    const HAL   =  'hal';
    const JSON  =  'json';
    const XML   =  'xml';
    const CSV   =  'csv';

    /**
     * Supported Media Content Types.
     * @var array[]
     */
    private static $supportedContentTypes = [self::HAL, self::JSON, self::XML, self::CSV];

    /**
     * Media Content Type
     */
    protected $contentType;

    /**
     * Maritime Mobile Service Identity
     * @var array
     */
    protected $mmsi=[];

    /**
     * @example api/ship
     * @var
     */
    protected $path;

    /**
     * unix timestamp
     * @var string
     */
    protected $from_date;

    /**
     * unix timestamp
     * @var string
     */
    protected $to_date;

    /**
     * unix timestamp
     * @var string
     */
    protected $longitude_from=-180;

    /**
     * @var string
     */
    protected $longitude_to=180;

    /**
     * @var string
     */
    protected $latitude_from=-90;

    /**
     * @var string
     */
    protected $latitude_to=90;

    /**
     * @TODO validate query params as expected
     * ShipServiceController constructor.
     * Init class params based on requested query params.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->path             =      $request->path();
        $this->mmsi             =      explode(',', $request->get('mmsi'));
        $this->contentType      =      !is_null($request->get('type'))?$request->get('type'):self::XML;//Set as default content type xml when is not defined
        $this->from_date        =      $request->get('fromdate', 0);//Set big bang timestamp
        $this->to_date          =      $request->get('todate', Carbon::now()->timestamp);//Set Current tstamp when is not defined
        $this->longitude_from   =      $request->get('longitudefrom', $this->longitude_from);//Set min {-180} longitude value when is not defined
        $this->longitude_to     =      $request->get('longitudeto', $this->longitude_to);//Set max {180} longitude value when is not defined
        $this->latitude_from    =      $request->get('latitudefrom', $this->latitude_from);//Set min {-90} latitude value when is not defined
        $this->latitude_to      =      $request->get('latitudeto', $this->latitude_to);//Set max {90} latitude value when is not defined
    }

    /**
     * Basic method of api service.
     * Provides ship tracks based on mmsi,time interval & latitude,longitude range.
     * Supported Content-Types [application/xml,application/json,application/hal+json,text/csv].
     * Default Content-Types is application/xml.
     * Parameter mmsi should be required.
     * @param Request $request
     * @return Application|ResponseFactory|Http\Response
     */
    public function search(Request $request)
    {
        if (!$request->has('mmsi')) {
            return response("400 Bad Request", 400)->header('Content-Type', 'text/html');
        }
        if (in_array($this->contentType, self::$supportedContentTypes)) {
            $tracks=$this->retrieve();
            switch ($this->contentType) {
                case self::CSV:
                    return $this->asCsv($tracks);
                case self::JSON:
                    return $this->asJson($tracks);
                case self::HAL:
                    return $this->asHal($tracks);
                case self::XML:
                    return $this->asXml($tracks);
            }
        }
        return response("Unsupported Content-Type:{$this->contentType}, accepts only:" . json_encode(self::$supportedContentTypes), 415)
            ->header('Content-Type', 'text/html');
    }

    /**
     * Return content as JSON
     * @param $tracks
     * @return Application|ResponseFactory|Http\Response
     */
    protected function asJson($tracks)
    {
        return response($tracks->toJson(), 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Return content as HAL
     * @param $tracks
     * @return Application|ResponseFactory|Http\Response
     */
    protected function asHal($tracks)
    {
        foreach ($tracks as $index=>$track) {
            $track->_links=['self'=>['href'=>"{$this->path}?mmsi=" . $track->mmsi, 'hreflang'=>'en', 'type'=>'application/hal+json']];
        }
        return response($tracks->toJson(), 200)
            ->header('Content-Type', 'application/hal+json');
    }

    /**
     * Return content as XML
     * @param $tracks
     * @return Application|ResponseFactory|Http\Response
     */
    protected function asXml($tracks)
    {
        $response=Formatter::make($tracks->toJson(), Formatter::JSON)->toXml();
        return response($response, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Return content as csv
     * @param $tracks
     * @return Application|ResponseFactory|Http\Response
     */
    protected function asCsv($tracks)
    {
        $response=Formatter::make($tracks->toJson(), Formatter::CSV)->toCsv();
        return response($response, 200)
            ->header('Content-Type', 'text/csv');
    }

    /**
     * Retrieve data based on params from Ship::mode()
     * @return Tracks
     */
    protected function retrieve()
    {
        return Tracks::whereIn('mmsi', $this->mmsi)
            ->whereBetween('timestamp', [$this->from_date,$this->to_date])
            ->whereBetween('lon', [$this->longitude_from,$this->longitude_to])
            ->whereBetween('lat',  [$this->latitude_from,$this->latitude_to])
            ->orderBy('mmsi')
            ->get();
    }
}
