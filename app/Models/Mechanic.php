<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mechanic extends Model
{
    use HasFactory, HasUuid, SoftDeletes, Notifiable;

    // Use guarded to prevent mass assignment on 'id' field
    protected $guarded = ['id'];

    public function bookingDates(): BelongsToMany
    {
        return $this->belongsToMany(BookingDate::class, 'mechanic_availabilities')
            ->withPivot('start_time', 'end_time', 'is_available');
    }

    public function scopeAvailable(Builder $query, $date, $start_time, $end_time): Builder
    {
        return $query->whereHas('bookingDates', function ($q) use ($date, $start_time, $end_time) {
            $q->whereDate($date)
                ->wherePivot('is_available', true)
                ->wherePivot('start_time', '<=', $start_time)
                ->wherePivot('end_time', '>=', $end_time);
        });
    }

    public function scopeWithSpecialty(Builder $query, $specialty)
    {
        return $query->whereSpeciality($specialty);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIsActive(true);
    }
}
