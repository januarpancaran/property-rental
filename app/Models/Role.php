<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relationship with user
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relationship with permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    public function givePermission(Permission $permission)
    {
        return $this->permissions()->attach($permission);
    }

    public function removePermission(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            true => '<span class="text-xs font-medium px-2.5 py-0.5 rounded
            bg-green-200 text-green-900
            dark:bg-green-600 dark:text-green-100">Active</span>',

            false => '<span class="text-xs font-medium px-2.5 py-0.5 rounded
            bg-red-200 text-red-900
            dark:bg-red-600 dark:text-red-100">Inactive</span>',
        ];

        return $badges[$this->is_active];
    }
}
