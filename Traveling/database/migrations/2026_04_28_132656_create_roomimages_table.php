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
        Schema::create('roomimages', function (Blueprint $table) {
            $table->id();
            // 🔗 Link to hotel (for easy retrieval of all images for a hotel)
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade'); // 🔗 Link to hotel
            // 🔗 Link to room
            $table->foreignId('room_id')->constrained()->onDelete('cascade');

            // 🖼️ Image file
            $table->string('image');

            // ⭐ Main image (first slide / fallback)
            $table->boolean('is_primary')->default(0);

            // 🔢 Order for slider (VERY IMPORTANT)
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roomimages');
    }
};
