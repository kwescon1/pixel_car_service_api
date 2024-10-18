<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=BookingDate>
 */
class BookingDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 year')->format('Y-m-d'), // Random date between 1 week and 1 year from now
            'is_active' => $this->faker->boolean(80), // 80% chance that the booking date is active
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
