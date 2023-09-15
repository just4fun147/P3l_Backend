<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trn_detail_reservation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->references('id')->on('trn_reservation');
            $table->foreignId('room_id')->references('id')->on('mst_room');
            $table->float('normal_price');
            $table->foreignId('coupon_id')->references('id')->on('mst_coupon')->nullable();
            $table->float('actual_price');
            $table->foreignId('season_id')->references('id')->on('mst_season')->nullable();
            $table->boolean('is_active');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('trn_detail_reservation');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
