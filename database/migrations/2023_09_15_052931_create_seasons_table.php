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
        Schema::create('mst_season', function (Blueprint $table) {
            $table->id();
            $table->string('season_name');
            $table->integer('capacity')->nullable();
            $table->integer('price_type');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('mst_season');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
