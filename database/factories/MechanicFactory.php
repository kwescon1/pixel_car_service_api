<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Mechanic>
 */
class MechanicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(), // Generate a UUID
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'years_of_experience' => $this->faker->numberBetween(1, 20), // Experience between 1-20 years
            'specialty' => $this->faker->randomElement(['Engine', 'Brakes', 'Tires', 'Suspension']),
            'avatar' => null,
            'is_active' => true,
        ];
    }
}
