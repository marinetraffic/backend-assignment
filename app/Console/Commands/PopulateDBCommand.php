<?php

namespace App\Console\Commands;

use App\Models\Track;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class PopulateDBCommand extends Command
{
    protected $signature = 'db:populate';
    protected $description = 'Parses the JSON file and populates the database';

    public function handle()
    {
        DB::table('tracks')->truncate();

        $dataFile = base_path() . '/ship_positions.json';
        if(!file_exists($dataFile)){
            $this->error('Error: data file not found at ' . $dataFile);
            return 1;
        }
        $content = file_get_contents($dataFile);
        $data = json_decode($content, true);


        DB::table('tracks')->insert($data);
        $this->info("inserted " . count($data) . " tracks");

        return 0;
    }
}
