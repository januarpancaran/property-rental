<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'date_of_birth',
        'occupation',
        'status',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date'
        ];
    }

    // Get full name
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Get user status
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // Scope to get active users
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Relationship with role
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Check if user has specific permission
    public function hasPermission(string $permission): bool
    {
        return $this->role?->hasPermission($permission) ?? false;
    }

    // Check if user has any of the given permissions
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    // Check if user has all of the given permissions
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    // Get user's role name
    public function getRoleName(): string
    {
        return $this->role?->name ?? 'No Role';
    }

    // Role checking
    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isLandlord(): bool
    {
        return $this->role?->name === 'landlord';
    }

    public function isTenant(): bool
    {
        return $this->role?->name === 'tenant';
    }

    // Relationship with property
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function availableProperties()
    {
        return $this->hasMany(Property::class)->where('status', 'available');
    }

    public function rentedProperties()
    {
        return $this->hasMany(Property::class)->where('status', 'rented');
    }

    // Relationship with booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function activeBookings()
    {
        return $this->hasMany(Booking::class, 'user_id')->confirmed();
    }

    // Relationship with contract
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'user_id');
    }

    public function activeContracts()
    {
        return $this->hasMany(Contract::class, 'user_id')->active();
    }

    public function currentContracts()
    {
        return $this->hasMany(Contract::class, 'user_id')->current();
    }
}
