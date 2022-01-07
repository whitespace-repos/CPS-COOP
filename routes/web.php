<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products;
use App\Http\Controllers\Shops;
use App\Http\Controllers\Users;
use App\Http\Controllers\Sales;
use App\Http\Controllers\Customers;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Settings;
use App\Http\Controllers\Rates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Stocks;

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
Route::resource('rate',Rates::class);

Route::resource('stocks',Stocks::class);
Route::post('stock/request/submit',[Stocks::class,'requested'])->name('stock.request.submit');
Route::get('stock/request/approved/{id}',[Stocks::class,'approved'])->name('approve.stock.request');
Route::post('stock/request/payment/options/{id}',[Stocks::class,'payment_options'])->name('stock.request.payment.option');
Route::get('stock/send/{id}',[Stocks::class,'stock_send'])->name('send.stock');
Route::get('stock/received/{id}',[Stocks::class,'stock_received'])->name('received.stock');
Route::get('stock/completed/{id}',[Stocks::class,'stock_completed'])->name('completed.stock');
Route::get('stock/request/detail/{id}',[Stocks::class,'stock_request_detail'])->name('stock.request.detail');


// 
Route::get('make-sale',[Sales::class,'make'])->name('make-sale');
Route::get('fetch/products',[Sales::class,'getProducts'])->name('fetch.products');
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
    if(auth()->user()->hasRole('Admin'))
        return redirect()->route('rate.index');
    else 
        return redirect()->route('make-sale');
})->middleware(['auth'])->name('dashboard');

Route::get("clear-cache",function(){
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    Artisan::call('key:generate');
    Artisan::call('storage:link');
    return "All Done";
});



Route::get("hello",function(){
    DB::table('roles')->insert([
        'name' => 'Admin',
        'guard_name' => 'web', 
        'created_at' => '2021-11-18 02:46:57',
        'updated_at' => '2021-11-18 02:47:01',
    ]);

    DB::table('roles')->insert([
        'name' => 'Employee',
        'guard_name' => 'web', 
        'created_at' => '2021-11-18 02:46:57',
        'updated_at' => '2021-11-18 02:47:01',
    ]);

    return "working";
});


Route::get('migrate',function(){
    Artisan::call('migrate');
    dd(DB::select('SHOW TABLES'));
 });
 

 
 Route::get('rollback',function(){
    Artisan::call('migrate:rollback');
 });

require __DIR__.'/auth.php';
