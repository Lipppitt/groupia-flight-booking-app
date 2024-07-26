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
        Schema::create('flight_segments', function (Blueprint $table) {
            $table->uuid()->primary()->unique();
            $table->integer('external_id')->unique();
            $table->uuid('flight_id')->nullable();

            $table->uuid('arrival_location_id')->nullable();
            $table->uuid('departure_location_id')->nullable();
            $table->uuid('carrier_id')->nullable();
            $table->uuid('aircraft_id')->nullable();

            $table->foreign('flight_id')->references('uuid')->on('flights')->onDelete('cascade');
            $table->dateTimeTz('departure_time');
            $table->dateTimeTz('arrival_time');
            $table->foreign('arrival_location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('departure_location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->string('duration');
            $table->integer('number_of_stops');
            $table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('cascade');
            $table->foreign('aircraft_id')->references('id')->on('air_crafts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_segments');
    }
};
