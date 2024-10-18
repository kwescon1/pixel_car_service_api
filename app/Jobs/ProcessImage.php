<?php

namespace App\Jobs;

use App\Models\Mechanic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mechanic;
    protected $filePath;
    protected $isUpdate;

    /**
     * Create a new job instance.
     *
     * @param Mechanic $mechanic
     * @param string $filePath
     * @param bool $isUpdate
     */
    public function __construct(?Mechanic $mechanic, string $filePath, bool $isUpdate = false)
    {
        $this->mechanic = $mechanic;
        $this->filePath = $filePath;
        $this->isUpdate = $isUpdate; // Flag to indicate if this is an update
    }

    /**
     * Getter for mechanic.
     *
     * @return Mechanic
     */
    public function getMechanic(): Mechanic
    {
        return $this->mechanic;
    }

    /**
     * Getter for filePath.
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Getter for isUpdate.
     *
     * @return bool
     */
    public function isUpdate(): bool
    {
        return $this->isUpdate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // If it's an update and the mechanic already has an avatar, delete the old image
        if ($this->isUpdate() && $this->mechanic->avatar) {
            Storage::disk('public')->delete($this->mechanic->avatar);
        }

        // Access the file from the storage
        $absoluteFilePath = Storage::disk('public')->path($this->filePath);

        // Optimize the image in place
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize($absoluteFilePath);

        // Define the permanent location (e.g., 'mechanics' folder)
        $finalPath = str_replace('tmp/', '', $this->getFilePath());

        // Move the optimized image to the permanent location
        Storage::disk('public')->move($this->getFilePath(), $finalPath);

        // Update the mechanic's avatar field with the new file's URL
        $this->mechanic->update([
            'avatar' => Storage::url($finalPath),
        ]);
    }
}
