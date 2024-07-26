<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cash_logs', function (Blueprint $table) {
            $table->id('id');
            $table->string('reservation_number');
            $table->string('equipment_id');
            $table->integer('quantity');
            $table->integer('cashAmount');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_logs');
    }
};
