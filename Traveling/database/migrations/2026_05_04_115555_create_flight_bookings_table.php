<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->id();

            // ─── Booking Core ─────────────────────────────────────────
            $table->string('booking_id', 12)->unique();         // e.g. BK2025001234
            $table->string('pnr_number', 6)->unique();          // e.g. ABCX12 (shown at airport)
            $table->timestamp('booking_date')->useCurrent();

            $table->enum('booking_status', [
                'Pending',
                'Confirmed',
                'Cancelled',
                'Completed',
            ])->default('Pending');

            $table->enum('trip_type', [
                'One Way',
                'Round Trip',
            ]);

            // ─── Flight Information ───────────────────────────────────
            $table->foreignId('flight_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('flight_number', 8);                 // e.g. 6E-345, AI-202
            $table->string('airline_name', 50);                 // e.g. IndiGo, Air India
            $table->char('origin_airport', 3);                  // IATA code e.g. AMD, BOM
            $table->char('destination_airport', 3);             // IATA code e.g. DEL, DXB
            $table->dateTime('departure_datetime');
            $table->dateTime('arrival_datetime');
            $table->integer('flight_duration');                  // in minutes e.g. 135

            $table->enum('cabin_class', [
                'Economy',
                'Premium Economy',
                'Business',
                'First',
            ])->default('Economy');

            // ─── Passenger Details ────────────────────────────────────
            $table->foreignId('passenger_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('first_name', 50);
            $table->string('last_name', 50);

            $table->enum('gender', [
                'Male',
                'Female',
                'Other',
            ]);

            $table->string('email', 100);
            $table->string('phone_number', 15);                 // e.g. +91-9876543210

            // ─── Check-in / Meta ──────────────────────────────────────
            $table->enum('check_in_status', [
                'Not Done',
                'Checked In',
                'Boarded',
            ])->default('Not Done');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_bookings');
    }
};