<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Customer\HomeController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

Route::get('/', fn () => view('welcome'))->name('home');

Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer'])->group(function () {
     Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

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

    Route::get('customers',                [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create',         [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers',               [CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/{customer}/edit',[CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('customers/{customer}',     [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/{customer}',  [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    Route::get('promotions',                [PromotionController::class, 'index'])->name('promotions.index');
    Route::get('promotions/create',         [PromotionController::class, 'create'])->name('promotions.create');
    Route::post('promotions',               [PromotionController::class, 'store'])->name('promotions.store');
    Route::get('promotions/{promotion}/edit', [PromotionController::class, 'edit'])->name('promotions.edit');
    Route::put('promotions/{promotion}',    [PromotionController::class, 'update'])->name('promotions.update');
    Route::delete('promotions/{promotion}', [PromotionController::class, 'destroy'])->name('promotions.destroy');
    Route::patch('promotions/{promotion}/toggle', [PromotionController::class, 'toggle'])->name('promotions.toggle');


    
    

});



require __DIR__.'/auth.php';
