<?php

namespace App\Http\Resources;

use Closure;
use League\Csv\Writer;

class CsvResourceCollection
{
    protected array $vesselPositions;

    public function __construct(array $vesselsPositions)
    {
        $this->vesselPositions = $vesselsPositions;
    }

    public function create(): Closure
    {
        $writer = Writer::createFromPath('php://temp');

        // Insert the headers
        $writer->insertOne([
            'internal_id',
            'mmsi',
            'status',
            'station_id',
            'speed',
            'longitude',
            'latitude',
            'course',
            'heading',
            'rate_of_turn',
            'timestamp'
        ]);

        $writer->insertAll($this->vesselPositions);

        echo $writer->toString();

        flush();
    }
}
