<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Customer;
use Cart;
use Inertia;

class Customers extends Controller
{
    //

    public function customerExistance(Request $request){
        $customer = Customer::where('phone',$request->phone)->first();
      
        return response()->json([
                                    "existingCustomer" => empty($customer) ? false : true,
                                    "customer" => $customer
        ]);
    }

    public function store(Request $request){
        //         
        $customer = Customer::create($request->all());
        return Inertia::render('Sale/Make', [
                                                "existingCustomer" => true,
                                                "customer" => $customer,
                                                "totalCartItem" => Cart::getTotalQuantity(),
                                                "url" => route('make-sale')
            ]);
        // return response()->json([
        //                             "existance" => true,
        //                             "customer" => $customer,
        //                             "totalCartItem" => Cart::getTotalQuantity(),
        // ]);
    }

    
}
