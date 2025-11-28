<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\DonateController;
use App\Http\Controllers\Customer\FavoriteController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Admin\AdminProfileController;





Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:CUSTOMER'])->group(function () {
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/donate', [DonateController::class, 'index'])->name('donate');
    Route::post('/donate', [DonateController::class, 'store'])->name('donations.store');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/item/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/item/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/orders/{transaction}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/transactions', [\App\Http\Controllers\Customer\TransactionController::class, 'index'])->name('profile.transactions');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');


    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [AdminProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('products/{product}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');

    Route::get('customers',                [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create',         [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers',               [CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/edit/{customer}',[CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('customers/{customer}',     [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/{customer}',  [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('orders', [TransactionController::class, 'index'])->name('orders.index');
    Route::post('orders', [TransactionController::class, 'store'])->name('orders.store');
    Route::get('orders/pending', [TransactionController::class, 'pending'])->name('orders.pending');
    Route::get('orders/completed', [TransactionController::class, 'completed'])->name('orders.completed');
    Route::get('orders/create', [TransactionController::class, 'create'])->name('orders.create');
    Route::get('orders/{order}',[TransactionController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [TransactionController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order}', [TransactionController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [TransactionController::class, 'destroy'])->name('orders.destroy');
    Route::post('orders/{order}/mark-paid-cash', [TransactionController::class, 'markPaidCash'])->name('orders.markPaidCash');
    Route::post('orders/{order}/accept-payment', [TransactionController::class, 'acceptPayment'])->name('orders.acceptPayment');
    Route::post('orders/{order}/reject-payment', [TransactionController::class, 'rejectPayment'])->name('orders.rejectPayment');
    Route::post('orders/{order}/cancel',         [TransactionController::class, 'cancel'])->name('orders.cancel');


    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');



    Route::get('/donations', [\App\Http\Controllers\Admin\DonationController::class, 'index'])->name('donations.index');
    Route::post('/donations/{donation}/verify', [\App\Http\Controllers\Admin\DonationController::class, 'verify'])->name('donations.verify');


});



require __DIR__.'/auth.php';
