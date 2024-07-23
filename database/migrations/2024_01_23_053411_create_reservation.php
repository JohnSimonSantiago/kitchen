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
            $table->string('user_id');
            $table->string('customerName');
            $table->string('customerNumber');
            $table->string('email');
            $table->tinyInteger('statusID')->default(0);
            $table->string('remarks')->nullable();
            $table->date('dateStart');
            $table->date('dateEnd');
            $table->timestamps();

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
