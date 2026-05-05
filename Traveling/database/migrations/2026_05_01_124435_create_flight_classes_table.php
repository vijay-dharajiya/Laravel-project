<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flight_classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('flight_id')
                  ->constrained()
                  ->onDelete('cascade');

            // ─── Class Type ───────────────────────────────────────────
            $table->enum('class_type', [
                'Economy',
                'Premium Economy',
                'Business',
                'First'
            ]);

            // ─── Seats ────────────────────────────────────────────────
            $table->integer('total_seats');
            $table->integer('available_seats');
            $table->integer('booked_seats')->default(0);

            // ─── Pricing ──────────────────────────────────────────────
            $table->decimal('base_price', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);        // base_price + tax
            $table->string('currency', 10)->default('INR');

            // ─── Baggage ──────────────────────────────────────────────
            $table->integer('cabin_baggage_kg')->default(7);
            $table->integer('checkin_baggage_kg')->default(15);

            // ─── Refund / Cancellation ────────────────────────────────
            $table->boolean('is_refundable')->default(false);
            $table->decimal('cancellation_charge', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_classes');
    }
};