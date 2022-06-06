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

        // Get rid of the internal IDs
        $writer->addFormatter(function (array $row) {
            unset($row['id']);

            return $row;
        });

        $writer->insertAll($this->vesselPositions);

        echo $writer->toString();

        return static function () {
        };
    }
}
