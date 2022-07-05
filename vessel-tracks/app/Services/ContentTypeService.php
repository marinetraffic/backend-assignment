<?php

namespace App\Services;


use App\Models\ShipPosition;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ContentTypeService{

    public function handle($data, Request $request){
        $contentType = $request->header('Content-Type');

        /* If no Content-Type header is present, Content-Type is set to json */
        (empty($contentType)) ? $contentType = "application/json" : "";

        switch ($contentType){
            case "application/json":
                $formattedData = ContentTypeService::dataToJson($data);
                break;
            case 'application/xml':
                $formattedData = ArrayToXMLService::handle($data)->asXML();
                break;
            case 'application/ld+json':
                $formattedData = ContentTypeService::dataToLdJson($data);
                break;
            case 'text/csv':
                $formattedData = ContentTypeService::dataToTextCsv($data);
                break;
            default:
                return  response('Content-Type ' .$contentType .' is not supported',415);
        }

        return $formattedData;
    }

    private function dataToJson($data)
    {
        return ResponseFactory::json($data);
    }

    private function dataToLdJson($data)
    {
        return ResponseFactory::json($data)->header('Content-Type', 'application/ld+json');
    }

    private function dataToTextCsv($data)
    {
        $headers = [
            'Cache-Control'           => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=positions.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        # add headers for each column
        $dataArr = $data->toArray();

        array_unshift($dataArr, array_keys($dataArr[0]));
        $callback = function() use ($dataArr)
        {
            $FH = fopen('php://output', 'w');
            foreach ($dataArr as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }

}
