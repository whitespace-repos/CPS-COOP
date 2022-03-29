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
        $customer = Customer::with('purchase_history.product')->where('phone',$request->phone)->first();
        $history =  empty($customer) ? null : $customer->purchase_history;
        return response()->json([
                                    "existingCustomer" => empty($customer) ? false : true,
                                    "customer" => $customer,
                                    "purchase_history" => $history
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
