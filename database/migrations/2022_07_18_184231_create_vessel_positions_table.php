<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesselPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessel_positions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mmsi');
            $table->integer('status')->default(0);
            $table->bigInteger("stationId");
            $table->integer('speed');
            $table->decimal('lon', 11, 8);
            $table->decimal('lat', 11, 8);
            $table->integer('course')->nullable();
            $table->integer('heading')->nullable();
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
        Schema::dropIfExists('vessel_positions');
    }
}
