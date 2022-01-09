<?php

namespace App\Console\Commands;

use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportJsonToDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:file
                            {filepath? : The absolut path of the json file}
                            {--truncate : Whether the existing data should be truncated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from JSON file to Postgres Database';

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
        try {
            $filepath = '';

            if($this->argument('filepath')) {
                $filepath = $this->argument('filepath');
            } else {
                $filepath = "../ship_positions.json";
            }

            $truncate = $this->option('truncate');

            if ($truncate) {
                $this->call('migrate:fresh');
            }

            $jsonString = File::get($filepath);

            $positions = json_decode($jsonString);

            $this->line('Started import...');
            $bar = $this->output->createProgressBar(count($positions));

            foreach ($positions as $position) {
                Position::create([
                    "mmsi" => $position->mmsi,
                    "status" => $position->status,
                    "station" => $position->stationId,
                    "speed" => $position->speed,
                    "lon" => $position->lon,
                    "lat" => $position->lat,
                    "course" => $position->course,
                    "heading" => $position->heading,
                    "rot" => $position->rot,
                    "timestamp" => Carbon::parse($position->timestamp)->toISOString()
                ]);

                $bar->advance();
            }

            $bar->finish();
            $this->info('Import was successful!');

        } catch (\Exception $e) {
            $this->error('Error with importing');
            $this->error( $e->getMessage());
        }

        return 0;
    }
}
