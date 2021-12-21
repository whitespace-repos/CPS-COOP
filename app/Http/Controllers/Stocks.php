<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stock;
use StockRequest;

class Stocks extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stocks = StockRequest::all();
        return view('pages.stocks.main',compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * 
     */
    public function requested(Request $request){        
        $shop = auth()->user()->shop;        
        foreach ($shop->products as $key => $product) {
            if($request->filled($product->id))
                StockRequest::create([
                                            "shop_id" => $shop->id,
                                            "product_id" => $product->id,
                                            "stock_request" => $request->get($product->id),
                                            "stock_requested_by" => auth()->id(),
                                            "payment_method" => $request->payment_method,
                                            "payment_period" => $request->payment_period,
                ]);
            
        }
        // 
        return back();
    }
}
