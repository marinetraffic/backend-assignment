<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->boolean('status');
            $table->integer('stationId');
            $table->integer('speed');
            $table->float('lon', 8 , 5);
            $table->float('lat',8 , 5);
            $table->integer('course');
            $table->integer('heading');
            $table->string('rot');
            $table->bigInteger('timestamp');
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
};
