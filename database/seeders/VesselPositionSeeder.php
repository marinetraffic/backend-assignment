<?php

namespace Database\Seeders;

use App\Models\VesselPosition;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VesselPositionSeeder extends Seeder
{
    protected string $ship_position_file;
    protected int $chunk_size;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        VesselPosition::truncate();

        $this->ship_position_file = file_get_contents(sprintf('%s/%s', __DIR__, 'ship_positions.json'));
        $this->chunk_size = 50;

        $vessel_positions = json_decode($this->ship_position_file, true);

        foreach (collect($vessel_positions)->chunk($this->chunk_size) as $vessel_positions_chunk) {

            foreach ($vessel_positions_chunk as $inner_chunk) {
                $vp = new VesselPosition();
                $vp->vessel_id = $inner_chunk['mmsi'];
                $vp->status = $inner_chunk['status'];
                $vp->station_id = $inner_chunk['stationId'];
                $vp->speed = $inner_chunk['speed'];
                $vp->longitude = $inner_chunk['lon'];
                $vp->latitude = $inner_chunk['lat'];
                $vp->course = $inner_chunk['course'];
                $vp->heading = $inner_chunk['heading'];
                $vp->rate_of_turn = $inner_chunk['rot'] === '' ? null : $inner_chunk['rot'];
                $vp->timestamp = Carbon::createFromTimestamp($inner_chunk['timestamp']);
                $vp->save();
            }
        }
    }
}
