<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Admin gets all permissions
        $adminRole = Role::where('name', 'admin')->first();
        $allPermissions = Permission::all();
        $adminRole->permissions()->attach($allPermissions);

        // Landlord permissions
        $landlordRole = Role::where('name', 'landlord')->first();
        $landlordPermissions = Permission::whereIn('name', [
            // Property Management
            'create_property',
            'edit_own_property',
            'view_own_properties',
            'delete_property',
            'manage_property_status',

            // Property Photos
            'upload_property_photos',
            'delete_property_photos',
            'manage_property_photos',

            // Availability Management
            'manage_availability',
            'view_availability',
            'block_dates',
            'set_pricing_override',

            // Booking Management
            'view_property_bookings',
            'confirm_booking',
            'cancel_booking',
            'complete_booking',

            // Contract Management
            'create_contract',
            'view_property_contracts',
            'sign_contract',
            'terminate_contract',
            'upload_contract_file',

            // Payment Management
            'view_property_payments',
            'process_payment',
            'refund_payment',

            // Maintenance Management
            'view_property_maintenance',
            'assign_maintenance',
            'schedule_maintenance',
            'complete_maintenance',

            // Reports
            'view_property_reports',
            'view_financial_reports',
            'view_occupancy_reports',
            'view_maintenance_reports',
            'export_reports',

            // Communication
            'send_notifications',
            'manage_messages',
        ])->get();
        $landlordRole->permissions()->attach($landlordPermissions);

        // Tenant permissions
        $tenantRole = Role::where('name', 'tenant')->first();
        $tenantPermissions = Permission::whereIn('name', [
            // Property Viewing
            'view_all_properties',

            // Booking Management
            'create_booking',
            'view_own_bookings',
            'cancel_booking',

            // Contract Management
            'view_own_contracts',
            'sign_contract',

            // Payment Management
            'view_own_payments',

            // Maintenance Management
            'create_maintenance_request',
            'view_own_maintenance',

            // Profile Management
            'view_user_profile',
        ])->get();
        $tenantRole->permissions()->attach($tenantPermissions);
    }
}
