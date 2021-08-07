<?php

namespace App\Console\Commands;

use App\Models\VesselTrack;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use JsonException;

class ImportVesselsTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vessels_tracks:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import vessels tracks from raw json file.';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws FileNotFoundException
     * @throws JsonException
     */
    public function handle(): int
    {
        // Verbose
        $this->info('Loading raw data...');

        // Load data and decode
        $json = Storage::disk('root')->get('ship_positions.json');
        $tracks = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        // Verbose
        $this->info('Standardizing input...');

        // Standardize keys and values
        foreach ($tracks as $k => $entry) {
            // stationId to station_id
            $tracks[$k]['station_id'] = $entry['stationId'];
            unset($tracks[$k]['stationId']);

            // Empty rot to null
            $tracks[$k]['rot'] = $entry['rot'] === '' ? null : $entry['rot'];

            // Multiple knots to 10
            $tracks[$k]['speed'] = $entry['speed'] * 10;
        }

        // Verbose
        $this->info('Inserting to database...');

        // Batch insert
        VesselTrack::insert($tracks);

        // Verbose
        $this->info('Successfully imported data!');

        return 0;
    }
}
