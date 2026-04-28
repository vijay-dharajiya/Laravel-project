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
            $table->id();

            // Airline Info
            $table->string('airline_name');
            $table->string('flight_name')->nullable();
            $table->string('flight_no')->unique();

            // Image / Logo
            $table->string('image')->nullable();

            // Route
            $table->string('from_city');
            $table->string('to_city');

            // Timing
            $table->time('departure_time');
            $table->time('arrival_time');

            // Stops (IMPORTANT)
            $table->string('stops')->default('Non-stop');

            // Price
            $table->decimal('price', 10, 2);

            // Optional (PRO FEATURES 🔥)
            /*$table->string('class_type')->default('Economy'); // Economy, Business
            $table->integer('available_seats')->default(50);
            $table->string('status')->default('On Time'); // On Time, Delayed*/

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
