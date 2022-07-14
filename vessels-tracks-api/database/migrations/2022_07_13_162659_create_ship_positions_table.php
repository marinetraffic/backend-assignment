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
            $table->timestamps();
            $table->integer('mmsi');
            $table->integer('status');
            $table->integer('stationId');
            $table->integer('speed');
            $table->double('lon');
            $table->double('lat');
            $table->integer('course');
            $table->integer('heading');
            $table->string('rot');
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
};
