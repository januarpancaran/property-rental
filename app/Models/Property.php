<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'address',
        'city',
        'state',
        'postal_code',
        'property_type',
        'rent_amount',
        'bedrooms',
        'bathrooms',
        'area_sqm',
        'status'
    ];

    protected $casts = [
        'rent_amount' => 'decimal:2',
        'area_sqm' => 'decimal:2',
    ];

    // Relationsihp to users
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alternative to owner
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with property photos
    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    public function featuredPhoto()
    {
        return $this->hasOne(PropertyPhoto::class)->where('is_featured', true);
    }

    public function firstPhoto()
    {
        return $this->hasOne(PropertyPhoto::class)->orderBy('sort_order')->orderBy('id');
    }

    // Relationship with availability_calendars
    public function availabilityCalendar()
    {
        return $this->hasMany(AvailabilityCalendar::class);
    }

    // Relationship with booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function confirmedBookings()
    {
        return $this->hasMany(Booking::class)->confirmed();
    }

    public function pendingBookings()
    {
        return $this->hasMany(Booking::class)->pending();
    }

    public function availableDates()
    {
        return $this->hasMany(AvailabilityCalendar::class)->where('status', 'available');
    }

    public function isAvailableForDates($startDate, $endDate)
    {
        return $this->AvailabilityCalendar::isDateRangeAvailable($this->id, $startDate, $endDate);
    }

    // Relationshiop with contract
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function activeContracts()
    {
        return $this->hasMany(Contract::class)->active();
    }

    public function currentContract()
    {
        return $this->hasOne(Contract::class)->current();
    }

    // Relationship with maintenance
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function pendingMaintenances()
    {
        return $this->hasMany(Maintenance::class)->pending();
    }

    public function urgentMaintenances()
    {
        return $this->hasMany(Maintenance::class)->urgent();
    }

    // Scope for filtering
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeRented($query)
    {
        return $query->where('status', 'rented');
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    public function scopeInCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeInState($query, $state)
    {
        return $query->where('state', $state);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('property_type', $type);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('rent_amount', [$min, $max]);
    }

    // Accessor for rent amount
    public function getFormattedRentAmountAttribute(): string
    {
        return 'Rp' . number_format($this->rent_amount, 0, ',', '.');
    }

    // Accessor for full address
    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->postal_code}";
    }

    // Check for status
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isRented(): bool
    {
        return $this->status === 'rented';
    }

    public function isMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }
}
