<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Shop;
use Cart;
use PurchaseHistory;

class Sales extends Controller
{
    //
    public function make(){
        $shop = auth()->user()->shop;
        $products = collect([]);
        foreach ($shop->products as $key => $product) {
            $products->push([
                            'productName' => $product->product_name,
                            'wholesaleWeight' => $product->wholesale_weight,
                            'wholesaleRate' => (empty($product->rate)) ? 0  : $product->rate->wholesale_rate,
                            'supply_rate' => (empty($product->rate)) ? 0  : $product->rate->supply_rate,
                            'retail_rate' => (empty($product->rate)) ? 0  : $product->rate->retail_rate,
                            'weight_unit' => $product->weight_unit,
                ]);
        }      
        return view('pages.sales.make',compact('products'));
    }

    public function getProducts(){
        $shop = auth()->user()->shop;
        $products = collect([]);
        foreach ($shop->products as $key => $product) {
            $products->push([
                            'productName' => $product->product_name,
                            'wholesaleRate' => (empty($product->rate)) ? 0  : $product->rate->wholesale_rate,
                            'supply_rate' => (empty($product->rate)) ? 0  : $product->rate->supply_rate,
                            'retail_rate' => (empty($product->rate)) ? 0  : $product->rate->retail_rate,
                            'weight_unit' => $product->weight_unit,
                            'wholesaleWeight' => $product->wholesale_weight,
                ]);
        }   

        $purchaseHistory = PurchaseHistory::all();
        // 

        return response()->json([ 
                                    "products" => $products,
                                    "purchaseHistory" =>  $purchaseHistory,
                                    "carts" => Cart::getContent()
                          ]);
    }
}
