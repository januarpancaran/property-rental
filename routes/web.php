<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', fn () => view('dashboard'))
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
        Route::get('properties', [PropertyController::class, 'adminIndex'])->name('properties.index');
        Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
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

    // AJAX: Check availability
    Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('check-availability');
});

require __DIR__ . '/auth.php';
