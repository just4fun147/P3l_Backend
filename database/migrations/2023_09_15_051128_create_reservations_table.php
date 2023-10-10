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
        Schema::create('trn_reservation', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable()->unique();
            $table->string('id_booking')->unique();
            $table->foreignId('user_id')->references('id')->on('mst_user');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('adult');
            $table->integer('child');
            $table->boolean('is_paid');
            $table->boolean('end_paid')->default(false);
            $table->boolean('is_extend');
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
        Schema::dropIfExists('trn_reservation');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
