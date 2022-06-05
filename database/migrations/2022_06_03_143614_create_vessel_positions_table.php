<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('vessel_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vessel_id')->comment('Alias: mmsi - Unique VesselPosition identifier');
            $table->unsignedInteger('status')->comment('AIS vessel status');
            $table->unsignedBigInteger('station_id')->comment('Receiving station ID');
            $table->unsignedInteger('speed')->comment('Speed in knots x 10 (i.e. 10,1 knots is 101)');
            $table->float('longitude', 10, 7);
            $table->float('latitude', 10, 7);
            $table->unsignedInteger('course')->comment('VesselPosition\'s course over ground');
            $table->unsignedInteger('heading')->comment('VesselPosition\'s true heading');
            $table->integer('rate_of_turn')->default(null)->nullable()->comment('Alias: rot - VesselPosition\'s rate of turn');
            $table->timestamp('timestamp')->comment('Position timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('vessel_positions');
    }
};
