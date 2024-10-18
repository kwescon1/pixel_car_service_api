<?php

use App\Models\User;
use App\Models\CarService;
use App\Models\ServiceType;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    // Create a regular user (non-admin)
    $this->user = User::factory()->create(['is_admin' => false]);

    // Create an admin user
    $this->admin = User::factory()->create(['is_admin' => true]);

    $this->serviceType = ServiceType::factory()->create([
        'name' => 'Brake Service',
        'description' => 'Brake system inspection',
    ]);

    $this->carService = CarService::factory()->create([
        'name' => 'Brake Pad Replacement',
        'description' => 'Replace brake pads',
        'price' => 8000,
        'service_type_id' => $this->serviceType->id,
    ]);
});

test('unauthorized error is thrown when user is unauthenticated', function () {

    $response = $this->getJson(route('car-services.index'));

    $response->assertUnauthorized();
});

test('forbidden error is thrown when non-admin user tries to create a car service', function () {

    Sanctum::actingAs($this->user);

    $response = $this->postJson(route('car-services.store'), [
        'name' => 'Oil Change',
        'description' => 'Engine oil change',
        'price' => 5000,
        'service_type_id' => $this->serviceType->id,
    ]);
    $response->assertForbidden();
});

test('admin can create a car service', function () {
    Sanctum::actingAs($this->admin);

    $carServiceData = [
        'name' => 'Oil Change',
        'description' => 'Engine oil change',
        'price' => 5000,
        'service_type_id' => $this->serviceType->id,
    ];

    $response = $this->postJson(route('car-services.store'), $carServiceData);

    $response->assertCreated();

    $this->assertDatabaseHas('car_services', [
        'name' => 'Oil Change',
        'description' => 'Engine oil change',
        'price' => 5000 * 100,  // Stored as pence in the database
    ]);
});

test('admin can update a car service', function () {
    // Authenticate as an admin user
    Sanctum::actingAs($this->admin);

    // Data for updating the car service
    $updatedData = [
        'name' => 'Updated Service',
        'description' => 'Updated description',
        'price' => 10000,
        'service_type_id' => $this->serviceType->uuid,
    ];

    // Call the route to update the car service
    $response = $this->putJson(route('car-services.update', $this->carService->uuid), $updatedData);

    $response->assertOk();


    $this->assertDatabaseHas('car_services', [
        'id' => $this->carService->id,
        'name' => 'Updated Service',
        'price' => 10000 * 100,  // Stored as pence
    ]);
});

test('admin can delete a car service (soft delete)', function () {
    Sanctum::actingAs($this->admin);

    $response = $this->deleteJson(route('car-services.destroy', $this->carService->uuid));

    $response->assertNoContent();

    $this->assertSoftDeleted('car_services', [
        'id' => $this->carService->id,
    ]);
});

test('soft deleted car service cannot be accessed', function () {

    $this->carService->delete();

    Sanctum::actingAs($this->admin);

    $response = $this->getJson(route('car-services.show', $this->carService->uuid));

    $response->assertNotFound();
});
