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
        Schema::create('transactions_table', function (Blueprint $table) {
            $table->id('id');
            $table->string('reservation_number');
            $table->tinyInteger('transaction_type');
            $table->string('equipment_id');
            $table->tinyInteger('condition_id');
            $table->integer('quantity');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_table');
    }
};
