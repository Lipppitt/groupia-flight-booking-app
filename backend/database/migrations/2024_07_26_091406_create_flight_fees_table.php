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
        Schema::create('flight_fees', function (Blueprint $table) {
            $table->id();
            $table->uuid('flight_id')->nullable();
            $table->foreign('flight_id')->references('uuid')->on('flights')->onDelete('cascade');
            $table->decimal('amount');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_fees');
    }
};
