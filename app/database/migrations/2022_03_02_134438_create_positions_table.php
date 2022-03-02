<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up() {
        Schema::create('positions', function (Blueprint $table) {
            $table->integer('mmsi');
            $table->boolean('status');
            $table->integer('stationid');
            $table->integer('speed');
            $table->double('lon', 17, 15);
            $table->double('lat', 17, 15);
            $table->integer('course');
            $table->integer('heading');
            $table->string('rot', 30);
            $table->integer('timestamp');
        });
    }

    public function down() {
        Schema::dropIfExists('positions');
    }
};