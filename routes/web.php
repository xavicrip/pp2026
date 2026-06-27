<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// proteger las rutas con el middleware admin
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin() ? redirect()->route('categories.index') : redirect()->route('client.orders.index');
    }

    return redirect()->route('login');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('order-items', OrderItemController::class);
    Route::resource('users', UserController::class);
});

// Rutas del cliente
Route::middleware(['auth'])->prefix('mis-pedidos')->name('client.orders.')->group(function () {
    Route::get('/', [OrderController::class, 'clientIndex'])->name('index');
    Route::get('/{order}', [OrderController::class, 'clientShow'])->name('show');
});

Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('categories.index')
        : redirect()->route('client.orders.index');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
