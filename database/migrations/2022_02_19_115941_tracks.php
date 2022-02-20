<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->double('log')->nullable();
            $table->integer('course')->nullable(false);
            $table->integer('heading')->nullable(false);
            $table->string('rot')->nullable();;
            $table->timestamp('timestamp')->index()->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
