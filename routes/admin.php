<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');

        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{user}', [CustomerController::class, 'show'])->name('customers.show');
        Route::delete('customers/{user}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });
