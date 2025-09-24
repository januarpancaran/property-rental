<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'category',
        'estimated_cost',
        'scheduled_date',
        'completed_date',
        'assigned_to'
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'scheduled_date' => 'date',
        'completed_date' => 'datetime',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Get landlord through property
    public function landlord()
    {
        return $this->property->user();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    public function scopeHigh($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopeMedium($query)
    {
        return $query->where('priority', 'medium');
    }

    public function scopeLow($query)
    {
        return $query->where('priority', 'low');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeForProperty($query, $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeScheduledToday($query)
    {
        return $query->where('scheduled_date', Carbon::today());
    }

    public function scopeOverdue($query)
    {
        return $query->where('scheduled_date', '<', Carbon::today())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isUrgent()
    {
        return $this->priority === 'urgent';
    }

    public function isHigh()
    {
        return $this->priority === 'high';
    }

    public function isOverdue()
    {
        return $this->scheduled_date &&
               $this->scheduled_date < Carbon::today() &&
               !in_array($this->status, ['completed', 'cancelled']);
    }

    // Get formatted estimated cost
    public function getFormattedEstimatedCostAttribute()
    {
        return $this->estimated_cost ? 'Rp ' . number_format($this->estimated_cost, 0, ',', '.') : null;
    }

    // Get priority badge color for UI
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'gray'
        };
    }

    // Get status badge color for UI
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'in_progress' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    // Get days since request was created
    public function getDaysOpenAttribute()
    {
        return $this->created_at->diffInDays(Carbon::now());
    }

    // Get response time (days until scheduled or completed)
    public function getResponseTimeAttribute()
    {
        if ($this->scheduled_date) {
            return $this->created_at->diffInDays($this->scheduled_date);
        }

        if ($this->completed_date) {
            return $this->created_at->diffInDays($this->completed_date);
        }

        return null;
    }

    // Mark as in progress
    public function markInProgress($assignedTo = null)
    {
        $this->update([
            'status' => 'in_progress',
            'assigned_to' => $assignedTo
        ]);
    }

    // Mark as completed
    public function markCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_date' => now()
        ]);
    }

    // Cancel the request
    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    // Schedule the maintenance
    public function schedule($date, $assignedTo = null)
    {
        $this->update([
            'scheduled_date' => $date,
            'assigned_to' => $assignedTo,
            'status' => 'in_progress'
        ]);
    }

    // Assign to someone
    public function assignTo($person)
    {
        $this->update([
            'assigned_to' => $person,
            'status' => 'in_progress'
        ]);
    }
}
