<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/user-register', [AuthController::class, 'registerUser'])->name('user.register');
Route::post('/user-login', [AuthController::class, 'login'])->name('user.login');

// Frontend
Route::get('/', [FrontProductController::class,'index'])->name('home');
Route::get('/products/{id}', [FrontProductController::class,'show'])->name('products.show');

// Cart & checkout
Route::get('/cart', [CartController::class,'view'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class,'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class,'remove'])->name('cart.remove');
Route::post('/cart/apply-coupon',[CartController::class,'applyCoupon'])->name('cart.coupon');
Route::post('/cart/checkout',[CartController::class,'checkout'])->name('cart.checkout');
Route::get('/cart/completed/{orderId}',[CartController::class,'completed'])->name('cart.completed');
Route::put('cart/{id}', [CartController::class, 'update'])
    ->name('cart.update');



Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    Route::get('products/import', [ProductController::class, 'createImport'])
        ->name('products.import');
    Route::post('products/import', [ProductController::class, 'import'])
        ->name('products.import.store');
        
    Route::resource('products', ProductController::class); 
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    

        

});
