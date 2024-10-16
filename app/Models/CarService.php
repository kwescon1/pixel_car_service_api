<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarService extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the service type this car service belongs to.
     */
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    /**
     * Get and set service price (stored as pence, displayed as pounds).
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            // When retrieving the price, divide by 100 and round to 2 decimal places
            get: fn(int $value) => round($value / 100, 2),
            // When storing the price, multiply by 100 to store as pence
            set: fn(float $value) => $value * 100,
        );
    }

    /**
     * Scope a query to filter car services by service type (UUID or name).
     */
    public function scopeFilterByServiceType(Builder $query, ?string $type): Builder
    {

        if (!$type) {
            return $query;
        }

        return $query->whereHas('serviceType', function (Builder $query) use ($type) {
            $query->when(Str::isUuid($type), function (Builder $query) use ($type) {
                $query->where('uuid', $type);
            }, function (Builder $query) use ($type) {
                $query->where('name', $type);
            });
        });
    }
}
