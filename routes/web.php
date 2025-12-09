<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminPropertyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| API Routes (for AJAX calls)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->name('api.')->group(function () {
    // Get blocked dates for a property (used by booking calendar)
    Route::get('/properties/{id}/blocked-dates', [PropertyController::class, 'getBlockedDates'])
        ->name('properties.blocked-dates');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // User Management
    Route::middleware('permission:manage_users')->resource('users', UserController::class);

    // Role Management
    Route::middleware('permission:manage_roles_permissions')->resource('roles', RoleController::class);

    // Property Management
    Route::middleware('permission:manage_properties')->group(function () {
        Route::resource('properties', AdminPropertyController::class);
        Route::delete('properties/{photo}/photo', [AdminPropertyController::class, 'deletePhoto'])->name('properties.photo.destroy');
        Route::get('properties/{property}/availability', [AdminPropertyController::class, 'availability'])->name('properties.availability');
        Route::post('properties/{property}/block-dates', [AdminPropertyController::class, 'blockDates'])->name('properties.block-dates');
        Route::post('properties/{property}/set-pricing', [AdminPropertyController::class, 'setPricing'])->name('properties.set-pricing');
    });

    // Booking Management
    Route::middleware('permission:view_all_bookings')->group(function () {
        Route::get('bookings', [BookingController::class, 'adminIndex'])->name('bookings.index');
    });

    // Admin Booking CRUD
    Route::middleware('permission:manage_all_bookings')->resource('bookings', AdminBookingController::class)->except(['index']);
});

/*
|--------------------------------------------------------------------------
| Property Routes
|--------------------------------------------------------------------------
*/
Route::prefix('properties')->name('properties.')->middleware('auth')->group(function () {

    // Public - Browse all properties
    Route::get('/', [PropertyController::class, 'index'])->name('index');

    // My Properties (Landlord)
    Route::get('/my/list', [PropertyController::class, 'myProperties'])
        ->middleware('permission:create_property')
        ->name('my.index');

    // Create Property
    Route::middleware('permission:create_property')->group(function () {
        Route::get('/create', [PropertyController::class, 'create'])->name('create');
        Route::post('/', [PropertyController::class, 'store'])->name('store');
    });

    // View Property (must be after /my/* routes to avoid conflicts)
    Route::get('/{property}', [PropertyController::class, 'show'])->name('show');

    // Edit/Update Property
    Route::middleware('permission:edit_own_property')->group(function () {
        Route::get('/{property}/edit', [PropertyController::class, 'edit'])->name('edit');
        Route::put('/{property}', [PropertyController::class, 'update'])->name('update');
    });

    // Delete Property
    Route::delete('/{property}', [PropertyController::class, 'destroy'])
        ->middleware('permission:delete_property')
        ->name('destroy');

    // Photo Management
    Route::middleware('permission:upload_property_photos')->group(function () {
        Route::delete('/photos/{photo}', [PropertyController::class, 'deletePhoto'])->name('photos.delete');
    });

    // Availability & Pricing Management
    Route::middleware('permission:manage_availability')->group(function () {
        Route::get('/{property}/availability', [PropertyController::class, 'availability'])->name('availability');
        Route::post('/{property}/block-dates', [PropertyController::class, 'blockDates'])->name('block-dates');
        Route::post('/{property}/set-pricing', [PropertyController::class, 'setPricing'])->name('set-pricing');
    });

    // Property Bookings (for landlords)
    Route::get('/{property}/bookings', [BookingController::class, 'propertyBookings'])->name('bookings');
});

/*
|--------------------------------------------------------------------------
| Booking Routes
|--------------------------------------------------------------------------
*/
Route::prefix('bookings')->name('bookings.')->middleware('auth')->group(function () {

    // List user's bookings
    Route::get('/', [BookingController::class, 'index'])->name('index');

    // Create booking
    Route::middleware('permission:create_booking')->group(function () {
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
    });

    // View booking
    Route::get('/{booking}', [BookingController::class, 'show'])->name('show');

    // Booking actions
    Route::post('/{booking}/confirm', [BookingController::class, 'confirm'])
        ->middleware('permission:confirm_booking')
        ->name('confirm');

    Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');

    Route::post('/{booking}/complete', [BookingController::class, 'complete'])
        ->middleware('permission:complete_booking')
        ->name('complete');

    // AJAX: Check availability (deprecated but kept for backward compatibility)
    Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('check-availability');
});

