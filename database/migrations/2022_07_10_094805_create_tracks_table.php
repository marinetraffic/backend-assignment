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
        Schema::create('tracks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('mmsi');
            $table->integer('status');
            $table->unsignedBigInteger('stationId');
            $table->integer('speed');
            $table->float('lon');
            $table->float('lat');
            $table->integer('course');
            $table->integer('heading');
            $table->string("rot")->default("");
            $table->unsignedInteger("timestamp");
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
};
