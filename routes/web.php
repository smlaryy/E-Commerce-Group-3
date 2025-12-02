<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BuyerController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/buyer/dashboard', [BuyerController::class, 'index'])
     ->middleware(['auth', 'role:buyer'])
     ->name('buyer.dashboard');
    



require __DIR__.'/auth.php';
