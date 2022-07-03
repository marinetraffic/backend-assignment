<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_positions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mmsi');
            $table->boolean('status')->default(false);
            $table->integer('station_id');
            $table->integer('speed');
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);
            $table->integer('course');
            $table->integer('heading');
            $table->string('rot')->nullable();
            $table->bigInteger('timestamp');

            $table->timestamps();
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
