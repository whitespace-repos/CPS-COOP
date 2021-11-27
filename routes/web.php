<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employees;
use App\Http\Controllers\Rates;
use App\Http\Controllers\Sales;
use Illuminate\Http\Request;

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


Route::resource('employee',Employees::class);
Route::resource('rate',Rates::class);
Route::resource('sales',Sales::class);
// 
Route::post('broiler/live/sales',[Sales::class,'broiler_live'])->name('broiler.live.sales');
Route::post('broiler/chicken/sales',[Sales::class,'broiler_chicken'])->name('broiler.chicken.sales');
Route::post('layer/sales',[Sales::class,'layers_sales'])->name('layer.sales');
Route::post('egg/sales',[Sales::class,'egg_sales'])->name('egg.sales');
// 
Route::get('sale/tab/{table}',[Sales::class,'load_current_sales_tab'])->name('load.current.sales.tab');
Route::get('add/rate',function(){
        return view('pages.rates.modal.add');
})->name('add.rate');

Route::get('print',function(){
    return view('pages.sales.print');
})->name('print');


Route::get('reset',function(Request $request){
    $request->session()->forget('cart');
    return redirect()->route('sales.create');
})->name('reset');

Route::get('sale/get/customer',[Sales::class,'getCustomerByPhone'])->name('get.customer.by.phone');

Route::get('sale/view',[Sales::class,'view_all_sales_data'])->name('view.all.sales.data');
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// require __DIR__.'/auth.php';
