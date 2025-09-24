<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'System Administrator',
                'description' => 'Full system access and management capabilities',
                'is_active' => true,
            ],
            [
                'name' => 'landlord',
                'display_name' => 'Property Owner',
                'description' => 'Manages properties and views tenant information',
                'is_active' => true,
            ],
            [
                'name' => 'tenant',
                'display_name' => 'Renter',
                'description' => 'Access to personal rental information and payments',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
