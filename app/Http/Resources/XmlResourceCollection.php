<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Responsable;
use SimpleXMLElement;

class XmlResourceCollection implements Responsable
{
    protected array $vesselPositions;

    public function __construct(array $vesselsPositions)
    {
        $this->vesselPositions = $vesselsPositions;
    }

    public function convertArrayToXml(): bool|string
    {
        $xml = new SimpleXMLElement('<root></root>');
        $xml->addChild('status', 'success');
        $xml->addChild('code', 200);
        $xml->addChild('message', 'Retrieved successfully');

        foreach ($this->vesselPositions as $vp) {
            $node = $xml->addChild('VesselPositionData');

            $node?->addChild('mmsi', $vp['vessel_id']);
            $node?->addChild('status', $vp['status']);
            $node?->addChild('station_id', $vp['station_id']);
            $node?->addChild('speed', $vp['speed']);
            $node?->addChild('longitude', $vp['longitude']);
            $node?->addChild('latitude', $vp['latitude']);
            $node?->addChild('course', $vp['course']);
            $node?->addChild('heading', $vp['heading']);
            $node?->addChild('rate_of_turn', $vp['rate_of_turn']);
            $node?->addChild('timestamp', $vp['timestamp']);
        }

        return $xml->asXML();
    }

    public function toResponse($request)
    {
    }
}
