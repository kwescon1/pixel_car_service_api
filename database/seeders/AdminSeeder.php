<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
        // Create a new admin user
        User::create([
            'name' => 'Pixel Admin',
            'email' => 'admin@pixeltest.com',
            'password' => Hash::make($adminPassword), // Secure password
            'email_verified_at' => Carbon::now(), // Secure password
        ]);
    }
}
