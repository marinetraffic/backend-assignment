<?php

namespace App\Responders;

use App\Interfaces\ResponseInterface;

class CsvResponder implements ResponseInterface{

    
    public function respond(array $data)
    {

        $callback = function () use ($data) {
            $stream = fopen('php://output', 'w');
            $headers = isset($data[0]) ? array_keys($data[0]) : [];

            fputcsv($stream, $headers);
            foreach ($data as $row) {
                fputcsv($stream, $row);
            }
            fclose($stream);
        };

        
        return response()->stream(
            $callback,
            200,
            [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=vessel_positions.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ]
            );
    }
}