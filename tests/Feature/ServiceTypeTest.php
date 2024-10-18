<?php

use App\Models\User;
use App\Models\ServiceType;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create(['is_admin' => false]); // Regular user (non-admin)
    $this->admin = User::factory()->create(['is_admin' => true]); // Admin user
    $this->serviceType = ServiceType::factory()->create(); // Create a service type for CRUD operations

    $this->protectedRoute = function () {
        return $this->getJson(route('service-types.index'));
    };
});

test('unauthorized error is thrown when user is unauthenticated', function () {

    $response = ($this->protectedRoute)();

    $response->assertUnauthorized();
});

test('forbidden error is thrown when non-admin user tries to access the route', function () {

    Sanctum::actingAs($this->user);

    $response = ($this->protectedRoute)();

    $response->assertForbidden();
});

test('route can be accessed by an admin', function () {

    // Authenticate as an admin user
    Sanctum::actingAs($this->admin);

    // Call the protected route and get the response
    $response = ($this->protectedRoute)();

    // Assert that the request was successful
    $response->assertOk();
});

### Test for CRUD Operations on Service Types

test('admin can create a service type', function () {

    // Authenticate as an admin user
    Sanctum::actingAs($this->admin);


    $serviceTypeData = [
        'name' => 'Full Service',
        'description' => 'Complete car service',
    ];

    $response = $this->postJson(route('service-types.store'), $serviceTypeData);

    $response->assertCreated();

    $this->assertDatabaseHas('service_types', [
        'name' => 'Full Service',
    ]);
});

test('admin can update a service type', function () {

    Sanctum::actingAs($this->admin);

    $updatedData = [
        'name' => 'Updated Service',
        'description' => 'Updated description',
    ];

    $response = $this->putJson(route('service-types.update', $this->serviceType->uuid), $updatedData);


    $response->assertOk();


    $this->assertDatabaseHas('service_types', [
        'id' => $this->serviceType->id,
        'name' => 'Updated Service',
    ]);
});

test('admin can delete a service type', function () {

    Sanctum::actingAs($this->admin);

    $response = $this->deleteJson(route('service-types.destroy', $this->serviceType->uuid));

    $response->assertNoContent();

    $this->assertSoftDeleted('service_types', [
        'id' => $this->serviceType->id,
    ]);
});
