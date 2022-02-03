<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Product;
use App\Models\ProductShop;
use App\Models\StockRequest;
use Inertia;

class Shops extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $shops = Shop::with('products')->get();        
        $products = Product::with('shops')->get();
        $product =  $products->first();
        return Inertia::render('Shops/Shop', [ "shops" => $shops , "product" => $product ,"products" => $products ]);
       // return view('pages.shops.main', compact('shops'));
    }


    public function filter_shops_by_product($id){
        $shops = Shop::with('products')->get();   
        $products = Product::all();            
        $product = Product::where('id',$id)->with('shops')->first();
        return Inertia::render('Shops/Shop', [ "shops" => $shops , "product" => $product ,"products" => $products ]);
       // return view('pages.shops.main', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = Product::all();
        return Inertia::render('Shops/NewShop', [ "products" => $products ]);
        //return view('pages.shops.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //        
        $request->request->add([ "shop_id" => $this->generateUniqueCode() ]);
        $shop = Shop::create($request->all());
        // 
        foreach($request->products as $product){
            $association = new ProductShop();
            $association->product_id = $product;
            $association->shop_id = $shop->id;
            $association->save();
        }
        
        return redirect()->route('shop.index');        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $shop = Shop::where("id",$id)->with('products')->first();
        $products = Product::all();  
        return Inertia::render('Shops/ViewShop', [ "shop" => $shop ,"products" => $products ]);
        //return view('pages.shops.show',compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $shop = Shop::find($id);
        $products = Product::all();
        $shopProducts = $shop->products->pluck('id');        
        return view('pages.shops.edit',compact('products','shop','shopProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $shop = Shop::find($id);
        $shop->update($request->all());
        // 
        $shop->products()->sync($request->products);
        $shop->save();
        return redirect()->route('shop.show',$shop->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //
        $shop = Shop::find($id);
        $shop->delete();
        // 
        return back();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateUniqueCode()
    {
        do {
            $code = 'CPS-'.random_int(100000, 999999);
        } while (Shop::where("shop_id", "=", $code)->first());
  
        return $code;
    }
}
