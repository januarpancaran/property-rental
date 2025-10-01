<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleController;
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

// Role routes
Route::middleware(['auth', 'permission:manage_roles_permissions'])->group(function () {
    Route::resource('/admin/roles', RoleController::class);
});

// Property management routes
Route::middleware(['auth', 'permission:view_all_properties'])->group(function () {
    Route::get('/properties', [PropertyController::class, 'index']);
});

Route::middleware(['auth', 'permission:manage_properties'])->group(function () {
    Route::get('/admin/properties', [PropertyController::class, 'adminIndex']);
});

Route::middleware(['auth', 'permission:create_property'])->group(function () {
    Route::get('/properties/create', [PropertyController::class, 'create']);
});

require __DIR__ . '/auth.php';
