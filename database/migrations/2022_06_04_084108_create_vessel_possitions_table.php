<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesselPossitionsTable extends Migration
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
            $table->integer('mmsi')->nullable($value = false);
            $table->tinyInteger('ais_status')->default(null);
            $table->integer('station_id')->default(null);
            $table->integer('speed')->default(null);
            $table->timestamp('timestamp', $precision = 0)->nullable($value = false);
            $table->point('position')->nullable($value = false);
            $table->integer('course')->default(null);
            $table->integer('heading')->default(null);
            $table->string('rot')->default(null);
            $table->spatialIndex('position');	
            $table->index('mmsi');	
            $table->index('timestamp');	


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
