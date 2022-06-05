<?php

namespace Tests\Unit;

use App\Models\ShipPosition;
use Illuminate\Support\Facades\Artisan;
use League\Csv\Exception;
use League\Csv\Reader as CsvReader;
use Tests\TestCase;

class MultipleMmsiCsvOutputTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     * @throws Exception
     */
    public function test_multiple_mmsi_csv()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('marine:import-ship-positions');

        $ship_locations = ShipPosition::orderBy('id')->take(2)->get()->toArray();


        $response = $this->json('POST', 'api/v1/getVessels',
            [
                'mmsi' => [
                    $ship_locations[0]['mmsi'],
                    $ship_locations[1]['mmsi']
                ],
                'format' => 'text/csv'
            ]
        );

        $output = [];

        $response->assertHeader('Content-type', 'text/csv; charset=UTF-8');
        $reader = CsvReader::createFromString($response->streamedContent());
        $reader->setHeaderOffset(0);

        foreach ($reader->getRecords() as $key => $record) {
            $output[] = $record;
        }
        $output = array_slice($output, 0, 2);

        foreach ($output as $key => $item) {
            static::assertEquals($ship_locations[$key]['id'], $item['id']);
            static::assertEquals($ship_locations[$key]['mmsi'], $item['mmsi']);
            static::assertEquals($ship_locations[$key]['status'], $item['status']);
            static::assertEquals($ship_locations[$key]['stationId'], $item['stationId']);
            static::assertEquals($ship_locations[$key]['speed'], $item['speed']);
            static::assertEquals($ship_locations[$key]['lon'], $item['lon']);
            static::assertEquals($ship_locations[$key]['lat'], $item['lat']);
            static::assertEquals($ship_locations[$key]['course'], $item['course']);
            static::assertEquals($ship_locations[$key]['heading'], $item['heading']);
            static::assertEquals($ship_locations[$key]['rot'], $item['rot']);
            static::assertEquals($ship_locations[$key]['timestamp'], $item['timestamp']);
        }
        $response->assertStatus(201);
    }
}