/*
|--------------------------------------------------------------------------
| Maintenance Routes
|--------------------------------------------------------------------------
*/

// --- Routes untuk Tenant (Membuat & Melihat Permintaan Sendiri) ---
Route::middleware(['auth'])->prefix('tenant')->group(function () {
    // Menampilkan daftar permintaan perawatan milik penyewa
    Route::get('/maintenances', [MaintenanceController::class, 'indexTenant'])
        ->name('tenant.maintenances.index')
        ->middleware('permission:view_own_maintenance');

    // Menampilkan form untuk membuat permintaan baru
    Route::get('/maintenances/create', [MaintenanceController::class, 'create'])
        ->name('tenant.maintenances.create')
        ->middleware('permission:create_maintenance_request');

    // Menyimpan permintaan baru
    Route::post('/maintenances', [MaintenanceController::class, 'store'])
        ->name('tenant.maintenances.store')
        ->middleware('permission:create_maintenance_request');

    // Melihat detail permintaan milik sendiri
    Route::get('/maintenances/{maintenance}', [MaintenanceController::class, 'showTenant'])
        ->name('tenant.maintenances.show')
        ->middleware('permission:view_own_maintenance');
});


// --- Routes untuk Landlord & Admin (Manajemen Permintaan) ---
Route::middleware(['auth'])->prefix('manage')->group(function () {
    // Daftar semua permintaan (Admin: semua; Landlord: properti sendiri)
    Route::get('/maintenances', [MaintenanceController::class, 'indexManage'])
        ->name('manage.maintenances.index')
        ->middleware('permission:view_property_maintenance'); // atau view_all_maintenance jika ada

    // Melihat detail permintaan
    Route::get('/maintenances/{maintenance}', [MaintenanceController::class, 'showManage'])
        ->name('manage.maintenances.show')
        ->middleware('permission:view_property_maintenance');

    // Update status/schedule/assign
    Route::put('/maintenances/{maintenance}/update', [MaintenanceController::class, 'update'])
        ->name('manage.maintenances.update')
        ->middleware('permission:schedule_maintenance');

    // Mark as completed
    Route::post('/maintenances/{maintenance}/complete', [MaintenanceController::class, 'complete'])
        ->name('manage.maintenances.complete')
        ->middleware('permission:complete_maintenance');

    // Cancel request
    Route::post('/maintenances/{maintenance}/cancel', [MaintenanceController::class, 'cancel'])
        ->name('manage.maintenances.cancel')
        ->middleware('permission:complete_maintenance');
});

/*
|--------------------------------------------------------------------------
| Order/Payment Routes
|--------------------------------------------------------------------------
*/
Route::prefix('orders')->name('orders.')->middleware('auth')->group(function () {

    // List user's orders
    Route::get('/', [OrderController::class, 'index'])->name('index');

    // View order details
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');

    // Payment flow
    Route::get('/{booking}/confirm', [OrderController::class, 'confirm'])->name('confirm');
    Route::post('/{booking}/process', [OrderController::class, 'process'])->name('process');
    Route::get('/{order}/waiting', [OrderController::class, 'waiting'])->name('waiting');
    Route::get('/{order}/success', [OrderController::class, 'success'])->name('success');

    // AJAX: Check payment status
    Route::get('/{order}/check-status', [OrderController::class, 'checkStatus'])->name('check-status');
});

// Webhook Route (no auth middleware)
Route::post('/webhook/payment', [WebhookController::class, 'handlePayment'])->name('webhook.payment');

// Notifications Route
Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');

require __DIR__ . '/auth.php';
