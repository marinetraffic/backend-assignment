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
        Schema::create('trackers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mmsi');
            $table->boolean('status');
            $table->integer('station');
            $table->integer('speed');
            $table->double('lon', 17, 15);
            $table->double('lat', 17, 15);
            $table->integer('course');
            $table->integer('heading');
            $table->string('rot', 30);
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trackers');
    }
};
