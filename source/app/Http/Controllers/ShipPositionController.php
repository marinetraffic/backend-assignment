<?php

namespace App\Http\Controllers;

use App\Author;
use App\Models\Shipposition;
use Illuminate\Http\Request;
use League\Csv\Writer;

class ShipPositionController extends Controller
{
    private function exportCsv($data) {
        $csv = Writer::createFromFileObject(new \SplTempFileObject);
        $csv->insertOne(array_keys($data[0]->getAttributes()));
        
        $csv->insertAll($data->toArray());

        return response((string) $csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'attachment; filename="people.csv"',
        ]);
    }

    protected function buildQuery(Request $request) {
        $query = Shipposition::query();
        if ($request->has('filter')){
            $filter = $request->get('filter');
            if (array_key_exists('mmsi',$filter)) {
                $query = $query->whereIn("mmsi", $filter["mmsi"]);
            }
            if (array_key_exists("lat-from",$filter)) {
                $query = $query->where("lat", ">=", $filter["lat-from"]);
            }
            if (array_key_exists("lat-to", $filter)) {
                $query = $query->where("lat", "<=", $filter["lat-to"]);
            }
            if (array_key_exists("lon-from", $filter)) {
                $query = $query->where("lon", ">=", $filter["lon-from"]);
            }
            if (array_key_exists("lon-to", $filter)) {
                $query = $query->where("lon", "<=", $filter["lon-to"]);
            }
            if (array_key_exists("timestamp-from", $filter)) {
                $query = $query->where("timestamp", ">=", $filter["timestamp-from"]);
            }
            if (array_key_exists("timestamp-to", $filter)) {
                $query = $query->where("timestamp", "<=", $filter["timestamp-to"]);
            }
        }
        return $query;
    }

    public function showShipPositionsJson(Request $request)
    {
        $query = $this->buildQuery($request); 
        return response()->json($query->get())->header("Content-Type", "application/json");
    }

    public function showShipPositionsXML(Request $request) {
        $query = $this->buildQuery($request); 
        return response()->xml(array("data" => $query->get()->toArray()), 200, ["Content-Type", "application/xml"], 'root');
    }

    public function showShipPositionsCSV(Request $request) {
        $query = $this->buildQuery($request); 
        return $this->exportCsv($query->get());
    }
}