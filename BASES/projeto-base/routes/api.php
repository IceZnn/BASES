<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ResourceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    Route::middleware(['auth:sanctum', 'role:administrator,manager'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/{resource}', [ResourceController::class, 'index'])->whereIn('resource', [
            'users', 'products', 'categories', 'clients', 'suppliers', 'employees', 'departments', 'orders',
        ]);
        Route::post('/{resource}', [ResourceController::class, 'store'])->whereIn('resource', [
            'users', 'products', 'categories', 'clients', 'suppliers', 'employees', 'departments', 'orders',
        ]);
        Route::get('/{resource}/{id}', [ResourceController::class, 'show'])->whereIn('resource', [
            'users', 'products', 'categories', 'clients', 'suppliers', 'employees', 'departments', 'orders',
        ])->whereNumber('id');
        Route::match(['put', 'patch'], '/{resource}/{id}', [ResourceController::class, 'update'])->whereIn('resource', [
            'users', 'products', 'categories', 'clients', 'suppliers', 'employees', 'departments', 'orders',
        ])->whereNumber('id');
        Route::delete('/{resource}/{id}', [ResourceController::class, 'destroy'])->whereIn('resource', [
            'users', 'products', 'categories', 'clients', 'suppliers', 'employees', 'departments', 'orders',
        ])->whereNumber('id');
    });
});
