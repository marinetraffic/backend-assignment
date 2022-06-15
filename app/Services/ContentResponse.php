<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\Collection;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContentResponse
{
    protected string|null $type;

    public function __construct()
    {
        $this->processContentType();
    }

    protected function processContentType()
    {
        $contentType = request()->getContentType();


        if (is_null($contentType)) {
            $checkHeader = request()->header();

            $isContentType = $checkHeader['content-type'] ?? null;

            if (is_array($isContentType)) {
                $isCsv = empty($isContentType[0]) ? null : $isContentType[0];

                $contentType = is_null($isCsv) ? 'json' : last(explode('/', $isCsv));
            }
        }


        $this->type = $contentType;
    }

    public function handle($value): \Illuminate\Http\Response|StreamedResponse
    {
        if (method_exists($this, $handler = 'handle' . ucwords($this->type))) {
            dd($handler);
            return $this->{$handler}($value);
        }

        return $this->handleJson($value);

    }

    protected function handleJson($value): \Illuminate\Http\Response
    {
        return Response::make($value->paginate(10)->withQueryString())->header('Content-Type', 'application/json');
    }

    protected function handleJsonld($value): \Illuminate\Http\Response
    {
        return Response::make($value->paginate(10)->withQueryString())->header('Content-Type', 'application/ld+json');
    }

    protected function handleXml($value): \Illuminate\Http\Response
    {
        $xml = new SimpleXMLElement('<root/>');
        $this->to_xml($xml, $value->get()->toArray());
        return Response::make($xml->asXML())->header('Content-Type', 'application/xml');
    }


    protected function handleCsv($value)
    {
        $fileName = 'tasks.csv';
        $columns = array('Mmsi', 'Status', 'Station Id', 'Speed', 'Longitude', 'Latitude', 'Course', 'Heading', 'Rot', 'Timestamp');

        $callback = function () use ($value, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $value->lazy()->each(function ($data) use ($file) {
                $row['Mmsi'] = $data->mmsi;
                $row['Status'] = $data->status;
                $row['Station Id'] = $data->station_id;
                $row['Speed'] = $data->speed;
                $row['Longitude'] = $data->longitude;
                $row['Course'] = $data->course;
                $row['Heading'] = $data->heading;
                $row['Rot'] = $data->rot;
                $row['Timestamp'] = $data->timestamp;

                fputcsv($file, array($row['Mmsi'], $row['Status'], $row['Station Id'], $row['Speed'], $row['Longitude'], $row['Course'], $row['Heading'], $row['Rot'], $row['Timestamp']));
            });


            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }


    protected function to_xml(SimpleXMLElement $object, array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $new_object = $object->addChild($key);
                $this->to_xml($new_object, $value);
            } else {
                if ($key != 0 && $key == (int)$key) {
                    $key = "key_$key";
                }

                $object->addChild($key, $value);
            }
        }
    }
}
