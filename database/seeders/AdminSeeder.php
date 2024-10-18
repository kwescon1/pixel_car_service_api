<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve the admin password from the .env file
        $adminPassword = env('ADMIN_PASSWORD', 'default_password');
        $adminEmail = env('ADMIN_EMAIL', 'default_email');

        // Create a new admin user, password will be automatically hashed
        User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Pixel Admin',
                'password' => Hash::make($adminPassword),
                'email_verified_at' => Carbon::now(),
                'is_admin' => true,
            ]
        );




        // Create 5 additional regular users using the factory
        User::factory()->count(5)->create();
    }
}
