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
        //
        Schema::create('studentDetails', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("userId");
            $table->string('name');
            $table->string('course');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
