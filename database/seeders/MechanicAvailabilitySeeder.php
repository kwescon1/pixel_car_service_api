<?php

namespace Database\Seeders;

use App\Models\Mechanic;
use App\Models\BookingDate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MechanicAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $mechanics = Mechanic::factory()->count(5)->create();


        $bookingDates = BookingDate::factory()->count(10)->create();

        // Iterate over each mechanic and assign them to random booking dates with availability
        foreach ($mechanics as $mechanic) {
            // For each mechanic, attach random booking dates with availability info
            $bookingDates->random(5)->each(function ($bookingDate) use ($mechanic) {
                $start_time = now()->addHours(rand(7, 10))->format('H:i:s'); // Random start time
                $end_time = now()->addHours(rand(11, 17))->format('H:i:s');  // Random end time

                // Attach mechanic to booking date via the pivot table with additional attributes
                $mechanic->bookingDates()->attach($bookingDate->id, [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'is_available' => rand(0, 1) // Random availability
                ]);
            });
        }
    }
}
