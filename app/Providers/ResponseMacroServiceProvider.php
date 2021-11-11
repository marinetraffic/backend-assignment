<?php


namespace App\Providers;


use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Spatie\ArrayToXml\ArrayToXml;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('xml', function (array $data, $nodeName = "item", int $status = 200) {
            $header['Content-Type'] = 'application/xml';
            $content = ArrayToXml::convert([$nodeName => $data]);
            return Response::make($content, 200, $header);
        });


        Response::macro('csv', function (array $data, int $status = 200)
        {
            $headerAdded = false;
            $csvData = "";
            foreach ($data as $item){
                if (!$headerAdded){
                    $csvData .= implode(",",array_keys($item)).PHP_EOL;
                    $headerAdded = true;
                }
                $csvData .= implode(",",array_values($item)).PHP_EOL;
            }

            return Response::make($csvData, $status)->withHeaders(['Content-Type' => 'text/csv']);
        });


        Response::macro('jsonLd', function (array $data, int $status = 200)
        {
            $json = [
                '@context'        => 'https://schema.org',
                '@type'           => 'VesselsList',
                'vesselListElement' => [],
            ];

            $i=0;
            foreach ($data as $item) {
                $json['vesselListElement'][] = [
                    '@type'    => 'Vessel',
                    'position' => $i + 1,
                    'item'     => [
                        '@mmsi'   => $item["mmsi"],
                        'status'  => $item["status"],
                        'stationId' => $item["stationId"],
                        'speed' => $item["stationId"],
                        'lon' => $item["lon"],
                        'lat' => $item["lat"],
                        'course' => $item["course"],
                        'heading' => $item["heading"],
                        'rot' => $item["rot"],
                        'timestamp' => $item["timestamp"],
                    ],
                ];
            }
            return Response::make(json_encode($json));
        });

    }
}
