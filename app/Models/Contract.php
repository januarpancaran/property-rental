<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'booking_id',
        'start_date',
        'end_date',
        'rent_amount',
        'security_deposit',
        'contract_type',
        'status',
        'terms_conditions',
        'contract_file_path',
        'signed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'rent_amount' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'signed_at' => 'datetime',
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

    // Relationship with booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Get landlord through property
    public function landlord()
    {
        return $this->property->user();
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeTerminated($query)
    {
        return $query->where('status', 'terminated');
    }

    public function scopeForProperty($query, $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeCurrent($query)
    {
        $today = Carbon::today();
        return $query->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', 'active');
    }

    public function scopeExpiring($query, $days = 30)
    {
        $futureDate = Carbon::today()->addDays($days);
        return $query->where('end_date', '<=', $futureDate)
            ->where('status', 'active');
    }

    // Helper methods
    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isExpired()
    {
        return $this->status === 'expired';
    }

    public function isTerminated()
    {
        return $this->status === 'terminated';
    }

    public function isSigned()
    {
        return !is_null($this->signed_at);
    }

    public function isCurrent()
    {
        $today = Carbon::today();
        return $this->isActive() &&
            $this->start_date <= $today &&
            $this->end_date >= $today;
    }

    // Calculate contract duration in months
    public function getDurationInMonthsAttribute()
    {
        return $this->start_date->diffInMonths($this->end_date);
    }

    // Calculate contract duration in days
    public function getDurationInDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    // Get formatted rent amount
    public function getFormattedRentAttribute()
    {
        return 'Rp' . number_format($this->rent_amount, 0, ',', '.');
    }

    // Get formatted security deposit
    public function getFormattedSecurityDepositAttribute()
    {
        return $this->security_deposit ? 'Rp' . number_format($this->security_deposit, 0, ',', '.') : null;
    }

    // Get contract file URL
    public function getContractFileUrlAttribute()
    {
        return $this->contract_file_path ? Storage::url($this->contract_file_path) : null;
    }

    // Check if contract is expiring soon
    public function isExpiringSoon($days = 30)
    {
        if (!$this->isActive()) {
            return false;
        }

        return $this->end_date <= Carbon::today()->addDays($days);
    }

    // Sign the contract
    public function sign()
    {
        $this->update([
            'signed_at' => now(),
            'status' => 'active'
        ]);
    }

    // Terminate the contract
    public function terminate()
    {
        $this->update(['status' => 'terminated']);
    }

    // Mark as expired
    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
    }

    // Delete contract file when model is deleted
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($contract) {
            if ($contract->contract_file_path && Storage::exists($contract->contract_file_path)) {
                Storage::delete($contract->contract_file_path);
            }
        });
    }

    // Calculate total contract value
    public function getTotalValueAttribute()
    {
        return $this->rent_amount * $this->duration_in_months;
    }
}
