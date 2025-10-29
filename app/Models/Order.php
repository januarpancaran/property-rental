<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'order_number',
        'amount',
        'payment_status',
        'va_number',
        'payment_url',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeFailed($query)
    {
        return $query->where('payment_status', 'failed');
    }

    public function scopeExpired($query)
    {
        return $query->where('payment_status', 'expired');
    }

    // Helper methods
    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isFailed()
    {
        return $this->payment_status === 'failed';
    }

    public function isExpired()
    {
        return $this->payment_status === 'expired' ||
               ($this->expired_at && now()->isAfter($this->expired_at));
    }

    // Check and update expiration
    public function checkExpiration()
    {
        if ($this->expired_at && now()->isAfter($this->expired_at) && $this->isPending()) {
            $this->update(['payment_status' => 'expired']);
            return true;
        }
        return false;
    }

    // Formatted amount
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Generate order number
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        return $prefix . $date . $random;
    }

    // Get status badge HTML
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="text-xs font-medium px-2.5 py-0.5 rounded bg-yellow-200 text-yellow-900 dark:bg-yellow-600 dark:text-yellow-100">Pending</span>',
            'paid' => '<span class="text-xs font-medium px-2.5 py-0.5 rounded bg-green-200 text-green-900 dark:bg-green-600 dark:text-green-100">Paid</span>',
            'failed' => '<span class="text-xs font-medium px-2.5 py-0.5 rounded bg-red-200 text-red-900 dark:bg-red-600 dark:text-red-100">Failed</span>',
            'expired' => '<span class="text-xs font-medium px-2.5 py-0.5 rounded bg-gray-200 text-gray-900 dark:bg-gray-600 dark:text-gray-100">Expired</span>',
        ];

        return $badges[$this->payment_status] ?? '';
    }
}
