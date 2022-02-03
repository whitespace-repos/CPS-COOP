<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rate;
use Product;
use Carbon;
use Inertia;
use ProductWholesaleRateRange;

class Rates extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = NULL)
    {        
        //
        $rates = Rate::where( 'date', Carbon::today())
                        ->with('product.weightRanges')
                        ->where('status','Active')
                        ->get();

        \Log::info($rates);
        //return view('pages.rates.main',compact('rates'));
        $products = Product::all();
        if(empty($id))
            $id = empty($products) ? null : $products->first()->id;
        //
        $product = Product::where('id',$id)->with('shops','weightRanges')->first();

        return Inertia::render('Rate/Rates', ["products" => $products ,"selectedProduct" => $product , "rates" => $rates ]);
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
        return view('pages.rates.create',compact('products'));
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
        $product = Product::find($request->product_id);
        //   
        $productTodayRate = Rate::where( 'date', Carbon::today())
                        ->where('status','Active')
                        ->where('product_id',$product->id)
                        ->first();
        if(!empty($productTodayRate)){
            $productTodayRate->status = 'Inactive';
            $productTodayRate->save();
        }        
        // 
        $request->request->add(['date' => Carbon::today()]);        
        Rate::create($request->all());
       

        // Save Whole weight Range Rate
        foreach($product->weightRanges as $key => $range){              
            $weightRange = ProductWholesaleRateRange::find($range->id);
            $weightRange->wholesale_rate = (empty($request->range["range-".$range->id])) ? 0 : $request->range["range-".$range->id];                
            $weightRange->save();            
        }

        return redirect()->route('rate.index');
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
        $rates = Rate::where( 'date', Carbon::today())
                                ->with('product.weightRanges')
                                ->where('status','Active')
                                ->get();
        $products = Product::all();
        $product = Product::where('id',$id)->with('shops','weightRanges')->first();
        return Inertia::render('Rate/Rates', ["products"=> $products , "selectedProduct" => $product , "rates" => $rates ]);
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
        $rate = Rate::with('product.weightRanges')->where("id",$id)->first();
        return response()->json($rate);
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
            \Log::info($id);
            \Log::info($request);
        
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
}
