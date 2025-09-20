<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductAdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/',[ProductController::class,'index'])->name('home');
Route::get('/products/{product:slug}', [ProductController::class,'show'])->name('products.show');

# Cart
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class,'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class,'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class,'remove'])->name('cart.remove');

# Checkout (auth required)
Route::get('/checkout', [CheckoutController::class,'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');
// Route::middleware('auth')->group(function(){
// });

# Admin routes
Route::prefix('admin')->middleware(['auth','isAdmin'])->name('admin.')->group(function(){
    Route::resource('products', ProductAdminController::class);
});

require __DIR__.'/auth.php';
