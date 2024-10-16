<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the service types to be seeded
        $serviceTypes = [
            ['name' => 'Full Service', 'description' => 'Comprehensive vehicle check'],
            ['name' => 'Interim Service', 'description' => 'Basic vehicle check'],
            ['name' => 'Brake Service', 'description' => 'Brake system inspection'],
        ];

        // Use firstOrCreate to avoid duplicating service types
        foreach ($serviceTypes as $type) {
            ServiceType::firstOrCreate(
                ['name' => $type['name']], // Condition to check for existing record
                ['description' => $type['description']] // Attributes to set if the record doesn't exist
            );
        }
    }
}
