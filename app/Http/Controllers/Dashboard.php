<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use User;
use DB;
use Inertia;

class Dashboard extends Controller
{
    //
    public function index(){
        $suppliers = (auth()->user()->hasRole('Admin'))
                                                            ?  User::role('Supplier')->with('shops.products.rate')->get()
                                                            :  User::with('shops.products.rate')->where('id',auth()->id())->get();
        //
        foreach($suppliers as $supplier){
            if($supplier->shops->count() > 0 ){
                $supplier->shops->map(function($shop){
                    if($shop->products->count() > 0){
                        $shop->products->map(function($product) use ($shop){
                            if($shop->today_sales->count() > 0){
                                $sale = $shop
                                                        ->today_sales()
                                                        ->select(DB::raw('SUM(receive) as total_sales'))
                                                        ->orderBy('created_at','desc')
                                                        ->where('product_id',$product->id)
                                                        ->groupBy('product_id')
                                                        ->first();
                                $product->today_sale = empty($sale) ? 0 : $sale->total_sales;
                            }else{
                                $product->today_sale = 0;
                            }
                            return $product;
                        });
                    }
                    //
                    return $shop;
                });
            };
        }
        //
        return Inertia::render('Dashboard', [ "suppliers" => $suppliers ]);
    }
}
