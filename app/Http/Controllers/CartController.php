<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Customer;
use Product;

class CartController extends Controller
{
    //
    public function cartList()
    {
        
        $cartItems = Cart::getContent();        
        return view('cart', compact('cartItems'))->with([
                                                            "items" => $cartItems->pluck('items')
        ]);
    }


    public function addToCart(Request $request)
    {        
        $customer = Customer::where('phone',$request->customer)->first();
        // 
        $product = Product::where('product_name',$request->product)->first();
        $wholeSaleRate = $product->rate->wholesale_rate;
        $retailRate = $product->rate->retail_rate;
        $weight = (float) $request->weight;
        
        // 
        $price = ($weight < 10) ? $weight * $retailRate : $weight * $wholeSaleRate;
        // 
        $cart = Cart::add([
            'id' => Cart::getTotalQuantity() + 1,
            'name' => $product->product_name,
            'price' =>$price,  
            'quantity' => 1,          
            'attributes' => array(
                "customer" => $customer,
                "weight" => $weight,
                "rate" => ($weight < 10) ? $retailRate : $wholeSaleRate,
            )
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');
        return response()->json(Cart::getContent());
    }

    public function updateCart(Request $request)
    {
        Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return response()->json(Cart::getContent());
    }

    public function clearAllCart()
    {
        Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return back();
    }
}
