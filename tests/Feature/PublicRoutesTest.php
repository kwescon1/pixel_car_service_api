<?php

use App\Models\ServiceType;
use App\Models\CarService;
use App\Models\BookingDate;
use App\Models\Mechanic;
use Illuminate\Foundation\Testing\RefreshDatabase;

test('service types can be retrieved by unauthenticated users', function () {
    // Create some service types
    ServiceType::factory()->count(3)->create();

    $response = $this->getJson(route('public.service-types.index'));

    // Assert that the response is successful
    $response->assertOk();

    $response->assertJsonStructure([
        'data' => [
            'types' => [
                '*' => [
                    'id',
                    'name',
                    'description'
                ]
            ]

        ]
    ]);
});

test('car services can be filtered by service type', function () {
    $serviceType = ServiceType::factory()->create();
    CarService::factory()->count(3)->create(['service_type_id' => $serviceType->id]);


    $response = $this->getJson(route('public.car-services', ['type' => $serviceType->uuid]));

    $response->assertOk();

    $response->assertJsonStructure([
        'data' => [
            'car_services' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                ]
            ]

        ]
    ]);
});

test('booking dates can be retrieved by unauthenticated users', function () {
    // Create some booking dates
    BookingDate::factory()->count(5)->create();

    $response = $this->getJson(route('public.available-dates'));


    $response->assertOk();

    $response->assertJsonStructure([
        'data' => [
            'dates' => [
                '*' => [
                    'id',
                    'available_date',
                    'is_active'
                ]
            ]
        ]
    ]);
});

test('mechanics can be retrieved for a specific date', function () {
    $bookingDate = BookingDate::factory()->create();
    $mechanic = Mechanic::factory()->create();

    // Attach the mechanic to the booking date with availability
    $bookingDate->mechanics()->attach($mechanic->id, [
        'start_time' => '08:00:00',
        'end_time' => '17:00:00',
        'is_available' => true,
    ]);

    $response = $this->getJson(route('public.mechanics', ['date' => $bookingDate->date]));


    $response->assertOk();

    // Assert that the response has the correct structure
    $response->assertJsonStructure([
        'data' => [
            'mechanics' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone_number',
                    'years_of_experience',
                    'specialty',
                    'avatar',
                    'is_active'
                ]
            ]
        ]
    ]);
});
