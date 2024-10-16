<?php

namespace Database\Seeders;

use App\Models\CarService;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class CarServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define car services for each service type
        $carServices = [
            'Full Service' => [
                ['name' => 'Oil Change', 'description' => 'Change engine oil', 'price' => 5000],
                ['name' => 'Battery Check', 'description' => 'Check battery health', 'price' => 3000],
            ],
            'Interim Service' => [
                ['name' => 'Tire Rotation', 'description' => 'Rotate tires', 'price' => 2500],
                [
                    'name' => 'Windshield Washer Fluid Refill',
                    'description' => 'Refill windshield washer fluid',
                    'price' => 1500,
                ],
            ],
            'Brake Service' => [
                ['name' => 'Brake Inspection', 'description' => 'Inspect brakes', 'price' => 3000],
                ['name' => 'Brake Pad Replacement', 'description' => 'Replace brake pads', 'price' => 8000],
            ],
        ];

        // Fetch all service types
        $serviceTypes = ServiceType::all();

        // For each service type, create the relevant car services
        $serviceTypes->each(function ($serviceType) use ($carServices) {
            // Check if the service type exists in the car services array
            if (isset($carServices[$serviceType->name])) {
                foreach ($carServices[$serviceType->name] as $service) {
                    // Ensure no duplicate records are created with firstOrCreate
                    CarService::firstOrCreate(
                        [
                            'name' => $service['name'],
                            'service_type_id' => $serviceType->id,
                        ], // Condition to check
                        [
                            'description' => $service['description'],
                            'price' => $service['price'],
                            'service_type_id' => $serviceType->id,
                        ] // Attributes to create if not found
                    );
                }
            }
        });
    }
}
