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
        Schema::create('mst_room_type', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->uuid('uuid');
            $table->double('price',20,0);
            $table->boolean('is_smoking');
            $table->boolean('is_double');
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
        Schema::dropIfExists('mst_room_type');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
