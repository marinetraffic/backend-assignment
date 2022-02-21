<?php

namespace App\Http\Controllers;


use \Illuminate\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Contracts\Routing\ResponseFactory;
use App\Repositories\TracksRepository;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @author Elton
 * @version One
 * Class ShipServiceController
 * @package App\Http\Controllers
 * Current api service not supports Api-KEY
 * Test cases class \tests\Feature\ShipServiceControllerTest.php
 * @example of full url: http://{host}:{port}/api/ship?mmsi=311486000,311486000&timestamp=1372700160,1572700100&lon=11.20494,11.26997&lat=38.16413,80.16413&type=json
 */
class ShipServiceController extends Controller
{

    const HAL   =   'hal';
    const JSON  =   'json';
    const XML   =   'xml';
    const CSV   =   'csv';

    /**
     * Supported Media Content Types.
     * @var array[]
     */
    private static $supportedContentTypes=[self::HAL, self::JSON, self::XML, self::CSV];

    /**
     * Media Content Type
     */
    protected $contentType;

    /**
     * @var
     */
    protected $tracksRepo;

    /**
     * @var
     */
    protected $filters;

    /**
     * ShipServiceController constructor.
     * Init class params based on requested query params.
     * ShipServiceController constructor.
     * @param Request $request
     * @param TracksRepository $tracksRepo
     */
    public function __construct(Request $request, TracksRepository $tracksRepo)
    {
        $this->tracksRepo=$tracksRepo;
        $this->collectAndValidateParams($request);
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
            switch ($this->contentType) {
                case self::CSV:
                    return $this->tracksRepo->asCsv($this->filters);
                case self::JSON:
                    return $this->tracksRepo->asJson($this->filters);
                case self::HAL:
                    return $this->tracksRepo->asHal($this->filters);
                case self::XML:
                    return $this->tracksRepo->asXml($this->filters);
            }
        }
        return response("Unsupported Content-Type:{$this->contentType}, accepts only:" . json_encode(self::$supportedContentTypes), 415)
            ->header('Content-Type', 'text/html');
    }

    /**
     * Collect and validate query params
     * @param $request
     */
    protected function collectAndValidateParams($request)
    {
        $this->filters['path']=$request->path();
        $this->contentType=!is_null($request->get('type')) ? $request->get('type') : self::XML;//Set as default content type xml when is not defined
        $this->filters['mmsi']=explode(',', $request->get('mmsi'));

        if (is_null($request->get('timestamp'))) {
            $this->filters['timestamp']=[0, Carbon::now()->timestamp];
        } else {
            if (count(explode(',', $request->get('timestamp'))) == 1) {
                $this->filters['timestamp']=explode(',', $request->get('timestamp'));
                $this->filters['timestamp']=array_merge( $this->filters['timestamp'],explode(',', $request->get('timestamp')));
            } else {
                $this->filters['timestamp']=explode(',', $request->get('timestamp'));
            }
        }

        if (is_null($request->get('lon'))) {
            $this->filters['lon']=[-180, 180];//Set default longitude range [-180, 180]
        } else {
            if (count(explode(',', $request->get('lon'))) == 1) {
                $this->filters['lon']=explode(',', $request->get('lon'));
                $this->filters['lon']=array_merge( $this->filters['lon'],explode(',', $request->get('lon')));
            } else {
                $this->filters['lon']=explode(',', $request->get('lon'));
            }
        }

        if (is_null($request->get('lat'))) {
            $this->filters['lat']=[-90, 90];//Set default longitude range [-90, 90]
        } else {
            if (count(explode(',', $request->get('lat'))) == 1) {
                $this->filters['lat']=explode(',', $request->get('lat'));
                $this->filters['lat']=array_merge( $this->filters['lat'],explode(',', $request->get('lat')));
            } else {
                $this->filters['lat']=explode(',', $request->get('lat'));
            }
        }
    }

}
