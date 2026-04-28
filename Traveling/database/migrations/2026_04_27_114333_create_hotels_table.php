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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();

            // Location
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Contact Info
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Hotel Details
            $table->integer('star_rating')->nullable(); // 1 to 5
            $table->decimal('price_per_night', 10, 2);
            $table->integer('total_rooms')->default(0);

            // Features
            $table->boolean('wifi')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('pool')->default(false);
            $table->boolean('gym')->default(false);
            $table->boolean('restaurant')->default(false);
            $table->boolean('ac')->default(true);

            // Media
            $table->string('thumbnail')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
