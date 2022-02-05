<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_positions', function (Blueprint $table) {
            $table->bigInteger('mmsi')->unsigned();
            $table->integer('status');
            $table->integer('station_id');
            $table->integer('speed');
            $table->float('lon');
            $table->float('lat');
            $table->integer('course');
            $table->integer('heading');
            $table->string('rot')->nullable();
            $table->integer('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ship_positions');
    }
}
