<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    //users
    Route::get('/users/{uuid}/update-status', [UserController::class, 'updateStatus'])->name('users.update-status');
    //plants
    Route::get('/plants/{uuid}/synchronize-plant', [PlantController::class, 'synchronizePlant'])->name('plants.synchronize-plant');
    Route::post('/plants/{uuid}/synchronize', [PlantController::class, 'synchronize'])->name('plants.synchronize');
    Route::get('/plants/{uuid}/manage-department', [PlantController::class, 'manageDepartment'])->name('plants.manage-department');
    Route::put('/plants/{uuid}/update-manage-department', [PlantController::class, 'updateManageDepartment'])->name('plants.update-manage-department');
    //resources
    Route::resource('/dashboard', DashboardController::class)->except(['show']);
    Route::resource('/departments', DepartmentController::class)->except(['show']);
    Route::resource('/plants', PlantController::class)->except(['show']);
    Route::resource('/users', UserController::class)->except(['show']);
    Route::resource('/complaints', ComplaintController::class)->except(['show']);
    Route::prefix('roles')
        ->name('roles.')
        ->controller(RoleController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');

            Route::get('/{role}/manage-access', 'manageAccess')->name('manage-access');
            Route::post('/{role}/manage-access', 'updateAccess')->name('manage-access.update');
        });

    // PERMISSION ROUTES
    Route::prefix('permissions')
        ->name('permissions.')
        ->controller(PermissionController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{permission}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
});
