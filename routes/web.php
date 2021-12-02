<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products;
use App\Http\Controllers\Shops;
use App\Http\Controllers\Users;
use App\Http\Controllers\Sales;
use App\Http\Controllers\Customers;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Settings;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 
Route::resource('product',Products::class);
Route::resource('shop',Shops::class);
Route::resource('user',Users::class);
Route::resource('settings',Settings::class);

Route::get('make-sale',[Sales::class,'make'])->name('make-sale');
// 
Route::post('customer/existance',[Customers::class,'customerExistance'])->name('customer.existance');
Route::post('customer/store',[Customers::class,'store'])->name('customer.store');

// 
Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('cart/remove', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('cart/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
