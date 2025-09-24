<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PropertyPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'file_name',
        'file_path',
        'alt_text',
        'sort_order',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    // Relationship to property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Scopes
    public function scopeFeatures($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeForProperty($query, $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    // Helper methods
    public function isFeatured()
    {
        return $this->is_featured;
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function getFullPathAttribute()
    {
        return storage_path('app/public/' . $this->file_path);
    }

    // Delete photo file when model is deleted
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($photo) {
            if (Storage::exists($photo->file_path)) {
                Storage::delete($photo->file_path);
            }
        });
    }

    // Set featured photo
    public function setAsFeatured()
    {
        self::where('property_id', $this->property_id)
            ->where('id', '!=', $this->id)
            ->update(['is_featured' => false]);

        $this->update(['is_featured' => true]);
    }

    // Get the next sort order
    public static function getNextSortOrder($propertyId)
    {
        return self::where('property_id', $propertyId)->max('sort_order') + 1;
    }
}
