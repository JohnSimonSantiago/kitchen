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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservationNumber');
            $table->timestamps();
            $table->string('customerName');
            $table->string('customerNumber');
            $table->tinyInteger('statusID')->default(0);
            $table->date('dateStart');
            $table->date('dateEnd');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
