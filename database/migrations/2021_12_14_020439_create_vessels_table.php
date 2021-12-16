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
            $table->double('lon');
            $table->double('lat');
            $table->integer("course");
            $table->integer("heading");
            $table->string("rot"); //string, due to Illuminate\Database\QueryException  SQLSTATE[HY000]: General error: 1366 Incorrect integer value: '' for column 'rot' at row 1 
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
