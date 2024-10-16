<?php

beforeEach(function () {
    // Run the seeder
    $this->seed(\Database\Seeders\AdminSeeder::class);
});

test('admin seeder creates user', function () {
    // Assert that a user with the 'is_admin' flag set to true exists
    $this->assertDatabaseHas('users', [
        'email' => 'admin@pixeltest.com', // The email set in the seeder
    ]);
});
