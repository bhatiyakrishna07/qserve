<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodItemController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Redirect root to admin dashboard
Route::get('/', [MenuController::class, 'landing'])->name('home');

// Customer Routes (No Auth Required)
Route::get('/menu', [MenuController::class, 'index'])
    ->name('customer.menu');

Route::post('/order', [CustomerOrderController::class, 'store'])
    ->name('customer.order.store');

Route::get('/order/confirmation/{orderId}', [CustomerOrderController::class, 'confirmation'])
    ->name('customer.order.confirmation');

// Admin Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        
        // Categories
        Route::resource('categories', CategoryController::class);

        // Food Items
        Route::resource('food-items', FoodItemController::class);

        // Tables
        Route::resource('tables', TableController::class);

        // Regenerate QR Code
        Route::get('tables/{table}/regenerate-qr', [TableController::class, 'regenerateQr'])
            ->name('tables.regenerate-qr');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

        Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
    });

// Auth Routes (login/logout)
require __DIR__.'/auth.php';