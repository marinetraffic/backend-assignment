<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('log_incoming_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->text('url');
            $table->text('payload');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down() {
        Schema::dropIfExists('log_incoming_requests');
    }
};
