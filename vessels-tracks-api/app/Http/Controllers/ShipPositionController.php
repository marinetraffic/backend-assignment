<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShipPosition;
use App\Utils\ShipLocationRequestReader;
use Illuminate\Http\Request;


class ShipPositionController extends Controller
{
    /**
     * Get all the Ship Positions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $requestInput = $request->input();

        switch ($request->header('Content-Type')) {
            case 'application/xml':
                $requestInput = (array)simplexml_load_string($request->getContent());
                break;
            case 'text/csv':
                $requestBodyPerLine = explode(PHP_EOL, $request->getContent());
                $keys = str_getcsv($requestBodyPerLine[0]);
                $values = str_getcsv($requestBodyPerLine[1]);
                $requestInput = array_combine($keys, $values);
                break;
        }
        $rr = new ShipLocationRequestReader($requestInput);
        
        return $rr->getResult();
    }
}
