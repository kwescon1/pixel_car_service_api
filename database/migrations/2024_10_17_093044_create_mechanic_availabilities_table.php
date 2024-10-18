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
        Schema::create('mechanic_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mechanic_id')->constrained('mechanics'); // References the mechanic
            $table->foreignId('booking_date_id')->constrained('booking_dates'); // References the booking date
            $table->time('start_time')->index(); // Start time of the mechanic's availability
            $table->time('end_time')->index(); // End time of the mechanic's availability
            $table->boolean('is_available')->default(true)->index(); // Mechanic's availability status for the day
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanic_availabilities');
    }
};
