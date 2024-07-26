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
        Schema::create('flights', function (Blueprint $table) {
            $table->uuid()->primary()->unique();
            $table->integer('external_id')->unique();
            $table->boolean('instant_ticket_required')->default(false);
            $table->boolean('no_homogenous')->default(false);
            $table->boolean('one_way')->default(false);
            $table->date('last_ticketing_date');
            $table->unsignedBigInteger('aircraft_id')->nullable();
            $table->foreign('aircraft_id')->references('id')->on('air_crafts')->nullOnDelete();
            $table->decimal('base_price');
            $table->decimal('total_price');
            $table->string('currency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
