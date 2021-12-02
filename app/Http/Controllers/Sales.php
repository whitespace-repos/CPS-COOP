<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class Sales extends Controller
{
    //
    public function make(){
        $products = Product::all();
        return view('pages.sales.make',compact('products'));
    }
}
