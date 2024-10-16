<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);  // Call the AdminSeeder

        //seed the service types
        $this->call(ServiceTypeSeeder::class);

        //seed the car services
        $this->call(CarServiceSeeder::class);
    }
}
