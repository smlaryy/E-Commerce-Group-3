<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;              
use App\Http\Controllers\UserTransactionController;        
use App\Http\Controllers\Seller\SellerController;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES (guest & semua user)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// DASHBOARD BUYER
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->middleware('role:buyer, seller')
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:buyer'])->group(function () {

    // Cart page (NEW)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // Tambah cart
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    // Update qty (NEW)
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    // Remove item (NEW)
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

});

Route::middleware(['auth', 'role:buyer'])->group(function () {

    // Checkout Page (NEW)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    // Submit Checkout (NEW)
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

});

Route::middleware(['auth', 'role:buyer'])->group(function () {

    Route::get('/transactions', [UserTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [UserTransactionController::class, 'show'])->name('transactions.show');

});

// ROUTES ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('users', AdminUserController::class);

        // Tambahan untuk STORE (verifikasi / reject)
        Route::post('/stores/{store}/verify', [AdminStoreController::class, 'verify'])
            ->name('stores.verify');

        Route::post('/stores/{store}/reject', [AdminStoreController::class, 'reject'])
            ->name('stores.reject');

        // CRUD utama store
        Route::resource('stores', AdminStoreController::class);

        Route::resource('transactions', AdminTransactionController::class)->only(['index','show']);
        Route::resource('withdrawals', AdminWithdrawalController::class)->only(['index','show','update']);
});

// ROUTES SELLER
Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/form', [SellerController::class, 'create'])->name('form');
        Route::post('/form', [SellerController::class, 'store'])->name('store');
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    });

require __DIR__.'/auth.php';
