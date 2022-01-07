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
        $products = $shop->products;
        
        // foreach ($shop->products as $key => $product) {
        //     $products->push(collect([
        //                     'id' => $product->id,
        //                     'productName' => $product->product_name,
        //                     'wholesaleWeight' => $product->wholesale_weight,
        //                     'wholesaleRate' => (empty($product->rate)) ? 0  : $product->rate->wholesale_rate,
        //                     'supply_rate' => (empty($product->rate)) ? 0  : $product->rate->supply_rate,
        //                     'retail_rate' => (empty($product->rate)) ? 0  : $product->rate->retail_rate,
        //                     'weight_unit' => $product->weight_unit,
        //                     'productImage' => $product->product_image,
        //                     'stock' => $product->stock,
        //         ]));
        // } 
        
        //return view('layouts.coop');     
        return view('pages.sales.make',compact('products'));
    }

    public function getProducts(){
        $shop = auth()->user()->shop;
        $products = collect([]);
        foreach ($shop->products as $key => $product) {
            $products->push([
                            'id' => $product->id,
                            'productName' => $product->product_name,
                            'wholesaleRate' => (empty($product->rate)) ? 0  : $product->rate->wholesale_rate,
                            'supply_rate' => (empty($product->rate)) ? 0  : $product->rate->supply_rate,
                            'retail_rate' => (empty($product->rate)) ? 0  : $product->rate->retail_rate,
                            'weight_unit' => $product->weight_unit,
                            'wholesaleWeight' => $product->wholesale_weight,
                            'productImage' => $product->product_image,
                            'stock' => $product->stock,
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
