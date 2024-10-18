<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookingDate extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Define relationship to mechanics via the pivot table.
     */
    public function mechanics(): BelongsToMany
    {
        return $this->belongsToMany(Mechanic::class, 'mechanic_availabilities')
            ->withPivot('start_time', 'end_time', 'is_available');
    }

    /**
     * Scope to get active booking dates.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get booking dates that have available mechanics.
     */
    public function scopeWithAvailableMechanics(Builder $query): Builder
    {
        return $query->whereHas('mechanics', function ($q) {
            $q->where('mechanic_availabilities.is_available', true); // Use the explicit pivot table name
        });
    }

    /**
     * Scope to get booking dates within a specified date range.
     */
    public function scopeWithinDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope to get booking dates where mechanics are available on a specific date.
     */
    public function scopeAvailableOnDate(Builder $query, $date): Builder
    {
        return $query->whereDate('date', $date)
            ->whereHas('mechanics', function ($q) {
                $q->where('mechanic_availabilities.is_available', true); // Reference the pivot table explicitly
            });
    }

    /**
     * Scope to get booking dates associated with a specific mechanic.
     */
    public function scopeWithMechanic(Builder $query, $mechanicId)
    {
        return $query->whereHas('mechanics', function ($q) use ($mechanicId) {
            $q->where('mechanics.uuid', $mechanicId);
        });
    }
}
