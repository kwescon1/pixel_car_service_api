<?php

namespace App\Actions;

use App\Jobs\ProcessImage;
use App\Models\Mechanic;
use Illuminate\Http\UploadedFile;

class UploadImageAction
{
    /**
     * Execute the action to handle image upload.
     *
     * @param Mechanic $mechanic
     * @param UploadedFile|null $image
     */
    public function execute(Mechanic $mechanic, ?UploadedFile $image, bool $isUpdate = false): void
    {
        // Dispatch the job to process the image upload
        if ($image) {
            // Store the image temporarily in the 'mechanics' folder
            $filePath = $image->store('mechanics/tmp', 'public');

            ProcessImage::dispatch($mechanic, $filePath, $isUpdate);
        }
    }
}
