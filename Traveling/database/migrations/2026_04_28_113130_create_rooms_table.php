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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            // Relation with hotel
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');

            // Room details
            $table->string('room_type'); // Deluxe, Suite, Standard
            $table->integer('capacity'); // number of guests

            // Pricing
            $table->decimal('price', 10, 2);

            // Inventory
            $table->integer('total_rooms'); // total rooms available

            // Optional fields (recommended)
            $table->text('description')->nullable();
            $table->boolean('status')->default(1); // 1 = active, 0 = inactive

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
