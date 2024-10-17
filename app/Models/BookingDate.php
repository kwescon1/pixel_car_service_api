<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookingDate extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $guarded = ['id'];

    public function mechanics(): BelongsToMany
    {
        return $this->belongsToMany(Mechanic::class, 'mechanic_availabilities')
            ->withPivot('start_time', 'end_time', 'is_available');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIsActive(true);
    }

    public function scopeWithAvailableMechanics(Builder $query): Builder
    {
        return $query->whereHas('mechanics', function ($q) {
            $q->wherePivot('is_available', true);
        });
    }

    public function scopeWithinDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeAvailableOnDate(Builder $query, $date): Builder
    {
        return $query->whereHas('bookingDates', function ($q) use ($date) {
            $q->whereDate($date)
                ->wherePivot('is_available', true);
        });
    }

    public function scopeWithMechanic(Builder $query, $mechanicId)
    {
        return $query->whereHas('mechanics', function ($q) use ($mechanicId) {
            $q->whereUuid($mechanicId);
        });
    }
}
