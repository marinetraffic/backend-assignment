<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * @author Elton
 * Class Tracks
 * Database migration class
 */
class Tracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function($table)
        {
            $table->integer('mmsi')->index()->nullable(false);
            $table->boolean('status')->nullable(false);;
            $table->integer('stationId')->nullable(false);;
            $table->integer('speed')->nullable(false);;
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->integer('course')->nullable(false);
            $table->integer('heading')->nullable(false);
            $table->string('rot')->nullable();;
            $table->integer('timestamp')->index()->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
