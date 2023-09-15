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
        Schema::create('trn_extend', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->references('id')->on('trn_reservation');
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
        Schema::dropIfExists('trn_extend');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
