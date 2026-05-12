<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flight_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('flight_id')
                ->constrained()
                ->onDelete('cascade');

            $table->date('journey_date');

            $table->enum('status', [
                'Scheduled',
                'On Time',
                'Delayed',
                'Cancelled',
                'Boarding',
                'Departed',
                'Landed',
            ])->default('Scheduled');

            $table->unique(['flight_id', 'journey_date']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_schedules');
    }
};
