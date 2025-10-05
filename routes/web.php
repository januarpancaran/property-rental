<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User routes
Route::middleware(['auth', 'permission:manage_users_permissions'])
    ->name('admin.')
    ->group(function () {
        Route::resource('/admin/user', UserController::class);
    });

// Role routes
Route::middleware(['auth', 'permission:manage_roles_permissions'])
    ->name('admin.')
    ->group(function () {
        Route::resource('/admin/roles', RoleController::class);
    });

// Admin property management routes
Route::middleware(['auth', 'permission:manage_properties'])->group(function () {
    Route::get('/admin/properties', [PropertyController::class, 'adminIndex'])->name('admin.properties.index');
    Route::delete('/admin/properties/{property}', [PropertyController::class, 'destroy'])->name('admin.properties.destroy');
});

// Public properties listing
Route::get('/properties', [PropertyController::class, 'index'])
    ->middleware('auth')
    ->name('properties.index');

// Property create
Route::middleware(['auth', 'permission:create_property'])->group(function () {
    Route::get('/landlord/properties', [PropertyController::class, 'myProperties'])->name('landlord.properties.index');
    Route::get('/landlord/properties/create', [PropertyController::class, 'create'])->name('landlord.properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
});

// Property show
Route::get('/properties/{property}', [PropertyController::class, 'show'])
    ->middleware('auth')
    ->name('properties.show');

// Property edit
Route::middleware(['auth', 'permission:edit_own_property'])->group(function () {
    Route::get('/landlord/properties/{property}/edit', [PropertyController::class, 'edit'])->name('landlord.properties.edit');
    Route::put('/landlord/properties/{property}', [PropertyController::class, 'update'])->name('landlord.properties.update');
});

Route::delete('/landlord/properties/{property}', [PropertyController::class, 'destroy'])
    ->middleware(['auth', 'permission:delete_property'])
    ->name('landlord.properties.destroy');

// Property photos
Route::middleware(['auth', 'permission:upload_property_photos'])->group(function () {
    Route::delete('/landlord/properties/photos/{photo}', [PropertyController::class, 'deletePhoto'])->name('properties.photos.delete');
});

// Availability management
Route::middleware(['auth', 'permission:manage_availability'])->group(function () {
    Route::get('/landlord/properties/{property}/availability', [PropertyController::class, 'availability'])->name('properties.availability');
    Route::post('/landlord/properties/{property}/block-dates', [PropertyController::class, 'blockDates'])->name('properties.block-dates');
    Route::post('/landlord/properties/{property}/set-pricing', [PropertyController::class, 'setPricing'])->name('properties.set-pricing');
});

require __DIR__ . '/auth.php';
