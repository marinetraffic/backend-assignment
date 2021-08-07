<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesselTracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessel_tracks', function (Blueprint $table) {
            $table->id();
            $table->integer('mmsi');
            $table->smallInteger('status');
            $table->integer('station_id');
            $table->integer('speed');
            $table->decimal('lon', 9, 6);
            $table->decimal('lat', 8, 6);
            $table->integer('course');
            $table->integer('heading');
            $table->integer('rot')->nullable();
            $table->integer('timestamp');

            $table->timestamp('created_at',)->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vessel_tracks');
    }
}
