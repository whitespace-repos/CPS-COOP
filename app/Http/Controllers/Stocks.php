<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stock;
use StockRequest;
use Shop;
use App\Models\StockRequestedProduct;

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
        //$stocks = StockRequest::all();
        //return view('pages.stocks.main',compact('stocks'));
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
        $stockRequest = StockRequest::create([
                                                "shop_id" => $shop->id,                                       
                                                "stock_requested_by" => auth()->id(),
                                                "payment_method" => $request->payment_method,
                                                "payment_period" => $request->payment_period,
                                                "status" => "Requested"
                                        ]);
        /* ***** */

        foreach ($shop->products as $key => $product) {           
            if($request->filled($product->id)){
                StockRequestedProduct::create([
                    "stock_request_id" => $stockRequest->id,
                    "product_id" => $product->id,
                    "stock_request" => $request->get($product->id),
                    "current_stock" => $product->association->stock,
                    "status" => "Requested"
                ]);
            }            
        }
        // 
        return back();
    }

    public function approved(Request $request,$id){        
        $stockRequest = StockRequest::find($id);
        $stockRequest->status = 'Approved';
        $stockRequest->supply_rate = $request->supply_rate;
        $stockRequest->save();
        // 
        $stockRequest->requested_products()->update([ 'status' => 'Approved' ]);
        return back();
    }

    public function payment_options(Request $request , $id){
        $stockRequest = StockRequest::find($id);
        $stockRequest->payment_method = $request->payment_option;
        $stockRequest->payment_period  =  $request->payment_option_period;
        $stockRequest->status = 'Processing';
        $stockRequest->save();
        // 
        $stockRequest->requested_products()->update([ 'status' => 'Processing' ]);
        return back();
    }

    public function stock_send(Request $request,$id){
        $stockRequest = StockRequest::find($id);
        $stockRequest->status = 'Sent';
        $stockRequest->save();
        // 
        foreach($stockRequest->requested_products as $rp){
            if($request->filled($rp->id)){
                $rp->stock_sent = $request->get($rp->id);
                $rp->status = 'Sent';
                $rp->save();
            }
        }
        return back();
    }

    public function stock_completed($id){
        $stockRequest = StockRequest::find($id);
        $stockRequest->status = 'Completed';
        $stockRequest->save();
        // 
        $stockRequest->requested_products()->update([ 'status' => 'Completed' ]);
        return back();
    }

    public function stock_received(Request $request , $id){
        if(auth()->user()->hasRole('Employee')){
            $shop = auth()->user()->shop;
            $stockRequest = StockRequest::find($id);
            $stockRequest->status = 'Received';
            $stockRequest->save();

            foreach($stockRequest->requested_products as $product){ 
                
                if($request->filled($product->id)){
                    $product->stock_received = $request->get($product->id);
                    $product->stock_wastage = (float) $product->stock_sent - (float) $request->get($product->id);
                    $product->save();
                }

                $p = $shop->products()->find($product->product_id);
                $assoc = $p->association;
                $assoc->stock += $product->stock_request;
                $assoc->save();
            }                
            $stockRequest->requested_products()->update([ 'status' => 'Received' ]);
        }       
       return redirect()->route('make-sale');
    }

    public function stock_request_detail($id){
        $stockRequest = StockRequest::find($id);
        return view('pages.stocks.stockRequestDetail',compact('stockRequest'));
    }
}
