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

            // ── Trip meta ──────────────────────────────────────────────
            $table->string('booking_reference')->unique(); // e.g. BK-2026-XXXXXX
            $table->enum('trip_type', ['one-way', 'round'])->default('one-way');
            $table->string('class');
            $table->date('depart_date');
            $table->date('return_date')->nullable();
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            // ── Outbound flight ────────────────────────────────────────
            $table->unsignedBigInteger('depart_flight_id');
            $table->unsignedBigInteger('depart_class_id');

            // ── Return flight (nullable for one-way) ───────────────────
            $table->unsignedBigInteger('return_flight_id')->nullable();
            $table->unsignedBigInteger('return_class_id')->nullable();

            // ── Primary contact ────────────────────────────────────────
            $table->string('contact_email');
            $table->string('contact_phone');

            // ── Passengers JSON ────────────────────────────────────────
            // Stores array of passengers: [{type, first_name, last_name, gender, dob?}]
            $table->json('passengers');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_bookings');
    }
};