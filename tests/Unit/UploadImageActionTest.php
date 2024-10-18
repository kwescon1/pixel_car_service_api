<?php

use App\Actions\UploadImageAction;
use App\Jobs\ProcessImage;
use App\Models\Mechanic;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    Queue::fake();
});

it('dispatches process image job when image is provided', function () {
    /** @var \Mockery\LegacyMockInterface&\Mockery\MockInterface|Mechanic $mechanic */
    $mechanic = Mockery::mock(Mechanic::class);
    $mechanic->shouldReceive('getAttribute')->with('id')->andReturn(1);

    $image = UploadedFile::fake()->image('avatar.jpg');
    $action = new UploadImageAction();

    // Act
    $action->execute($mechanic, $image);

    // Assert that the image was stored temporarily in the 'mechanics/tmp' folder
    Storage::disk('public')->assertExists('mechanics/tmp/' . $image->hashName());

    // Assert that the ProcessImage job was dispatched with the correct arguments
    Queue::assertPushed(ProcessImage::class, function ($job) use ($image) {
        return $job->getMechanic()->id === 1 &&
            $job->getFilePath() === 'mechanics/tmp/' . $image->hashName() &&
            $job->isUpdate() === false;
    });
});

it('does not dispatch process image job when image is not provided', function () {
    /** @var \Mockery\LegacyMockInterface&\Mockery\MockInterface|Mechanic $mechanic */
    $mechanic = Mockery::mock(Mechanic::class);

    $action = new UploadImageAction();

    // Act
    $action->execute($mechanic, null);

    // Assert that no jobs were pushed to the queue
    Queue::assertNothingPushed();
});

it('dispatches process image job with update flag', function () {
    /** @var \Mockery\LegacyMockInterface&\Mockery\MockInterface|Mechanic $mechanic */
    $mechanic = Mockery::mock(Mechanic::class);
    $mechanic->shouldReceive('getAttribute')->with('id')->andReturn(1);

    $image = UploadedFile::fake()->image('avatar.jpg');
    $action = new UploadImageAction();

    // Act
    $action->execute($mechanic, $image, true);

    // Assert that the ProcessImage job was dispatched with the correct update flag
    Queue::assertPushed(ProcessImage::class, function ($job) use ($mechanic, $image) {
        return $job->getMechanic()->id === 1 &&
            $job->getFilePath() === 'mechanics/tmp/' . $image->hashName() &&
            $job->isUpdate() === true;
    });
});

afterEach(function () {
    Mockery::close(); // Close the mock after each test
});
