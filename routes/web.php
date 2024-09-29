<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::post('/cart', [ProductController::class, 'addToCart']);
Route::post('/checkout', [OrderController::class, 'checkout']);


Route::get('/', function () {
    return app(ProductController::class)->index([
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('magazin');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/orders', function () {
    return app(OrderController::class)->index();
})->middleware(['auth', 'verified'])->name('orders');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::delete('/orders/{id}', [OrderController::class, 'delete']);
});

require __DIR__.'/auth.php';
