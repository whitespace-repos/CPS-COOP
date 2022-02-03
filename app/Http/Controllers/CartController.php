<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Customer;
use Product;
use Inertia;

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
        
        // let $el = $(event.target) ,
        // weight = $el.val(),
        // wholesale = _.find($el.data('wholesaleRange'), function(r) { return  (r.from <= weight && weight <= r.to) ; }),
        // retail = $el.data('retailRate'),
        // rate = (_.isNaN(wholesale) || _.isNil(wholesale)) ? parseFloat(retail) : parseFloat(wholesale.wholesale_rate),
        // product = $el.data('product'),
        // productId = $el.data('productId'),
        // totalCost = parseFloat(rate) * parseFloat(weight);


        $customer = Customer::where('phone',$request->customer)->first();
        // 
        $product = Product::with('weightRanges')->where("id",$request->product)->first();
        $weight = (float) $request->weight;
        try {
            $wholesale = $product->weightRanges->sole(function ($range, $key) {
                            return ($range->from <= 92 && 92 <= $range->to); 
                        });
        } catch (\Throwable $th) {
            $wholesale = null;
        } 
        $retail = empty($product->rate) ? 0 : $product->rate->retail_rate;
        $rate = (empty($wholesale))  ? (float) $retail : (float) $wholesale->wholesale_rate;
        // 
        $weight = (float) $request->weight;        
        // 
        $price = $weight * $rate; 
        // 
        $cart = Cart::add([ 
            'id' => Cart::getTotalQuantity() + 1,
            'name' => $product->product_name,
            'price' =>$price,  
            'quantity' => 1,          
            'attributes' => array(
                "customer" => $customer,
                "weight" => $weight,
                "rate" => $rate,
                "type" => $request->type    
            )
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');
        return Inertia::render('Sale/Make', ["carts" => Cart::getContent() ]);
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
        return Inertia::render('Sale/Make', ["carts" => Cart::getContent() ]);
    }

    public function clearAllCart()
    {
        Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return back();
    }
}
