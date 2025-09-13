<?php

use App\Http\Controllers\AircraftController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\DangerousGoodController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DopeController;
use App\Http\Controllers\EsdItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RotableController;
use App\Http\Controllers\ShelfLocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\TyreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });

    Route::resource('aircraft', AircraftController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('shelf-locations', ShelfLocationController::class);
    Route::resource('rotables', RotableController::class);
    Route::resource('consumables', ConsumableController::class);
    Route::resource('esd-items', EsdItemController::class);
    Route::resource('dangerous-goods', DangerousGoodController::class);
    Route::resource('tyres', TyreController::class);
    Route::resource('tools', ToolController::class);
    Route::resource('dopes', DopeController::class);
});
