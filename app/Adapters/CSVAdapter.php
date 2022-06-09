<?php

namespace App\Adapters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Str;

class CSVAdapter implements Adapter
{


    public function get_response(Builder $query)
    {
        $file_name = Str::random();
        $file_name = "{$file_name}.csv";
        $writer = SimpleExcelWriter::create($file_name);
        $query->chunk(100, function ($data) use ($writer) {
            foreach ($data as $item) {
                $item->lat = $item->position->getLat();
                $item->lon = $item->position->getLng();
                unset($item->position);
                $writer->addRow($item->toArray());
            }
        });
        $headers = [
            'Content-Description' => 'File Transfer',
            'Content-Type' => 'text/csv',
        ];
        $writer->close();
        return response()->download($file_name, "data.csv", $headers)->deleteFileAfterSend();
    }
}
