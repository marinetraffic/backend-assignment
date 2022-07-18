<?php

namespace App\Console\Commands;

use App\Exceptions\NoFileExistsException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate database with initial data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $db_file = base_path("ship_positions.json");

        if (!file_exists($db_file)){
            throw new NoFileExistsException("The database file '{$db_file}' does not exist", 1);            
        }

        DB::table('vessel_positions')->truncate();
        $data = json_decode(file_get_contents($db_file), true);

        $this->info("Attempting to create records");

        $dataCollection = collect($data);

        foreach ($dataCollection->chunk(80) as $chunk) {
            //use chunking because of DBs like SQLITE
            DB::table("vessel_positions")->insert($chunk->all());
        }
        // $this->info("Records count " . count($data));
        // DB::table("vessel_positions")->insert($data);
        $this->info("Records created successfully");
        return 0;
    }
}
