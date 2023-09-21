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
        Schema::create('mst_season_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->references('id')->on('mst_season');
            $table->foreignId('room_type_id')->references('id')->on('mst_room_type');
            $table->double('price',20,0);
            $table->boolean('is_active');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('mst_season_detail');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
