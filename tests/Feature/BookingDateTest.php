<?php

use App\Models\User;
use App\Models\BookingDate;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create(['is_admin' => false]);
    $this->admin = User::factory()->create(['is_admin' => true]);
});

test('unauthorized error is thrown when user is unauthenticated', function () {
    $response = $this->getJson(route('available-dates.index'));

    $response->assertUnauthorized();
});

test('forbidden error is thrown when non-admin user tries to create a booking date', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson(route('available-dates.store'), [
        'date' => now()->addWeek()->format('Y-m-d'),
        'is_active' => true,
    ]);

    $response->assertForbidden();
});

test('can list available booking dates', function () {
    Sanctum::actingAs($this->admin);

    BookingDate::factory()->count(3)->create();

    $response = $this->getJson(route('available-dates.index'));

    $response->assertOk();

    $this->assertCount(3, $response->json('data.dates'));
});

test('admin can create a new booking date', function () {
    Sanctum::actingAs($this->admin);


    $data = [
        'date' => now()->addWeek(2)->format('Y-m-d'),
        'is_active' => true,
    ];

    $response = $this->postJson(route('available-dates.store'), $data);

    $response->assertCreated();

    $this->assertDatabaseHas('booking_dates', [
        'date' => $data['date'],
        'is_active' => true,
    ]);
});

test('admin can view a single booking date', function () {

    Sanctum::actingAs($this->admin);

    $bookingDate = BookingDate::factory()->create();


    $response = $this->getJson(route('available-dates.show', $bookingDate->uuid));

    $response->assertOk();

    $response->assertJson([
        'data' => [
            'id' => $bookingDate->uuid,
            'available_date' => $bookingDate->date,
            'is_active' => $bookingDate->is_active,
        ]
    ]);
});

test('admin can update a booking date', function () {

    Sanctum::actingAs($this->admin);

    $bookingDate = BookingDate::factory()->create();

    $updatedData = [
        'date' => now()->addWeeks(2)->format('Y-m-d'),
        'is_active' => false,
    ];

    $response = $this->putJson(route('available-dates.update', $bookingDate->uuid), $updatedData);

    $response->assertOk();

    $this->assertDatabaseHas('booking_dates', [
        'id' => $bookingDate->id,
        'date' => $updatedData['date'],
        'is_active' => false,
    ]);
});

test('admin can delete a booking date (soft delete)', function () {

    Sanctum::actingAs($this->admin);

    $bookingDate = BookingDate::factory()->create();

    $response = $this->deleteJson(route('available-dates.destroy', $bookingDate->uuid));

    $response->assertNoContent();


    $this->assertSoftDeleted('booking_dates', [
        'id' => $bookingDate->id,
    ]);
});

test('soft deleted booking date cannot be accessed', function () {

    Sanctum::actingAs($this->admin);

    $bookingDate = BookingDate::factory()->create();
    $bookingDate->delete();

    $response = $this->getJson(route('available-dates.show', $bookingDate->uuid));

    $response->assertNotFound();
});
