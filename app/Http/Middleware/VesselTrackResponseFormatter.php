<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VesselTrackResponseFormatter
{
    private const TYPE_JSON     = 'application/json';
    private const TYPE_XML      = 'application/xml';
    private const TYPE_CSV      = 'text/csv';
    private const TYPE_HAL_JSON = 'application/hal+json';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        switch ($this->getAcceptedType($request)) {
            case self::TYPE_JSON:
                return $this->FormatJson($response);
            case self::TYPE_XML:
                return $this->FormatXml($response);
            case self::TYPE_CSV:
                return $this->FormatCsv($response);
            case self::TYPE_HAL_JSON:
                $path = $request->path();
                $queryString = $request->server->get('QUERY_STRING');
                return $this->FormatHalJson($response, $path, $queryString);
        }

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return string|null
     */
    private function getAcceptedType(Request $request): ?string
    {
        // Other acceptable
        $acceptable  = $request->getAcceptableContentTypes();
        $supported   = [
            self::TYPE_JSON,
            self::TYPE_XML,
            self::TYPE_CSV,
            self::TYPE_HAL_JSON
        ];

        if (isset($acceptable[0]) && in_array($acceptable[0], $supported, true)) {
            return $acceptable[0];
        }

        return null;
    }

    /**
     * @param mixed $response
     *
     * @return mixed
     */
    private function FormatJson($response)
    {
        // Set header
        $response->header('Content-Type', self::TYPE_JSON);

        return $response;
    }

    /**
     * @param mixed $response
     *
     * @return mixed
     */
    private function FormatXml($response)
    {
        $data = $response->getOriginalContent();

        // Set content
        $response->setContent(array_to_xml($data));

        // Set header
        $response->header('Content-Type', self::TYPE_XML);

        return $response;
    }

    /**
     * @param mixed $response
     *
     * @return mixed
     */
    private function FormatCsv($response)
    {
        $data = $response->getOriginalContent();

        // Set content
        $response->setContent(array_to_csv($data));

        // Set header
        $response->header('Content-Type', self::TYPE_CSV);

        return $response;
    }

    /**
     * @param mixed $response
     *
     * @return mixed
     */
    private function FormatHalJson($response, string $path, string $queryString)
    {
        $data     = $response->getOriginalContent();
        $linkKeys = [
            'self'   => ['mmsi', 'lon', 'lat', 'timestamp'],
            'vessel' => ['mmsi'],
        ];

        // Set content
        $response->setData(array_to_hal_json($data, $path, $queryString, $linkKeys));

        // Set header
        $response->header('Content-Type', self::TYPE_HAL_JSON);

        return $response;
    }
}
