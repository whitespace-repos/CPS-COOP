<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Customer;
use Product;
use Inertia;
use PurchaseHistory;
use Carbon;
use Sale;
use Twilio\Rest\Client;

class CartController extends Controller
{
    private $weight;
    private $cartItems;

    public function __construct()
    {
       
    }
    //
    public function cartList()
    {
        
        $cartItems = Cart::getContent(); 
        
        // 
        // $receiverNumber = $cartItems->first()->attributes->customer->phone;
        // $message = "This is testing from ItSolutionStuff.com";  
        // try {
  
        //     $account_sid = getenv("TWILIO_ACCOUNT_SID");
        //     $auth_token = getenv("TWILIO_AUTH_TOKEN");
              
        //     $client = new Client($account_sid, $auth_token);
        //     $client->messages->create($receiverNumber, [
        //         'from' => '+18596961154', 
        //         'body' => $message]);              
        // } catch (Exception $e) {
        //     dd("Error: ". $e->getMessage());
        // }

        return Inertia::render('Sale/Cart', [
                                                "carts" => Cart::getContent(),
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
        $this->weight = (float) $request->weight;
        $ranges = collect(json_decode($product->rate->wholesale_rate),true);                
        $wholesale = $ranges->filter(function ($range, $key) {                            
            return ($range->from <= $this->weight && $this->weight <= $range->to); 
        });      
         
        $retail = empty($product->rate) ? 0 : $product->rate->retail_rate;
        $rate = ($wholesale->count() == 0)  ? (float) $retail : (float) $wholesale->first()->rate;
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
                "product" => $product,
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

    public function checkout(Request $request){             
        $this->cartItems = Cart::getContent();      
        $cartItems = Cart::getContent(); 
        $products = Product::with(['shops' => function ($query) {
                        $query->where('shops.id', auth()->user()->shop->id);
                    }])->get();        
        foreach ($cartItems as $key => $cart) { 
            //            
            $product = $products->find($cart->attributes->product->id);
            $currentStock = $product->shops->first()->association;
            // 
            $currentStock->stock -= $cart->attributes->weight;
            $currentStock->save();

            $sale = Sale::create([
                        "date" => Carbon::today(),
                        "total" => $request->total,
                        "receive" =>($request->receive == 0 || empty($request->receive)) ? $request->total : $request->receive,
                        "quantity" => $cart->attributes->weight,
                        "sold_by" => auth()->id(),
                        "product_id" => $product->id,
                        "shop_id" => auth()->user()->shop->id,
                        "cart" => Cart::getContent()->toJson(),
            ]);

            //               
        }      
        $history = PurchaseHistory::create([
                    "date" => Carbon::today(),
                    "total" => $request->total,
                    "receive" =>$request->receive,
                    "quantity" => Cart::getContent()->count(),
                    "sold_by" => auth()->id(),
                    "shop_id" => auth()->user()->shop->id,
                    "cart" => Cart::getContent()->toJson(),
        ]);   
        // 
        Cart::clear();        
        return redirect()->route('make-sale');
    }

    public function printReceipt(){
        $this->cartItems = Cart::getContent(); 
        return view('print')->with(["carts" => $this->cartItems ]);        
    }
}
