<?php

use App\Models\User;
use App\Models\Mechanic;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use App\Notifications\WelcomeMechanicNotification;
use App\Jobs\ProcessImage;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    // Create a non-admin user
    $this->user = User::factory()->create(['is_admin' => false]);

    // Create an admin user
    $this->admin = User::factory()->create(['is_admin' => true]);

    // Disable actual notifications and queues for testing
    Notification::fake();
    Queue::fake();
});

test('unauthorized error is thrown when user is unauthenticated', function () {
    $response = $this->getJson(route('mechanics.index'));

    $response->assertUnauthorized();
});

test('forbidden error is thrown when non-admin user tries to create a mechanic', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson(route('mechanics.store'), [
        'name' => 'Kwesi Odame',
        'email' => 'kwesi@example.com',
        'phone_number' => '0243938336',
        'years_of_experience' => 10,
    ]);

    $response->assertForbidden();
});

test('admin can create a new mechanic with welcome notification ', function () {
    // Authenticate as admin
    Sanctum::actingAs($this->admin);

    // Mechanic data with an avatar
    $mechanicData = [
        'name' => 'Kwesi Odame',
        'email' => 'kwesi@example.com',
        'phone_number' => '0243938336',
        'years_of_experience' => 10,
    ];

    $response = $this->postJson(route('mechanics.store'), $mechanicData);



    $response->assertCreated();

    // Assert that the mechanic is saved in the database
    $this->assertDatabaseHas('mechanics', [
        'name' => 'Kwesi Odame',
        'email' => 'kwesi@example.com',
        'years_of_experience' => 10,
    ]);

    // Assert that the welcome notification was sent to the mechanic
    $mechanic = Mechanic::latest()->first();  // Retrieve the last created mechanic
    Notification::assertSentTo(
        [$mechanic],
        WelcomeMechanicNotification::class
    );
});

test('admin can create a new mechanic without avatar and only sends welcome notification', function () {
    // Authenticate as admin
    Sanctum::actingAs($this->admin);

    // Mechanic data without an avatar
    $mechanicData = [
        'name' => 'Kwesi Odame',
        'email' => 'kwesi@example.com',
        'phone_number' => '0243938336',
        'years_of_experience' => 10,
    ];

    $response = $this->postJson(route('mechanics.store'), $mechanicData);

    $response->assertCreated();

    $this->assertDatabaseHas('mechanics', [
        'name' => 'Kwesi Odame',
        'email' => 'kwesi@example.com',
        'years_of_experience' => 10,
    ]);

    $mechanic = Mechanic::latest()->first();

    Notification::assertSentTo(
        [$mechanic],
        WelcomeMechanicNotification::class
    );


    Queue::assertNotPushed(ProcessImage::class);
});

test('admin can update mechanic', function () {

    // Authenticate as admin
    Sanctum::actingAs($this->admin);

    $mechanic = Mechanic::factory()->create();

    // Mechanic update data
    $updatedData = [
        'name' => 'Kwesi Updated',
        'email' => 'kwesi.updated@example.com',
        'phone_number' => '0243938337',
        'years_of_experience' => 12,
    ];


    $response = $this->putJson(route('mechanics.update', $mechanic->uuid), $updatedData);

    $response->assertOk();

    $this->assertDatabaseHas('mechanics', [
        'name' => 'Kwesi Updated',
        'email' => 'kwesi.updated@example.com',
        'phone_number' => '0243938337',
        'years_of_experience' => 12,
    ]);
});

test('admin can delete a mechanic (soft delete)', function () {
    Sanctum::actingAs($this->admin);

    $mechanic = Mechanic::factory()->create();

    $response = $this->deleteJson(route('mechanics.destroy', $mechanic->uuid));

    $response->assertNoContent();

    $this->assertSoftDeleted('mechanics', [
        'id' => $mechanic->id,
    ]);
});

test('soft deleted mechanic cannot be accessed', function () {
    Sanctum::actingAs($this->admin);

    $mechanic = Mechanic::factory()->create();
    $mechanic->delete();

    $response = $this->getJson(route('mechanics.show', $mechanic->uuid));

    $response->assertNotFound();
});
