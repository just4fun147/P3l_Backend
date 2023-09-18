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
        Schema::create('mst_user', function (Blueprint $table) {
            $table->id('id');
            $table->string('full_name');
            $table->string('identity');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->text('address');
            $table->boolean('is_group');
            $table->foreignId('role_id')->references('id')->on('mst_role');
            $table->string('image')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('mst_user');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
