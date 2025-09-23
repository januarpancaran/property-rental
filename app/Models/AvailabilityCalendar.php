<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AvailabilityCalendar extends Model
{
    use HasFactory;

    protected $table = 'availability_calendar';

    protected $fillable = [
        'property_id',
        'date',
        'status',
        'price_override',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'price_override' => 'decimal:2',
    ];

    // Relationship to property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }

    public function scopeForProperty($query, $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeFuture($query)
    {
        return $query->where('date', '>=', Carbon::today());
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isBooked()
    {
        return $this->status === 'booked';
    }

    // Get effective price (override or property default)
    public function getEffectivePriceAttribute()
    {
        return $this->price_override ?? $this->property->rent_amount;
    }

    // Static method to check availability for date range
    public static function isDateRangeAvailable($propertyId, $startDate, $endDate)
    {
        $unavailableDays = self::forProperty($propertyId)
            ->dateRange($startDate, $endDate)
            ->where('status', '!=', 'available')
            ->count();

        return $unavailableDays === 0;
    }

    // Static method to get available dates for a property
    public static function getAvailableDates($propertyId, $startDate = null, $endDate = null)
    {
        $query = self::forProperty($propertyId)->available();

        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        } elseif ($startDate) {
            $query->where('date', '>=', $startDate);
        } else {
            $query->future();
        }

        return $query->pluck('date');
    }
}
