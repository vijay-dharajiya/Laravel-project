<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();

            // ─── Airline Info ────────────────────────────────────────
            $table->string('airline_name');
            $table->string('airline_code', 10);           // e.g. "AI", "6E", "SG"
            $table->string('flight_number', 20)->unique(); // e.g. "AI-202"
            $table->string('aircraft_type')->nullable();   // e.g. "Boeing 737"
            $table->string('airline_logo')->nullable();    // image path

            // ─── Route ───────────────────────────────────────────────
            $table->string('from_city');
            $table->string('from_airport');                // full airport name
            $table->string('from_airport_code', 10);      // IATA e.g. "AMD"
            $table->string('to_city');
            $table->string('to_airport');
            $table->string('to_airport_code', 10);

            // ─── Schedule (fixed timings, no date here) ───────────────
            $table->time('departure_time');
            $table->string('departure_timezone', 50)->default('UTC'); // e.g. "Asia/Kolkata"
            $table->time('arrival_time');
            $table->string('arrival_timezone', 50)->default('UTC'); // e.g. "Asia/Kolkata"
            $table->time('duration')->nullable();
            // duration is NOT stored — calculated via Laravel accessor
            $table->tinyInteger('overnight_arrival')->default(0); // +1 day flag

            // ─── Stops ───────────────────────────────────────────────
            $table->tinyInteger('stops')->default(0);      // 0=nonstop, 1, 2...
            $table->json('stopover_cities')->nullable();   // ["Delhi","Dubai"]

            // ─── Admin Control ────────────────────────────────────────
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
