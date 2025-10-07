<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'check_in_date',
        'check_out_date',
        'total_amount',
        'booking_status',
        'payment_status',
        'notes'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // Relationship with property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Get landlord
    public function landlord()
    {
        return $this->property->user();
    }

    // Relationship with contract
    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('booking_status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('booking_status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('booking_status', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('booking_status', 'completed');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }

    public function scopeForProperty($query, $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function isPending()
    {
        return $this->booking_status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->booking_status === 'confirmed';
    }

    public function isCancelled()
    {
        return $this->booking_status === 'cancelled';
    }

    public function isCompleted()
    {
        return $this->booking_status === 'completed';
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isUnpaid()
    {
        return $this->payment_status === 'unpaid';
    }

    // Calculate number of nights
    public function getNightsAttribute()
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }

    public function getTotalAmountAttribute()
    {
        // Access the raw database value directly
        $rawAmount = $this->attributes['total_amount'];

        // Check if the raw amount is null before formatting
        if (is_null($rawAmount)) {
            return 'Rp 0';
        }

        return 'Rp' . number_format($rawAmount, 0, ',', '.');
    }

    public function calculateTotalAmount()
    {
        $nights = $this->nights;
        $dailyRate = $this->property->rent_amount / 30;

        return $nights * $dailyRate;
    }

    public static function hasOverlappingBooking($property_id, $checkIn, $checkOut, $excludeBookingId = null)
    {
        $query = self::forProperty($property_id)
            ->where('booking_status', '!=', 'cancelled')
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function ($subQ) use ($checkIn, $checkOut) {
                        $subQ->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                    });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->exists();
    }
}
