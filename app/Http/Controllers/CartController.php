<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Customer;

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

        \Log::info($request);
        // 
        $cart = Cart::add([
            'id' => Cart::getTotalQuantity() + 1,
            'name' => $request->product,
            'price' => $request->amount,  
            'quantity' => 1,          
            'attributes' => array(
                "customer" => $customer,
                "weight" => $request->weight,
                "rate" => $request->rate,
            )
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');
        return response()->json([
                                    "cart" => $cart ,
                                    "customer" => $customer,
                                    "totalCartItem" => Cart::getTotalQuantity(),
        ]);
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

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return back();
    }
}
