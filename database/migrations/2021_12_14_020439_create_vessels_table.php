<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessels', function (Blueprint $table) {
            $table->id();

            $table->integer("mmsi");
            $table->smallInteger("status");
            $table->integer("stationId");
            $table->integer("speed");
            $table->float('lon', 8, 5);
            $table->float('lat', 8, 5);
            $table->integer("course");
            $table->integer("heading");
            $table->integer("rot");
            $table->integer("timestamp");

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
        Schema::dropIfExists('vessels');
    }
}
