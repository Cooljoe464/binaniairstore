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
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\ShelfLocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\TyreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\GoodsReceivedNoteController;
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

    Route::controller(AircraftController::class)->prefix('aircraft')->as('aircraft.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:aircrafts-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:aircrafts-create');
        Route::post('/', 'store')->name('store')->middleware('permission:aircrafts-create');
        Route::get('/{aircraft}/edit', 'edit')->name('edit')->middleware('permission:aircrafts-edit');
        Route::match(['PUT', 'PATCH'], '/{aircraft}', 'update')->name('update')->middleware('permission:aircrafts-edit');
        Route::delete('/{aircraft}', 'destroy')->name('destroy')->middleware('permission:aircrafts-delete');
    });

    Route::controller(ShelfController::class)->prefix('shelves')->as('shelves.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:shelf-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:shelf-create');
        Route::post('/', 'store')->name('store')->middleware('permission:shelf-create');
        Route::get('/{shelf}/edit', 'edit')->name('edit')->middleware('permission:shelf-edit');
        Route::match(['PUT', 'PATCH'], '/{shelf}', 'update')->name('update')->middleware('permission:shelf-edit');
        Route::delete('/{shelf}', 'destroy')->name('destroy')->middleware('permission:shelf-delete');
    });

    Route::controller(SupplierController::class)->prefix('suppliers')->as('suppliers.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:suppliers-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:suppliers-create');
        Route::post('/', 'store')->name('store')->middleware('permission:suppliers-create');
        Route::get('/{supplier}/edit', 'edit')->name('edit')->middleware('permission:suppliers-edit');
        Route::match(['PUT', 'PATCH'], '/{supplier}', 'update')->name('update')->middleware('permission:suppliers-edit');
        Route::delete('/{supplier}', 'destroy')->name('destroy')->middleware('permission:suppliers-delete');
    });

    Route::controller(ShelfLocationController::class)->prefix('shelf-locations')->as('shelf-locations.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:shelf-locations-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:shelf-locations-create');
        Route::post('/', 'store')->name('store')->middleware('permission:shelf-locations-create');
        Route::get('/{shelfLocation}/edit', 'edit')->name('edit')->middleware('permission:shelf-locations-edit');
        Route::match(['PUT', 'PATCH'], '/{shelfLocation}', 'update')->name('update')->middleware('permission:shelf-locations-edit');
        Route::delete('/{shelfLocation}', 'destroy')->name('destroy')->middleware('permission:shelf-locations-delete');
    });

    Route::controller(LocationController::class)->prefix('locations')->as('locations.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:locations-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:locations-create');
        Route::post('/', 'store')->name('store')->middleware('permission:locations-create');
        Route::get('/{location}', 'show')->name('show');
        Route::get('/{location}/edit', 'edit')->name('edit')->middleware('permission:locations-edit');
        Route::match(['PUT', 'PATCH'], '/{location}', 'update')->name('update')->middleware('permission:locations-edit');
        Route::delete('/{location}', 'destroy')->name('destroy')->middleware('permission:locations-delete');
    });

    Route::controller(RotableController::class)->prefix('rotables')->as('rotables.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:rotables-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:rotables-create');
        Route::post('/', 'store')->name('store')->middleware('permission:rotables-create');
        Route::get('/{rotable}/edit', 'edit')->name('edit')->middleware('permission:rotables-edit');
        Route::match(['PUT', 'PATCH'], '/{rotable}', 'update')->name('update')->middleware('permission:rotables-edit');
        Route::delete('/{rotable}', 'destroy')->name('destroy')->middleware('permission:rotables-delete');
    });

    Route::controller(ConsumableController::class)->prefix('consumables')->as('consumables.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:consumables-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:consumables-create');
        Route::post('/', 'store')->name('store')->middleware('permission:consumables-create');
        Route::get('/{consumable}/edit', 'edit')->name('edit')->middleware('permission:consumables-edit');
        Route::match(['PUT', 'PATCH'], '/{consumable}', 'update')->name('update')->middleware('permission:consumables-edit');
        Route::delete('/{consumable}', 'destroy')->name('destroy')->middleware('permission:consumables-delete');
    });

    Route::controller(EsdItemController::class)->prefix('esd-items')->as('esd-items.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:esd-items-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:esd-items-create');
        Route::post('/', 'store')->name('store')->middleware('permission:esd-items-create');
        Route::get('/{esdItem}/edit', 'edit')->name('edit')->middleware('permission:esd-items-edit');
        Route::match(['PUT', 'PATCH'], '/{esdItem}', 'update')->name('update')->middleware('permission:esd-items-edit');
        Route::delete('/{esdItem}', 'destroy')->name('destroy')->middleware('permission:esd-items-delete');
    });

    Route::controller(DangerousGoodController::class)->prefix('dangerous-goods')->as('dangerous-goods.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:dangerous-goods-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:dangerous-goods-create');
        Route::post('/', 'store')->name('store')->middleware('permission:dangerous-goods-create');
        Route::get('/{dangerousGood}/edit', 'edit')->name('edit')->middleware('permission:dangerous-goods-edit');
        Route::match(['PUT', 'PATCH'], '/{dangerousGood}', 'update')->name('update')->middleware('permission:dangerous-goods-edit');
        Route::delete('/{dangerousGood}', 'destroy')->name('destroy')->middleware('permission:dangerous-goods-delete');
    });

    Route::controller(TyreController::class)->prefix('tyres')->as('tyres.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:tyres-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:tyres-create');
        Route::post('/', 'store')->name('store')->middleware('permission:tyres-create');
        Route::get('/{tyre}/edit', 'edit')->name('edit')->middleware('permission:tyres-edit');
        Route::match(['PUT', 'PATCH'], '/{tyre}', 'update')->name('update')->middleware('permission:tyres-edit');
        Route::delete('/{tyre}', 'destroy')->name('destroy')->middleware('permission:tyres-delete');
    });

    Route::controller(ToolController::class)->prefix('tools')->as('tools.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:tools-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:tools-create');
        Route::post('/', 'store')->name('store')->middleware('permission:tools-create');
        Route::get('/{tool}/edit', 'edit')->name('edit')->middleware('permission:tools-edit');
        Route::match(['PUT', 'PATCH'], '/{tool}', 'update')->name('update')->middleware('permission:tools-edit');
        Route::delete('/{tool}', 'destroy')->name('destroy')->middleware('permission:tools-delete');
    });

    Route::controller(DopeController::class)->prefix('dopes')->as('dopes.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:dopes-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:dopes-create');
        Route::post('/', 'store')->name('store')->middleware('permission:dopes-create');
        Route::get('/{dope}/edit', 'edit')->name('edit')->middleware('permission:dopes-edit');
        Route::match(['PUT', 'PATCH'], '/{dope}', 'update')->name('update')->middleware('permission:dopes-edit');
        Route::delete('/{dope}', 'destroy')->name('destroy')->middleware('permission:dopes-delete');
    });

    // Requisitions
    Route::controller(RequisitionController::class)->prefix('requisitions')->as('requisitions.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:requisitions-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:requisitions-create');
        Route::post('/', 'store')->name('store')->middleware('permission:requisitions-create');
        Route::get('/{requisition}', 'show')->name('show');
        Route::get('/{requisition}/edit', 'edit')->name('edit')->middleware('permission:requisitions-edit');
        Route::match(['PUT', 'PATCH'], '/{requisition}', 'update')->name('update')->middleware('permission:requisitions-edit');
        Route::delete('/{requisition}', 'destroy')->name('destroy')->middleware('permission:requisitions-delete');
        Route::post('/{requisition}/approve', 'approve')->name('approve')->middleware('permission:requisitions-approve');
        Route::post('/{requisition}/reject', 'reject')->name('reject')->middleware('permission:requisitions-reject');
        Route::post('/{requisition}/disburse', 'disburse')->name('disburse')->middleware('permission:requisitions-disburse');
    });

    // Goods Received Notes
    Route::controller(GoodsReceivedNoteController::class)->prefix('goods-received-notes')->as('goods-received-notes.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:goods-received-notes-list');
        Route::get('/create', 'create')->name('create')->middleware('permission:goods-received-notes-create');
        Route::post('/', 'store')->name('store')->middleware('permission:goods-received-notes-create');
        Route::get('/{goodsReceivedNote}', 'show')->name('show');
        Route::get('/{goodsReceivedNote}/edit', 'edit')->name('edit')->middleware('permission:goods-received-notes-edit');
        Route::match(['PUT', 'PATCH'], '/{goodsReceivedNote}', 'update')->name('update')->middleware('permission:goods-received-notes-edit');
        Route::delete('/{goodsReceivedNote}', 'destroy')->name('destroy')->middleware('permission:goods-received-notes-delete');
        Route::post('/{goodsReceivedNote}/approve', 'approve')->name('approve')->middleware('permission:goods-received-notes-approve');
        Route::post('/{goodsReceivedNote}/reject', 'reject')->name('reject')->middleware('permission:goods-received-notes-reject');
    });
});
