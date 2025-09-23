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
        'poperty_type',
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alternative to owner
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
