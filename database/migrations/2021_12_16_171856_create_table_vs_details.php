<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vs_details', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('mmsi');
            $table->smallInteger('status');
            $table->integer('stationId');
            $table->integer('speed');
            $table->float('lon',10,6);
            $table->float('lat',10,6);
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
        Schema::dropIfExists('vs_details');
    }
}
