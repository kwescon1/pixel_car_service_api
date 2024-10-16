<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot function to automatically generate UUIDs for a custom column (`uuid`).
     */
    protected static function bootHasUuids(): void
    {
        static::creating(function ($model) {
            // Check if the UUID column (`uuid`) is empty and generate a new UUID
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid(); // Generate UUID for the `uuid` column
            }
        });
    }
}
