<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'manage_users', 'display_name' => 'Manage Users', 'group' => 'user'],
            ['name' => 'view_users', 'display_name' => 'View Users', 'group' => 'user'],
            ['name' => 'create_user', 'display_name' => 'Create User', 'group' => 'user'],
            ['name' => 'edit_user', 'display_name' => 'Edit User', 'group' => 'user'],
            ['name' => 'delete_user', 'display_name' => 'Delete User', 'group' => 'user'],
            ['name' => 'view_user_profile', 'display_name' => 'View User Profile', 'group' => 'user'],

            // Property Management
            ['name' => 'manage_properties', 'display_name' => 'Manage All Properties', 'group' => 'property'],
            ['name' => 'view_all_properties', 'display_name' => 'View All Properties', 'group' => 'property'],
            ['name' => 'create_property', 'display_name' => 'Create Property', 'group' => 'property'],
            ['name' => 'edit_own_property', 'display_name' => 'Edit Own Property', 'group' => 'property'],
            ['name' => 'edit_any_property', 'display_name' => 'Edit Any Property', 'group' => 'property'],
            ['name' => 'delete_property', 'display_name' => 'Delete Property', 'group' => 'property'],
            ['name' => 'view_own_properties', 'display_name' => 'View Own Properties', 'group' => 'property'],
            ['name' => 'manage_property_status', 'display_name' => 'Manage Property Status', 'group' => 'property'],

            // Property Photos
            ['name' => 'manage_property_photos', 'display_name' => 'Manage Property Photos', 'group' => 'property'],
            ['name' => 'upload_property_photos', 'display_name' => 'Upload Property Photos', 'group' => 'property'],
            ['name' => 'delete_property_photos', 'display_name' => 'Delete Property Photos', 'group' => 'property'],

            // Availability Calendar
            ['name' => 'manage_availability', 'display_name' => 'Manage Availability Calendar', 'group' => 'availability'],
            ['name' => 'view_availability', 'display_name' => 'View Availability Calendar', 'group' => 'availability'],
            ['name' => 'block_dates', 'display_name' => 'Block Available Dates', 'group' => 'availability'],
            ['name' => 'set_pricing_override', 'display_name' => 'Set Pricing Override', 'group' => 'availability'],

            // Booking Management
            ['name' => 'manage_all_bookings', 'display_name' => 'Manage All Bookings', 'group' => 'booking'],
            ['name' => 'view_all_bookings', 'display_name' => 'View All Bookings', 'group' => 'booking'],
            ['name' => 'create_booking', 'display_name' => 'Create Booking', 'group' => 'booking'],
            ['name' => 'view_own_bookings', 'display_name' => 'View Own Bookings', 'group' => 'booking'],
            ['name' => 'view_property_bookings', 'display_name' => 'View Property Bookings', 'group' => 'booking'],
            ['name' => 'confirm_booking', 'display_name' => 'Confirm Booking', 'group' => 'booking'],
            ['name' => 'cancel_booking', 'display_name' => 'Cancel Booking', 'group' => 'booking'],
            ['name' => 'complete_booking', 'display_name' => 'Complete Booking', 'group' => 'booking'],

            // Contract Management
            ['name' => 'manage_all_contracts', 'display_name' => 'Manage All Contracts', 'group' => 'contract'],
            ['name' => 'view_all_contracts', 'display_name' => 'View All Contracts', 'group' => 'contract'],
            ['name' => 'create_contract', 'display_name' => 'Create Contract', 'group' => 'contract'],
            ['name' => 'view_own_contracts', 'display_name' => 'View Own Contracts', 'group' => 'contract'],
            ['name' => 'view_property_contracts', 'display_name' => 'View Property Contracts', 'group' => 'contract'],
            ['name' => 'sign_contract', 'display_name' => 'Sign Contract', 'group' => 'contract'],
            ['name' => 'terminate_contract', 'display_name' => 'Terminate Contract', 'group' => 'contract'],
            ['name' => 'upload_contract_file', 'display_name' => 'Upload Contract File', 'group' => 'contract'],

            // Payment Management
            ['name' => 'manage_all_payments', 'display_name' => 'Manage All Payments', 'group' => 'payment'],
            ['name' => 'view_all_payments', 'display_name' => 'View All Payments', 'group' => 'payment'],
            ['name' => 'process_payment', 'display_name' => 'Process Payment', 'group' => 'payment'],
            ['name' => 'view_own_payments', 'display_name' => 'View Own Payments', 'group' => 'payment'],
            ['name' => 'view_property_payments', 'display_name' => 'View Property Payments', 'group' => 'payment'],
            ['name' => 'refund_payment', 'display_name' => 'Refund Payment', 'group' => 'payment'],
            ['name' => 'handle_payment_disputes', 'display_name' => 'Handle Payment Disputes', 'group' => 'payment'],

            // Payment Reminders
            ['name' => 'manage_payment_reminders', 'display_name' => 'Manage Payment Reminders', 'group' => 'payment'],
            ['name' => 'send_payment_reminders', 'display_name' => 'Send Payment Reminders', 'group' => 'payment'],
            ['name' => 'view_payment_reminders', 'display_name' => 'View Payment Reminders', 'group' => 'payment'],

            // Maintenance Management
            ['name' => 'manage_all_maintenance', 'display_name' => 'Manage All Maintenance Requests', 'group' => 'maintenance'],
            ['name' => 'view_all_maintenance', 'display_name' => 'View All Maintenance Requests', 'group' => 'maintenance'],
            ['name' => 'create_maintenance_request', 'display_name' => 'Create Maintenance Request', 'group' => 'maintenance'],
            ['name' => 'view_own_maintenance', 'display_name' => 'View Own Maintenance Requests', 'group' => 'maintenance'],
            ['name' => 'view_property_maintenance', 'display_name' => 'View Property Maintenance', 'group' => 'maintenance'],
            ['name' => 'assign_maintenance', 'display_name' => 'Assign Maintenance Request', 'group' => 'maintenance'],
            ['name' => 'schedule_maintenance', 'display_name' => 'Schedule Maintenance', 'group' => 'maintenance'],
            ['name' => 'complete_maintenance', 'display_name' => 'Complete Maintenance', 'group' => 'maintenance'],
            ['name' => 'cancel_maintenance', 'display_name' => 'Cancel Maintenance Request', 'group' => 'maintenance'],

            // Reports & Analytics
            ['name' => 'view_all_reports', 'display_name' => 'View All Reports', 'group' => 'report'],
            ['name' => 'view_property_reports', 'display_name' => 'View Property Reports', 'group' => 'report'],
            ['name' => 'view_financial_reports', 'display_name' => 'View Financial Reports', 'group' => 'report'],
            ['name' => 'view_occupancy_reports', 'display_name' => 'View Occupancy Reports', 'group' => 'report'],
            ['name' => 'view_maintenance_reports', 'display_name' => 'View Maintenance Reports', 'group' => 'report'],
            ['name' => 'export_reports', 'display_name' => 'Export Reports', 'group' => 'report'],

            // System Administration
            ['name' => 'manage_system_settings', 'display_name' => 'Manage System Settings', 'group' => 'system'],
            ['name' => 'manage_roles_permissions', 'display_name' => 'Manage Roles & Permissions', 'group' => 'system'],
            ['name' => 'view_system_logs', 'display_name' => 'View System Logs', 'group' => 'system'],
            ['name' => 'backup_database', 'display_name' => 'Backup Database', 'group' => 'system'],
            ['name' => 'manage_notifications', 'display_name' => 'Manage Notifications', 'group' => 'system'],

            // Communication
            ['name' => 'send_notifications', 'display_name' => 'Send Notifications', 'group' => 'communication'],
            ['name' => 'manage_messages', 'display_name' => 'Manage Messages', 'group' => 'communication'],
            ['name' => 'send_bulk_emails', 'display_name' => 'Send Bulk Emails', 'group' => 'communication'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
