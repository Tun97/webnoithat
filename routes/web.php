<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\GhnAddressController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/san-pham', [ProductController::class, 'index'])->name('client.products.index');
Route::get('/san-pham/{product:slug}', [ProductController::class, 'show'])->name('client.products.show');
Route::get('/gioi-thieu', [AboutController::class, 'index'])->name('client.about');
Route::get('/lien-he', [ContactController::class, 'index'])->name('client.contact');
Route::post('/lien-he', [ContactController::class, 'store'])->name('client.contact.store');
Route::post('/tu-van-ngay', [ContactController::class, 'quickConsultation'])->name('client.contact.quick');
Route::get('/dia-chi/tinh-thanh', [GhnAddressController::class, 'provinces'])->name('client.address.provinces');
Route::get('/dia-chi/quan-huyen', [GhnAddressController::class, 'districts'])->name('client.address.districts');
Route::get('/dia-chi/phuong-xa', [GhnAddressController::class, 'wards'])->name('client.address.wards');
Route::post('/thanh-toan/momo/ipn', [CheckoutController::class, 'momoIpn'])->name('client.checkout.momo.ipn');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/gio-hang', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('/gio-hang/{product}', [CartController::class, 'store'])->name('client.cart.store');
    Route::patch('/gio-hang/{cartItem}', [CartController::class, 'update'])->name('client.cart.update');
    Route::delete('/gio-hang/{cartItem}', [CartController::class, 'destroy'])->name('client.cart.destroy');
    Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('client.checkout.index');
    Route::post('/thanh-toan', [CheckoutController::class, 'store'])->name('client.checkout.store');
    Route::get('/thanh-toan/momo/return', [CheckoutController::class, 'momoReturn'])->name('client.checkout.momo.return');
    Route::get('/thanh-toan/momo/{order}/redirect', [CheckoutController::class, 'momoRedirect'])->name('client.checkout.momo.redirect');
    Route::get('/don-hang', [OrderController::class, 'index'])->name('client.orders.index');
    Route::post('/don-hang/{order}/xac-nhan-chuyen-khoan', [OrderController::class, 'confirmBankTransfer'])->name('client.orders.bank-transfer.confirm');
    Route::get('/don-hang/{order}', [OrderController::class, 'show'])->name('client.orders.show');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
