<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Shop;
use Cart;

class Sales extends Controller
{
    //
    public function make(){
        $shop = Shop::where('shop_name','Bhuvan Shop')->first();
        $products = collect([]);
        foreach ($shop->products as $key => $product) {
            $products->push([
                            'productName' => $product->product_name,
                            'wholesaleRate' => (empty($product->rate)) ? 0  : $product->rate->wholesale_rate,
                            'supply_rate' => (empty($product->rate)) ? 0  : $product->rate->supply_rate,
                            'retail_rate' => (empty($product->rate)) ? 0  : $product->rate->retail_rate,
                            'weight_unit' => $product->weight_unit,
                ]);
        }      
        return view('pages.sales.make',compact('products'));
    }

    public function getProducts(){
        $shop = Shop::where('shop_name','Bhuvan Shop')->first();
        $products = collect([]);
        foreach ($shop->products as $key => $product) {
            $products->push([
                            'productName' => $product->product_name,
                            'wholesaleRate' => (empty($product->rate)) ? 0  : $product->rate->wholesale_rate,
                            'supply_rate' => (empty($product->rate)) ? 0  : $product->rate->supply_rate,
                            'retail_rate' => (empty($product->rate)) ? 0  : $product->rate->retail_rate,
                            'weight_unit' => $product->weight_unit,
                ]);
        }   

        $purchaseHistory = [[ "id"=>1, "date" => '11/01/21' , "total" => 123 , "receive" => 120],["id"=>2,"date"=> '11/01/21' , "total"=> 123 , "receive" => 120]];
        // 

        return response()->json([ 
                                    "products" => $products,
                                    "purchaseHistory" =>  $purchaseHistory,
                                    "carts" => Cart::getContent()
                          ]);
    }
}
