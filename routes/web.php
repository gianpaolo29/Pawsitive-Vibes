<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LoyaltyCardController;
use App\Http\Controllers\Admin\LoyaltyRedemptionController;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::get('/dashboard', fn () => view('customer.home'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('products/{product}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');

    Route::get('orders',                [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create',         [OrderController::class, 'create'])->name('orders.create');   
    Route::post('orders',               [OrderController::class, 'store'])->name('orders.store');     
    Route::get('orders/{order}',        [OrderController::class, 'show'])->name('orders.show');      
    Route::get('orders/{order}/edit',   [OrderController::class, 'edit'])->name('orders.edit');      
    Route::put('orders/{order}',        [OrderController::class, 'update'])->name('orders.update');  
    Route::delete('orders/{order}',     [OrderController::class, 'destroy'])->name('orders.destroy'); 

    Route::post('orders/{order}/mark-paid-cash', [OrderController::class, 'markPaidCash'])->name('orders.markPaidCash');
    Route::post('orders/{order}/accept-payment', [OrderController::class, 'acceptPayment'])->name('orders.acceptPayment');
    Route::post('orders/{order}/reject-payment', [OrderController::class, 'rejectPayment'])->name('orders.rejectPayment');
    Route::post('orders/{order}/cancel',         [OrderController::class, 'cancel'])->name('orders.cancel');
    
    Route::resource('customers', CustomerController::class);
    Route::patch('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])
        ->name('customers.toggle');

    Route::get('loyalty-cards',        [LoyaltyCardController::class, 'index'])->name('loyalty.cards.index');
    Route::get('loyalty-cards/{card}', [LoyaltyCardController::class, 'show'])->name('loyalty.cards.show');
    Route::post('loyalty-cards/{card}/adjust', [LoyaltyCardController::class, 'adjust'])->name('loyalty.cards.adjust');

    Route::get('loyalty-redemptions',  [LoyaltyRedemptionController::class, 'index'])->name('loyalty.redemptions.index');
    Route::post('loyalty-redemptions/{redemption}/approve', [LoyaltyRedemptionController::class, 'approve'])->name('loyalty.redemptions.approve');
    Route::post('loyalty-redemptions/{redemption}/reject',  [LoyaltyRedemptionController::class, 'reject'])->name('loyalty.redemptions.reject');

    Route::view('analytics', 'admin.analytics')->name('analytics');
    

});



require __DIR__.'/auth.php';
