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
        Schema::create('trn_add_on', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->references('id')->on('trn_reservation');
            $table->foreignId('add_on_id')->references('id')->on('mst_add_on');
            $table->boolean('is_charge');
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
        Schema::dropIfExists('trn_add_on');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
