<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
                'password' => $adminPassword,
                'email_verified_at' => Carbon::now(),
                'is_admin' => true,
            ]
        );
    }
}
