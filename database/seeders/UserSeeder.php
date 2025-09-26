<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $landlordRole = Role::where('name', 'landlord')->first();
        $tenantRole = Role::where('name', 'tenant')->first();

        // Create Admin
        User::create([
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'email' => 'admin@admin.com',
            'phone' => '+62812345678',
            'password' => Hash::make('password'),
            'date_of_birth' => '1990-01-01',
            'occupation' => 'System Administrator',
            'status' => 'active',
            'role_id' => $adminRole->id,
        ]);

        // Create Sample Landlords
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'landlord@example.com',
            'phone' => '+62812345679',
            'password' => Hash::make('password'),
            'date_of_birth' => '1985-05-15',
            'occupation' => 'Property Owner',
            'status' => 'active',
            'role_id' => $landlordRole->id,
        ]);

        User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Wilson',
            'email' => 'sarah.landlord@example.com',
            'phone' => '+62812345680',
            'password' => Hash::make('password'),
            'date_of_birth' => '1982-11-23',
            'occupation' => 'Real Estate Investor',
            'status' => 'active',
            'role_id' => $landlordRole->id,
        ]);

        // Create Sample Tenants
        User::create([
            'first_name' => 'Alice',
            'last_name' => 'Johnson',
            'email' => 'tenant@example.com',
            'phone' => '+62812345681',
            'password' => Hash::make('password'),
            'date_of_birth' => '1995-03-10',
            'occupation' => 'Software Engineer',
            'status' => 'active',
            'role_id' => $tenantRole->id,
        ]);

        User::create([
            'first_name' => 'Bob',
            'last_name' => 'Smith',
            'email' => 'bob.tenant@example.com',
            'phone' => '+62812345682',
            'password' => Hash::make('password'),
            'date_of_birth' => '1992-07-18',
            'occupation' => 'Marketing Manager',
            'status' => 'active',
            'role_id' => $tenantRole->id,
        ]);

        User::create([
            'first_name' => 'Emily',
            'last_name' => 'Davis',
            'email' => 'emily.tenant@example.com',
            'phone' => '+62812345683',
            'password' => Hash::make('password'),
            'date_of_birth' => '1993-12-05',
            'occupation' => 'Graphic Designer',
            'status' => 'active',
            'role_id' => $tenantRole->id,
        ]);

        User::create([
            'first_name' => 'Michael',
            'last_name' => 'Brown',
            'email' => 'michael.tenant@example.com',
            'phone' => '+62812345684',
            'password' => Hash::make('password'),
            'date_of_birth' => '1988-09-14',
            'occupation' => 'Teacher',
            'status' => 'active',
            'role_id' => $tenantRole->id,
        ]);

        // Create an inactive user for testing
        User::create([
            'first_name' => 'Inactive',
            'last_name' => 'User',
            'email' => 'inactive@example.com',
            'phone' => '+62812345685',
            'password' => Hash::make('password'),
            'date_of_birth' => '1980-01-01',
            'occupation' => 'Unemployed',
            'status' => 'inactive',
            'role_id' => $tenantRole->id,
        ]);
    }
}
